<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function generate()
    {
        $fileName = 'shops_report_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Shop Name', 'Owner Name', 'Owner Email', 'Status', 'Suspended', 'Created At']);

            Shop::with('user')->chunk(100, function ($shops) use ($file) {
                foreach ($shops as $shop) {
                    fputcsv($file, [
                        $shop->id,
                        $shop->name,
                        $shop->user->name ?? 'N/A',
                        $shop->user->email ?? 'N/A',
                        $shop->status,
                        $shop->is_suspended ? 'Yes' : 'No',
                        $shop->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
