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
            $phone = $this->formatPhoneNumber($request->phone);

            if (!str_starts_with($phone, '8')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid phone number format'
                ], 422);
            }

            $customer = Customer::where('phone', $phone)->first();

            $rules = [
                'phone' => 'required',
                'laundry_id' => 'required|exists:laundries,id',
                'service_id' => 'required|exists:services,id',
                'weight' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'note' => 'nullable|string',
                'order_date' => 'nullable|date_format:Y-m-d H:i:s'
            ];

            if (!$customer) {
                $rules['name'] = 'required|string';
            }

            $validated = $request->validate($rules);

            // Validasi bahwa laundry_id sesuai dengan pengguna yang login
            if ($validated['laundry_id'] !== $request->user()->laundry_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid laundry ID'
                ], 403);
            }
            $service = Service::where('id', $validated['service_id'])
                ->where('laundry_id', $validated['laundry_id'])
                ->first();
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid service for the selected laundry'
                ], 422);
            }

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $validated['name'],
                    'phone' => $phone
                ]);
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'laundry_id' => $validated['laundry_id'],
                'service_id' => $validated['service_id'],
                'weight' => $validated['weight'],
                'total_price' => $validated['total_price'],
                'note' => $validated['note'] ?? null,
                'barcode' => 'ORD-' . uniqid(),
                'status' => 'pending',
                'order_date' => $validated['order_date'] ?? now(),
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

    public function checkCustomer(Request $request, $phone)
    {
        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }

        $orders = Order::where('customer_id', $customer->id)->get();

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
        ], 200);
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

    private function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika diawali dengan +62 atau 62, hapus kode negara
        if (str_starts_with($phone, '+62')) {
            $phone = substr($phone, 3); // Hapus +62
        } elseif (str_starts_with($phone, '62')) {
            $phone = substr($phone, 2); // Hapus 62
        } elseif (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1); // Hapus 0
        }

        // minimum 9 digit
        if (strlen($phone) < 9) {
            throw new \Exception('Invalid phone number length');
        }

        return $phone;
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

    public function trackOrders(Request $request, $phone)
    {
        try {
            $request->merge(['phone' => $phone]);
            $request->validate([
                'phone' => 'required|string|max:15',
            ]);

            $normalizedPhone = $this->formatPhoneNumber($phone);

            $customer = Customer::where('phone', $normalizedPhone)->first();

            if (!$customer) {
                return $this->sendError('Customer not found', [], 404);
            }

            // Ambil order untuk customer, urutkan dari terbaru
            $query = Order::with(['customer', 'laundry'])
                ->where('customer_id', $customer->id)
                ->orderBy('order_date', 'desc')
                ->orderBy('id', 'desc');

            // Pagination
            $perPage = $request->get('per_page', 10);
            $orders = $query->paginate($perPage);

            if ($orders->isEmpty()) {
                return $this->sendResponse([], 'No orders found for this customer');
            }

            return $this->sendResponse(
                [
                    'orders' => OrderResource::collection($orders),
                    'meta' => [
                        'total_orders' => $orders->total(),
                        'total_pages' => $orders->lastPage(),
                        'current_page' => $orders->currentPage(),
                        'per_page' => $orders->perPage(),
                    ],
                ],
                'Orders retrieved successfully'
            );
        } catch (\Exception $e) {
            Log::error('Track orders error: ' . $e->getMessage(), ['phone' => $phone]);
            return $this->sendError('Error retrieving orders', ['error' => $e->getMessage()], 400);
        }
    }
}
