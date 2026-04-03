<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shop = auth()->user()->shop ?? auth()->user()->ownedShop;
        // measurements are usually shown under a customer, so maybe just redirect back or show all?
        // Let's assume this view shows recent measurements
        $measurements = Measurement::with('customer')->where('shop_id', $shop->id)->latest()->paginate(10);

        return view('shop.measurements.index', compact('measurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customer_id = $request->query('customer_id');
        $customer = Customer::findOrFail($customer_id);
        $language = $request->query('lang', 'en'); // Default to English

        $standardFields = $this->getStandardFields();

        return view('shop.measurements.create', compact('customer', 'customer_id', 'language', 'standardFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'data' => 'required|array',
            'notes' => 'nullable|string',
            'language' => 'required|in:en,ur',
            'type' => 'nullable|string|max:255',
        ]);

        $shop = Auth::user()->shop ?? Auth::user()->ownedShop;

        Measurement::create([
            'customer_id' => $validated['customer_id'],
            'shop_id' => $shop->id,
            'type' => $validated['type'] ?? 'Standard',
            'data' => $validated['data'],
            'notes' => $validated['notes'],
            'language' => $validated['language'],
        ]);

        if ($request->has('save_and_add_another')) {
            return redirect()->route('measurements.create', ['customer_id' => $validated['customer_id'], 'lang' => $validated['language']])
                ->with('success', 'Measurement recorded successfully. Add another one.');
        }

        return redirect()->route('customers.show', $validated['customer_id'])
            ->with('success', 'Measurement recorded successfully.');
    }

    public function editForCustomer(Customer $customer)
    {
        $measurement = $customer->measurements()->latest()->first() ?? new Measurement(['customer_id' => $customer->id]);
        $language = request('lang', 'en');
        $standardFields = $this->getStandardFields();

        return view('shop.measurements.edit', compact('customer', 'measurement', 'language', 'standardFields'));
    }

    public function show(Measurement $measurement)
    {
        return view('shop.measurements.show', compact('measurement'));
    }

    public function print(Measurement $measurement)
    {
        $measurement->load('customer', 'shop', 'template.columns');
        $standardFields = $this->getStandardFields();

        return view('shop.measurements.print', compact('measurement', 'standardFields'));
    }

    public function printLatest(Customer $customer)
    {
        $measurement = $customer->measurements()->with('template.columns')->latest()->first();
        if (! $measurement) {
            return redirect()->back()->with('error', 'No measurement found for this customer.');
        }

        return $this->print($measurement);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Measurement $measurement)
    {
        $language = request('lang', $measurement->getDisplayLanguage());
        $standardFields = $this->getStandardFields();

        return view('shop.measurements.edit', compact('measurement', 'language', 'standardFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Measurement $measurement)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'notes' => 'nullable|string',
            'language' => 'required|in:en,ur',
            'type' => 'nullable|string|max:255',
        ]);

        $measurement->update([
            'type' => $validated['type'] ?? 'Standard',
            'data' => $validated['data'],
            'notes' => $validated['notes'],
            'language' => $validated['language'],
        ]);

        return redirect()->route('customers.show', $measurement->customer_id)
            ->with('success', 'Measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        $customerId = $measurement->customer_id;
        $measurement->delete();

        return redirect()->route('customers.show', $customerId)->with('success', 'Measurement deleted successfully.');
    }

    /**
     * Get standard measurement fields for Pakistani tailoring
     */
    private function getStandardFields()
    {
        return [
            ['name' => 'length', 'label' => 'Length', 'label_ur' => 'لمبائی', 'unit' => 'inch'],
            ['name' => 'shoulder', 'label' => 'Shoulder', 'label_ur' => 'تیرا', 'unit' => 'inch'],
            ['name' => 'sleeves', 'label' => 'Sleeves', 'label_ur' => 'بازو', 'unit' => 'inch'],
            ['name' => 'collar', 'label' => 'Collar/Neck', 'label_ur' => 'کالر/بین', 'unit' => 'inch'],
            ['name' => 'chest', 'label' => 'Chest', 'label_ur' => 'چھاتی', 'unit' => 'inch'],
            ['name' => 'waist', 'label' => 'Waist', 'label_ur' => 'کمر', 'unit' => 'inch'],
            ['name' => 'hip', 'label' => 'Hip', 'label_ur' => 'ہپ', 'unit' => 'inch'],
            ['name' => 'ghera', 'label' => 'Ghera/Daman', 'label_ur' => 'گھیرا/دامن', 'unit' => 'inch'],
            ['name' => 'armhole', 'label' => 'Armhole', 'label_ur' => 'آرم ہول', 'unit' => 'inch'],
            ['name' => 'bicep', 'label' => 'Bicep', 'label_ur' => 'موری', 'unit' => 'inch'],
            ['name' => 'shalwar_length', 'label' => 'Shalwar/Pant Length', 'label_ur' => 'شلوار/پینٹ لمبائی', 'unit' => 'inch'],
            ['name' => 'shalwar_waist', 'label' => 'Shalwar Waist', 'label_ur' => 'شلوار کمر', 'unit' => 'inch'],
            ['name' => 'poncha', 'label' => 'Bottom/Poncha', 'label_ur' => 'پانچہ', 'unit' => 'inch'],
            ['name' => 'thigh', 'label' => 'Thigh', 'label_ur' => 'ران', 'unit' => 'inch'],
            ['name' => 'knee', 'label' => 'Knee', 'label_ur' => 'گھٹنا', 'unit' => 'inch'],
            ['name' => 'cross_back', 'label' => 'Cross Back', 'label_ur' => 'بیک', 'unit' => 'inch'],
        ];
    }
}
