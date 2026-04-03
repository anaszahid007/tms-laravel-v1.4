<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shop = auth()->user()->shop ?? auth()->user()->ownedShop;

        $customers = $shop->customers()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('father_name', 'ilike', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('customer_key', 'ilike', "%{$search}%");
                });
            })
            ->withCount('measurements')
            ->latest()
            ->paginate(10);
            
        if ($request->ajax()) {
            return view('shop.customers._table', compact('customers'))->render();
        }

        return view('shop.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'required|in:male,female,other',
        ]);

        $validated['shop_id'] = auth()->user()->shop->id;
        $validated['customer_key'] = 'CUST-'.strtoupper(\Illuminate\Support\Str::random(8));

        $customer = Customer::create($validated);

        if ($request->has('add_measurements')) {
            return redirect()->route('measurements.create', ['customer_id' => $customer->id])
                ->with('success', 'Customer created. Now add measurements.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('shop.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('shop.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'required|in:male,female,other',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Search customers for AJAX.
     */
    public function search(Request $request)
    {
        $search = $request->get('query');
        $shop = auth()->user()->shop ?? auth()->user()->ownedShop;

        if (!$shop) {
            return response()->json([]);
        }
        
        $customers = $shop->customers()
            ->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('father_name', 'ilike', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_key', 'ilike', "%{$search}%");
            })
            ->limit(5)
            ->get();
            
        return response()->json($customers);
    }
}
