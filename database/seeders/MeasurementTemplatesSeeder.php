<?php

namespace Database\Seeders;

use App\Models\MeasurementTemplate;
use App\Models\MeasurementColumn;
use Illuminate\Database\Seeder;

class MeasurementTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        // Define measurement templates with their columns
        $templates = [
            [
                'type' => 'shalwar_kameez',
                'name' => 'Shalwar Kameez',
                'name_urdu' => 'شلوار قمیض',
                'columns' => [
                    ['field_name' => 'length', 'label' => 'Length', 'label_urdu' => 'لمبائی', 'unit' => 'inch', 'sort_order' => 1, 'is_required' => true],
                    ['field_name' => 'chest', 'label' => 'Chest', 'label_urdu' => 'چھاتی', 'unit' => 'inch', 'sort_order' => 2, 'is_required' => true],
                    ['field_name' => 'waist', 'label' => 'Waist', 'label_urdu' => 'کمر', 'unit' => 'inch', 'sort_order' => 3, 'is_required' => true],
                    ['field_name' => 'hips', 'label' => 'Hips', 'label_urdu' => 'کولہے', 'unit' => 'inch', 'sort_order' => 4, 'is_required' => true],
                    ['field_name' => 'shoulders', 'label' => 'Shoulders', 'label_urdu' => 'کندھے', 'unit' => 'inch', 'sort_order' => 5, 'is_required' => true],
                    ['field_name' => 'sleeves', 'label' => 'Sleeves', 'label_urdu' => 'آستین', 'unit' => 'inch', 'sort_order' => 6, 'is_required' => true],
                    ['field_name' => 'collar', 'label' => 'Collar', 'label_urdu' => 'کالر', 'unit' => 'inch', 'sort_order' => 7, 'is_required' => false],
                    ['field_name' => 'shalwar_length', 'label' => 'Shalwar Length', 'label_urdu' => 'شلوار لمبائی', 'unit' => 'inch', 'sort_order' => 8, 'is_required' => true],
                    ['field_name' => 'shalwar_bottom', 'label' => 'Shalwar Bottom', 'label_urdu' => 'شلوار پائنچہ', 'unit' => 'inch', 'sort_order' => 9, 'is_required' => false],
                    ['field_name' => 'pocket_depth', 'label' => 'Pocket Depth', 'label_urdu' => 'جیب کی گہرائی', 'unit' => 'inch', 'sort_order' => 10, 'is_required' => false],
                ]
            ],
            [
                'type' => 'pant_coat',
                'name' => 'Pant Coat',
                'name_urdu' => 'پینٹ کوٹ',
                'columns' => [
                    ['field_name' => 'coat_length', 'label' => 'Coat Length', 'label_urdu' => 'کوٹ لمبائی', 'unit' => 'inch', 'sort_order' => 1, 'is_required' => true],
                    ['field_name' => 'chest', 'label' => 'Chest', 'label_urdu' => 'چھاتی', 'unit' => 'inch', 'sort_order' => 2, 'is_required' => true],
                    ['field_name' => 'waist', 'label' => 'Waist', 'label_urdu' => 'کمر', 'unit' => 'inch', 'sort_order' => 3, 'is_required' => true],
                    ['field_name' => 'hips', 'label' => 'Hips', 'label_urdu' => 'کولہے', 'unit' => 'inch', 'sort_order' => 4, 'is_required' => true],
                    ['field_name' => 'shoulders', 'label' => 'Shoulders', 'label_urdu' => 'کندھے', 'unit' => 'inch', 'sort_order' => 5, 'is_required' => true],
                    ['field_name' => 'sleeves', 'label' => 'Sleeves', 'label_urdu' => 'آستین', 'unit' => 'inch', 'sort_order' => 6, 'is_required' => true],
                    ['field_name' => 'collar', 'label' => 'Collar', 'label_urdu' => 'کالر', 'unit' => 'inch', 'sort_order' => 7, 'is_required' => true],
                    ['field_name' => 'pant_length', 'label' => 'Pant Length', 'label_urdu' => 'پینٹ لمبائی', 'unit' => 'inch', 'sort_order' => 8, 'is_required' => true],
                    ['field_name' => 'pant_waist', 'label' => 'Pant Waist', 'label_urdu' => 'پینٹ کمر', 'unit' => 'inch', 'sort_order' => 9, 'is_required' => true],
                    ['field_name' => 'pant_bottom', 'label' => 'Pant Bottom', 'label_urdu' => 'پینٹ پائنچہ', 'unit' => 'inch', 'sort_order' => 10, 'is_required' => false],
                    ['field_name' => 'thigh', 'label' => 'Thigh', 'label_urdu' => 'ران', 'unit' => 'inch', 'sort_order' => 11, 'is_required' => false],
                    ['field_name' => 'knee', 'label' => 'Knee', 'label_urdu' => 'گھٹنا', 'unit' => 'inch', 'sort_order' => 12, 'is_required' => false],
                ]
            ],
            [
                'type' => 'kurta',
                'name' => 'Kurta',
                'name_urdu' => 'کرتی',
                'columns' => [
                    ['field_name' => 'length', 'label' => 'Length', 'label_urdu' => 'لمبائی', 'unit' => 'inch', 'sort_order' => 1, 'is_required' => true],
                    ['field_name' => 'chest', 'label' => 'Chest', 'label_urdu' => 'چھاتی', 'unit' => 'inch', 'sort_order' => 2, 'is_required' => true],
                    ['field_name' => 'waist', 'label' => 'Waist', 'label_urdu' => 'کمر', 'unit' => 'inch', 'sort_order' => 3, 'is_required' => true],
                    ['field_name' => 'hips', 'label' => 'Hips', 'label_urdu' => 'کولہے', 'unit' => 'inch', 'sort_order' => 4, 'is_required' => true],
                    ['field_name' => 'shoulders', 'label' => 'Shoulders', 'label_urdu' => 'کندھے', 'unit' => 'inch', 'sort_order' => 5, 'is_required' => true],
                    ['field_name' => 'sleeves', 'label' => 'Sleeves', 'label_urdu' => 'آستین', 'unit' => 'inch', 'sort_order' => 6, 'is_required' => true],
                    ['field_name' => 'collar', 'label' => 'Collar', 'label_urdu' => 'کالر', 'unit' => 'inch', 'sort_order' => 7, 'is_required' => false],
                    ['field_name' => 'side_slits', 'label' => 'Side Slits', 'label_urdu' => 'سائیڈ سلٹ', 'unit' => 'inch', 'sort_order' => 8, 'is_required' => false],
                    ['field_name' => 'neck_depth', 'label' => 'Neck Depth', 'label_urdu' => 'گلے کی گہرائی', 'unit' => 'inch', 'sort_order' => 9, 'is_required' => false],
                ]
            ],
            [
                'type' => 'shirt',
                'name' => 'Shirt',
                'name_urdu' => 'شرٹ',
                'columns' => [
                    ['field_name' => 'length', 'label' => 'Length', 'label_urdu' => 'لمبائی', 'unit' => 'inch', 'sort_order' => 1, 'is_required' => true],
                    ['field_name' => 'chest', 'label' => 'Chest', 'label_urdu' => 'چھاتی', 'unit' => 'inch', 'sort_order' => 2, 'is_required' => true],
                    ['field_name' => 'waist', 'label' => 'Waist', 'label_urdu' => 'کمر', 'unit' => 'inch', 'sort_order' => 3, 'is_required' => true],
                    ['field_name' => 'hips', 'label' => 'Hips', 'label_urdu' => 'کولہے', 'unit' => 'inch', 'sort_order' => 4, 'is_required' => true],
                    ['field_name' => 'shoulders', 'label' => 'Shoulders', 'label_urdu' => 'کندھے', 'unit' => 'inch', 'sort_order' => 5, 'is_required' => true],
                    ['field_name' => 'sleeves', 'label' => 'Sleeves', 'label_urdu' => 'آستین', 'unit' => 'inch', 'sort_order' => 6, 'is_required' => true],
                    ['field_name' => 'collar', 'label' => 'Collar', 'label_urdu' => 'کالر', 'unit' => 'inch', 'sort_order' => 7, 'is_required' => true],
                    ['field_name' => 'cuff', 'label' => 'Cuff', 'label_urdu' => 'کف', 'unit' => 'inch', 'sort_order' => 8, 'is_required' => false],
                    ['field_name' => 'pocket_size', 'label' => 'Pocket Size', 'label_urdu' => 'جیب کا سائز', 'unit' => 'inch', 'sort_order' => 9, 'is_required' => false],
                ]
            ],
            [
                'type' => 'trouser',
                'name' => 'Trouser',
                'name_urdu' => 'ٹراؤزر',
                'columns' => [
                    ['field_name' => 'length', 'label' => 'Length', 'label_urdu' => 'لمبائی', 'unit' => 'inch', 'sort_order' => 1, 'is_required' => true],
                    ['field_name' => 'waist', 'label' => 'Waist', 'label_urdu' => 'کمر', 'unit' => 'inch', 'sort_order' => 2, 'is_required' => true],
                    ['field_name' => 'hips', 'label' => 'Hips', 'label_urdu' => 'کولہے', 'unit' => 'inch', 'sort_order' => 3, 'is_required' => true],
                    ['field_name' => 'thigh', 'label' => 'Thigh', 'label_urdu' => 'ران', 'unit' => 'inch', 'sort_order' => 4, 'is_required' => true],
                    ['field_name' => 'knee', 'label' => 'Knee', 'label_urdu' => 'گھٹنا', 'unit' => 'inch', 'sort_order' => 5, 'is_required' => false],
                    ['field_name' => 'bottom', 'label' => 'Bottom', 'label_urdu' => 'پائنچہ', 'unit' => 'inch', 'sort_order' => 6, 'is_required' => true],
                    ['field_name' => 'crotch', 'label' => 'Crotch', 'label_urdu' => 'کروچ', 'unit' => 'inch', 'sort_order' => 7, 'is_required' => false],
                    ['field_name' => 'rise', 'label' => 'Rise', 'label_urdu' => 'رائیز', 'unit' => 'inch', 'sort_order' => 8, 'is_required' => false],
                ]
            ]
        ];

        foreach ($templates as $templateData) {
            $template = MeasurementTemplate::create([
                'type' => $templateData['type'],
                'name' => $templateData['name'],
                'name_urdu' => $templateData['name_urdu'],
                'is_active' => true,
            ]);

            foreach ($templateData['columns'] as $columnData) {
                $template->columns()->create($columnData);
            }
        }
    }
}