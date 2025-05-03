<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends BaseController
{
    // list order
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'laundry', 'service'])
            ->where('laundry_id', $request->user()->laundry_id);

        // Filter by status
        if ($request->has('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }

        // Filter by service_id
        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('order_date', [$request->start_date, $request->end_date]);
        }

        // Search by customer name or phone
        if ($request->has('search')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 5);
        $orders = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
            'meta' => [
                'total_orders' => $orders->total(),
                'total_pages' => $orders->lastPage(),
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string',
                'laundry_id' => 'required|exists:laundries,id',
                'service_id' => 'required|exists:services,id',
                'weight' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'note' => 'nullable|string',
                'order_date' => 'nullable|date_format:Y-m-d H:i:s',
                'phone' => 'nullable|string|max:15',
                'username' => 'nullable|string|max:50|unique:customers,username',
            ];

            // Validasi tanpa required_without
            $request->validate($rules);

            $phone = $request->phone ? $this->formatPhoneNumber($request->phone) : null;
            $username = $request->username;

            $customer = null;
            if ($phone) {
                $customer = Customer::where('phone', $phone)->first();
            } elseif ($username) {
                $customer = Customer::where('username', $username)->first();
            }

            if ($request->laundry_id !== $request->user()->laundry_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid laundry ID'
                ], 403);
            }

            $service = Service::where('id', $request->service_id)
                ->where('laundry_id', $request->laundry_id)
                ->first();

            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid service for the selected laundry'
                ], 422);
            }

            if (!$customer) {
                // Generate username otomatis jika tidak disediakan
                if (!$username && !$phone) {
                    // Konversi nama menjadi username (hapus spasi, lowercase, tambahkan angka jika duplikat)
                    $baseUsername = Str::slug($request->name, '');
                    $username = $baseUsername;
                    $counter = 1;
                    while (Customer::where('username', $username)->exists()) {
                        $username = $baseUsername . $counter;
                        $counter++;
                    }
                }

                $customer = Customer::create([
                    'name' => $request->name,
                    'phone' => $phone,
                    'username' => $username,
                ]);
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'laundry_id' => $request->laundry_id,
                'service_id' => $request->service_id,
                'weight' => $request->weight,
                'total_price' => $request->total_price,
                'note' => $request->note ?? null,
                'barcode' => 'ORD-' . uniqid(),
                'status' => 'pending',
                'order_date' => $request->order_date ?? now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => new OrderResource($order->load(['customer', 'laundry', 'service']))
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => new OrderResource($order->load(['customer', 'laundry', 'service']))
        ], 200);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,washed,dried,ironed,ready_picked,completed,cancelled'
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => new OrderResource($order->load(['customer', 'laundry', 'service']))
        ], 200);
    }

    public function getByBarcode($barcode)
    {
        $order = Order::with(['customer', 'laundry'])
            ->where('barcode', $barcode)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order)
        ], 200);
    }

    public function checkCustomer(Request $request, $identifier)
    {
        try {
            $customer = null;

            if (preg_match('/^[0-9+]/', $identifier)) {
                $formattedPhone = $this->formatPhoneNumber($identifier);
                $customer = Customer::where('phone', $formattedPhone)->first();
            } else {
                // Jika bukan nomor telepon, anggap sebagai username
                $customer = Customer::where('username', $identifier)->first();
            }

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => (string) $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'username' => $customer->username,
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error('Check customer error: ' . $e->getMessage(), ['identifier' => $identifier]);
            return response()->json([
                'success' => false,
                'message' => 'Error processing request: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function searchCustomers(Request $request)
    {
        try {
            $query = $request->query('name', '');
            $customers = Customer::where('name', 'like', "%{$query}%")
                ->take(5)
                ->get(['id', 'name', 'phone', 'username']);

            return response()->json([
                'success' => true,
                'data' => $customers,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Search customers error: ' . $e->getMessage(), ['query' => $request->query('name')]);
            return response()->json([
                'success' => false,
                'message' => 'Error processing request: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function statistics(Request $request)
    {
        try {
            $request->validate([
                'period' => 'required|in:daily,monthly',
                'months' => 'sometimes|integer|min:1|max:12', // Opsional untuk periode bulanan
            ]);

            $laundryId = $request->user()->laundry_id;
            $period = $request->period;
            $months = $request->input('months', 6); // Default 6 bulan jika tidak disediakan

            Log::info('Statistics request', [
                'laundry_id' => $laundryId,
                'period' => $period,
                'months' => $months,
            ]);

            if ($period === 'daily') {
                // Statistik harian (30 hari terakhir)
                $startDate = Carbon::today()->subDays(30);
                $endDate = Carbon::today();

                $data = Order::selectRaw('DATE(order_date) as date, COUNT(*) as count, SUM(total_price) as revenue')
                    ->where('laundry_id', $laundryId)
                    ->whereBetween('order_date', [$startDate, $endDate])
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'date' => $item->date,
                            'count' => (int) $item->count,
                            'revenue' => (float) $item->revenue,
                        ];
                    });

                // Isi tanggal kosong dengan 0 untuk konsistensi chart
                $result = [];
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    $dateStr = $currentDate->format('Y-m-d');
                    $found = $data->firstWhere('date', $dateStr);
                    $result[] = [
                        'date' => $dateStr,
                        'count' => $found ? $found['count'] : 0,
                        'revenue' => $found ? $found['revenue'] : 0.0,
                    ];
                    $currentDate->addDay();
                }

                return response()->json([
                    'success' => true,
                    'data' => $result,
                    'message' => 'Daily statistics retrieved successfully',
                ], 200);
            } else {
                // Statistik bulanan
                $startDate = Carbon::today()->subMonths($months)->startOfMonth();
                $endDate = Carbon::today()->endOfMonth();

                $data = Order::selectRaw('DATE_FORMAT(order_date, "%Y-%m") as month, COUNT(*) as count, SUM(total_price) as revenue')
                    ->where('laundry_id', $laundryId)
                    ->whereBetween('order_date', [$startDate, $endDate])
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'month' => $item->month,
                            'count' => (int) $item->count,
                            'revenue' => (float) $item->revenue,
                        ];
                    });
                // Isi bulan kosong dengan 0 untuk konsistensi chart
                $result = [];
                $currentMonth = $startDate->copy();
                while ($currentMonth <= $endDate) {
                    $monthStr = $currentMonth->format('Y-m');
                    $found = $data->firstWhere('month', $monthStr);
                    $result[] = [
                        'month' => $monthStr,
                        'count' => $found ? $found['count'] : 0,
                        'revenue' => $found ? $found['revenue'] : 0.0,
                    ];
                    $currentMonth->addMonth();
                }

                return response()->json([
                    'success' => true,
                    'data' => $result,
                    'message' => 'Monthly statistics retrieved successfully',
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error('Statistics error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function trackOrders(Request $request, $identifier)
    {
        try {
            $request->merge(['identifier' => $identifier]);
            $request->validate([
                'identifier' => 'required|string|max:50',
            ]);

            $customer = null;

            // Coba cari berdasarkan phone
            if (preg_match('/^[0-9+]/', $identifier)) {
                $normalizedPhone = $this->formatPhoneNumber($identifier);
                $customer = Customer::where('phone', $normalizedPhone)->first();
            } else {
                // Jika bukan nomor telepon, anggap sebagai username
                $customer = Customer::where('username', $identifier)->first();
            }

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            $query = Order::with(['customer', 'laundry', 'service'])
                ->where('customer_id', $customer->id)
                ->orderBy('order_date', 'desc')
                ->orderBy('id', 'desc');

            $perPage = $request->get('per_page', 10);
            $orders = $query->paginate($perPage);

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'meta' => [
                        'total_orders' => 0,
                        'total_pages' => 0,
                        'current_page' => 1,
                        'per_page' => (int)$perPage,
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => OrderResource::collection($orders->items()),
                'meta' => [
                    'total_orders' => $orders->total(),
                    'total_pages' => $orders->lastPage(),
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Track orders error: ' . $e->getMessage(), ['identifier' => $identifier]);
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving orders',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
