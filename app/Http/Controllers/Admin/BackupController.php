<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    protected DatabaseBackupService $backupService;

    public function __construct(DatabaseBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Display a listing of the backups.
     */
    public function index()
    {
        $backups = $this->backupService->listBackups();
        return view('admin.backups.index', compact('backups'));
    }

    /**
     * Create a new backup.
     */
    public function create()
    {
        try {
            $filename = $this->backupService->createBackup();
            return redirect()->route('admin.backups.index')
                ->with('success', "Database backup created successfully: [{$filename}]");
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', "Database backup failed: " . $e->getMessage());
        }
    }

    /**
     * Download the specified backup.
     */
    public function download(string $filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (!file_exists($path)) {
            abort(404, "Backup file not found.");
        }

        return response()->download($path);
    }

    /**
     * Delete the specified backup from storage.
     */
    public function destroy(string $filename)
    {
        if ($this->backupService->deleteBackup($filename)) {
            return redirect()->route('admin.backups.index')
                ->with('success', "Backup file [{$filename}] deleted successfully.");
        }

        return redirect()->route('admin.backups.index')
            ->with('error', "Failed delete backup file.");
    }

    /**
     * Restore the specified backup to the database.
     */
    public function restore(string $filename)
    {
        try {
            // NOTE: Database restoration is a potentially destructive action.
            // In a production environment, you should add extra confirmation.
            $this->backupService->restoreBackup($filename);
            return redirect()->route('admin.backups.index')
                ->with('success', "Database restored successfully from [{$filename}].");
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', "Database restoration failed: " . $e->getMessage());
        }
    }
}
