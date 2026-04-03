<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeasurementTemplate;
use App\Models\MeasurementColumn;
use Illuminate\Http\Request;

class MeasurementTemplateController extends Controller
{
    public function index()
    {
        $templates = MeasurementTemplate::with('columns')->paginate(10);
        return view('admin.measurement-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.measurement-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|unique:measurement_templates',
            'name' => 'required|string|max:255',
            'name_urdu' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $template = MeasurementTemplate::create($validated);

        return redirect()->route('admin.measurement-templates.edit', $template)
            ->with('success', 'Measurement template created successfully. Now add measurement columns.');
    }

    public function edit(MeasurementTemplate $measurementTemplate)
    {
        $template = $measurementTemplate->load('columns');
        return view('admin.measurement-templates.edit', compact('template'));
    }

    public function update(Request $request, MeasurementTemplate $measurementTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_urdu' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $measurementTemplate->update($validated);

        return redirect()->route('admin.measurement-templates.index')
            ->with('success', 'Measurement template updated successfully.');
    }

    public function addColumn(Request $request, MeasurementTemplate $measurementTemplate)
    {
        $validated = $request->validate([
            'field_name' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'label_urdu' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:20',
            'sort_order' => 'required|integer|min:0',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $measurementTemplate->columns()->create($validated);

        return redirect()->back()->with('success', 'Measurement column added successfully.');
    }

    public function updateColumn(Request $request, MeasurementColumn $measurementColumn)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'label_urdu' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:20',
            'sort_order' => 'required|integer|min:0',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $measurementColumn->update($validated);

        return redirect()->back()->with('success', 'Measurement column updated successfully.');
    }

    public function destroyColumn(MeasurementColumn $measurementColumn)
    {
        $measurementColumn->delete();
        return redirect()->back()->with('success', 'Measurement column deleted successfully.');
    }
}