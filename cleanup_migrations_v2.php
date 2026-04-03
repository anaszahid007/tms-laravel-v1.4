<?php
$dir = __DIR__ . '/database/migrations/';
$filesToDelete = [
    '2026_02_06_100000_create_referral_partners_table.php',
    '2026_02_06_100005_add_referral_to_shops.php',
    '2026_02_07_000001_create_measurement_templates_table.php',
    '2026_02_07_000002_create_measurement_columns_table.php',
    '2026_02_07_000003_update_measurements_table.php',
    '2026_02_25_000004_add_expiry_notified_at_to_shop_subscriptions.php',
    '2026_03_01_100000_add_phone_to_users_table_if_missing.php',
];

foreach ($filesToDelete as $file) {
    $path = $dir . $file;
    if (file_exists($path)) {
        if (unlink($path)) {
            echo "Deleted: $path\n";
        } else {
            echo "Failed to delete: $path\n";
        }
    } else {
        echo "File not found: $path\n";
    }
}
unlink(__FILE__);
