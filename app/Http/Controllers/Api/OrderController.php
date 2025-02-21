<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'laundry']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
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
        $perPage = $request->get('per_page', 10);
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
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'laundry_id' => 'required|exists:laundries,id',
            'type' => 'required|in:regular,express',
            'weight' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'note' => 'nullable|string'
        ]);

        // Generate unique barcode
        $validated['barcode'] = 'ORD-' . uniqid();
        // Set initial status
        $validated['status'] = 'pending';

        $order = Order::create($validated);
        $order->load(['customer', 'laundry']);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => new OrderResource($order)
        ], 201);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,washed,dried,ironed,ready_picked,completed,cancelled'
        ]);

        $order->update([
            'status' => $validated['status']
        ]);

        $order->load(['customer', 'laundry']);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => new OrderResource($order)
        ], 200);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'laundry']);

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order)
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
}
