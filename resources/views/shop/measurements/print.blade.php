<!DOCTYPE html>
<html lang="ur" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $measurement->customer->name }} - Measurement Slip</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&family=Outfit:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Noto Sans Arabic', sans-serif;
            background: #fff;
            color: var(--text-dark);
            direction: rtl;
        }

        .print-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            position: relative;
        }

        /* Header Design */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .shop-info h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .shop-info p {
            color: var(--text-light);
            font-size: 14px;
        }

        .slip-title {
            text-align: left;
        }

        .slip-title h2 {
            font-size: 24px;
            color: var(--primary);
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .slip-title p {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Customer Stats Row */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 1px solid var(--border);
        }

        .info-item label {
            display: block;
            font-size: 11px;
            color: var(--text-light);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .info-item span {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Measurements Table */
        .measurements-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .measurement-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
        }

        .measurement-row:nth-child(even) {
            border-right: 1px solid var(--border);
        }

        .measurement-row:last-child,
        .measurement-row:nth-last-child(2) {
            border-bottom: none;
        }

        .label-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .urdu-label {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .english-label {
            font-size: 10px;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
        }

        .value-group {
            text-align: left;
        }

        .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .unit {
            font-size: 12px;
            color: var(--text-light);
            margin-right: 2px;
        }

        /* Notes Section */
        .notes-section {
            margin-top: 30px;
            padding: 20px;
            background: #fffbeb;
            border: 1px dashed #f59e0b;
            border-radius: 12px;
        }

        .notes-section h3 {
            font-size: 14px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notes-section p {
            font-size: 16px;
            color: #b45309;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid var(--border);
            padding-top: 20px;
        }

        .footer p {
            font-size: 12px;
            color: var(--text-light);
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 0, 0, 0.03);
            font-weight: 900;
            pointer-events: none;
            z-index: -1;
            white-space: nowrap;
        }

        @media print {
            body {
                background: none;
            }

            .print-container {
                padding: 20px;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }

            .info-grid {
                background: #fff !important;
                border: 1px solid #000;
            }

            .measurement-row:nth-child(even) {
                border-right: 1px solid #000;
            }

            .measurement-row {
                border-bottom: 1px solid #000;
            }

            .measurements-container {
                border: 1px solid #000;
                border-radius: 0;
            }

            .notes-section {
                background: #fff !important;
                border: 1px dashed #000;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>

<body>

    <button class="btn-print no-print" onclick="window.print()">
        <i class="fa-solid fa-print"></i>
        پرنٹ کریں
    </button>

    <div class="print-container">
        <div class="watermark">{{ $measurement->shop->name }}</div>

        <div class="header">
            <div class="shop-info">
                <h1>{{ $measurement->shop->name }}</h1>
                <p><i class="fa-solid fa-location-dot"></i>
                    {{ $measurement->shop->address ?? 'Tailor Management System' }}</p>
                @if ($measurement->shop->phone)
                    <p><i class="fa-solid fa-phone"></i> {{ $measurement->shop->phone }}</p>
                @endif
            </div>
            <div class="slip-title">
                <h2>ناپ کی پرچی</h2>
                <p>Measurement Slip</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>کسٹمر کا نام / Name</label>
                <span>{{ $measurement->customer->name }}</span>
            </div>
            <div class="info-item">
                <label>فون نمبر / Phone</label>
                <span>{{ $measurement->customer->phone }}</span>
            </div>
            <div class="info-item">
                <label>تاریخ / Date</label>
                <span>{{ $measurement->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="measurements-container">
            @if ($measurement->template && $measurement->template->columns->isNotEmpty())
                @foreach ($measurement->template->columns->sortBy('sort_order') as $column)
                    @if (isset($measurement->data[$column->field_name]))
                        <div class="measurement-row">
                            <div class="label-group">
                                <span class="urdu-label">{{ $column->label_urdu ?: $column->label }}</span>
                                <span class="english-label">{{ $column->label }}</span>
                            </div>
                            <div class="value-group">
                                <span class="value">{{ $measurement->data[$column->field_name] }}</span>
                                <span class="unit">{{ $column->unit ?: 'انچ' }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                @foreach ($standardFields as $field)
                    @if (isset($measurement->data[$field['name']]))
                        <div class="measurement-row">
                            <div class="label-group">
                                <span class="urdu-label">{{ $field['label_ur'] }}</span>
                                <span class="english-label">{{ $field['label'] }}</span>
                            </div>
                            <div class="value-group">
                                <span class="value">{{ $measurement->data[$field['name']] }}</span>
                                <span class="unit">انچ</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        @if ($measurement->notes)
            <div class="notes-section">
                <h3><i class="fa-solid fa-scissors"></i> خصوصی ہدایات (Notes)</h3>
                <p>{{ $measurement->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>TailorOnDesk - {{ date('Y') }}</p>
            <p style="margin-top: 5px; opacity: 0.5;">شکریہ! ہم آپ کے تعاون کے مشکور ہیں۔</p>
        </div>
    </div>

    <script>
        // Auto print on load but with a tiny delay to ensure fonts are ready
        window.addEventListener('load', () => {
            setTimeout(() => {
                // window.print();
            }, 500);
        });
    </script>
</body>

</html>
