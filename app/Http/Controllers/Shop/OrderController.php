<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shop = auth()->user()->shop ?? auth()->user()->ownedShop;

        $orders = $shop->orders()->with('customer')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_key', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($cq) use ($search) {
                            $cq->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->status, function ($query, $status) {
                if ($status !== 'all') {
                    $query->where('status', $status);
                }
            })
            ->when($request->payment_status, function ($query, $paymentStatus) {
                if ($paymentStatus === 'paid') {
                    $query->where('remaining_amount', '<=', 0);
                } elseif ($paymentStatus === 'unpaid') {
                    $query->where('remaining_amount', '>', 0);
                }
            })
            ->latest()
            ->paginate($request->get('per_page', 30));

        if ($request->ajax()) {
            return view('shop.orders._table', compact('orders'))->render();
        }

        return view('shop.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Customer::when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        })->limit(10)->get();

        $selectedCustomer = $request->customer_id ? Customer::find($request->customer_id) : null;

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['customers' => $customers]);
        }

        return view('shop.orders.create', compact('customers', 'selectedCustomer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'start_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'total_price' => 'required|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed,delivered',
            'notes' => 'nullable|string',
        ]);

        // Default values for NOT NULL columns
        $validated['start_date'] = $validated['start_date'] ?? now();
        $validated['advance_payment'] = $validated['advance_payment'] ?? 0;
        $validated['remaining_amount'] = $validated['remaining_amount'] ?? ($validated['total_price'] - $validated['advance_payment']);

        // Generate a unique Order Number
        $validated['order_key'] = 'ORD-'.random_int(10000000, 99999999);
        $validated['shop_id'] = auth()->user()->shop_id;

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('shop.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::all();

        return view('shop.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'start_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'total_price' => 'required|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,in_progress,completed,delivered',
            'notes' => 'nullable|string',
        ]);

        // Default values for NOT NULL columns
        $validated['start_date'] = $validated['start_date'] ?? $order->start_date;
        $validated['advance_payment'] = $validated['advance_payment'] ?? 0;
        $validated['remaining_amount'] = $validated['remaining_amount'] ?? ($validated['total_price'] - $validated['advance_payment']);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|in:status,fulfill',
            'status' => 'nullable|required_if:action,status|in:pending,in_progress,completed,delivered',
        ]);

        $orderIds = $request->order_ids;
        $count = 0;
        $message = '';

        if ($request->action === 'status') {
            $count = Order::whereIn('id', $orderIds)
                ->where('shop_id', auth()->user()->shop_id)
                ->update(['status' => $request->status]);
            $message = "Successfully updated {$count} orders to ".ucfirst(str_replace('_', ' ', $request->status));
        } elseif ($request->action === 'fulfill') {
            $orders = Order::whereIn('id', $orderIds)
                ->where('shop_id', auth()->user()->shop_id)
                ->where('remaining_amount', '>', 0)
                ->get();

            $totalAmount = 0;
            foreach ($orders as $order) {
                $totalAmount += $order->remaining_amount;
                $order->remaining_amount = 0;
                $order->save();
                $count++;
            }
            $message = "{$count} orders fully paid. Total amount recovered: Rs. ".number_format($totalAmount);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('orders.index')->with('success', $message);
    }
}
