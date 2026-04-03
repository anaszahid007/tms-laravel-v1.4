<?php
$filesToDelete = [
    'app/Models/UserSubscription.php',
    'database/migrations/2026_01_31_170616_user_subscription.php',
    'database/migrations/2026_02_06_120000_add_payment_proof_to_subscriptions.php',
];

foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "Deleted: $file\n";
        } else {
            echo "Failed to delete: $file\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}
