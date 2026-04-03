<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseBackupService
{
    /**
     * Storage disk for backups
     */
    protected string $disk = 'local';

    /**
     * Subdirectory within the storage disk
     */
    protected string $directory = 'backups';

    /**
     * Create a database backup.
     * Returns the filename on success.
     */
    public function createBackup(): string
    {
        $filename = 'backup-'.Carbon::now()->format('Y-m-d-H-i-s').'.sql';
        $path = storage_path('app/'.$this->directory);

        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $fullPath = $path.'/'.$filename;

        // Command: PGPASSWORD='password' pg_dump -h host -U user -d db > path
        $command = sprintf(
            'PGPASSWORD=%s pg_dump -h %s -p %s -U %s %s > %s',
            escapeshellarg(config('database.connections.pgsql.password')),
            escapeshellarg(config('database.connections.pgsql.host')),
            escapeshellarg(config('database.connections.pgsql.port')),
            escapeshellarg(config('database.connections.pgsql.username')),
            escapeshellarg(config('database.connections.pgsql.database')),
            escapeshellarg($fullPath)
        );

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (! $process->isSuccessful()) {
            Log::error('Database backup failed', [
                'error' => $process->getErrorOutput(),
                'command' => $command,
            ]);
            throw new ProcessFailedException($process);
        }

        return $filename;
    }

    /**
     * Restore a database from a backup file.
     */
    public function restoreBackup(string $filename): bool
    {
        $path = storage_path('app/'.$this->directory.'/'.$filename);

        if (! file_exists($path)) {
            throw new \Exception("Backup file [{$filename}] not found.");
        }

        // Before restoring, we should drop the schema or at least truncate tables.
        // For PostgreSQL, dropping and recreating the public schema is a common clean way in development/simple apps.
        // COMMAND: PGPASSWORD='password' psql -h host -p port -U user -d db < path
        $command = sprintf(
            'PGPASSWORD=%s psql -h %s -p %s -U %s %s < %s',
            escapeshellarg(config('database.connections.pgsql.password')),
            escapeshellarg(config('database.connections.pgsql.host')),
            escapeshellarg(config('database.connections.pgsql.port')),
            escapeshellarg(config('database.connections.pgsql.username')),
            escapeshellarg(config('database.connections.pgsql.database')),
            escapeshellarg($path)
        );

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (! $process->isSuccessful()) {
            Log::error('Database restore failed', [
                'error' => $process->getErrorOutput(),
                'command' => $command,
            ]);
            throw new ProcessFailedException($process);
        }

        return true;
    }

    /**
     * List all available backups.
     */
    public function listBackups(): array
    {
        $files = Storage::disk($this->disk)->files($this->directory);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $backups[] = [
                    'filename' => basename($file),
                    'size' => $this->formatBytes(Storage::disk($this->disk)->size($file)),
                    'created_at' => Carbon::createFromTimestamp(Storage::disk($this->disk)->lastModified($file))->toDateTimeString(),
                    'raw_size' => Storage::disk($this->disk)->size($file),
                ];
            }
        }

        // Sort by date descending
        usort($backups, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return $backups;
    }

    /**
     * Delete a backup file.
     */
    public function deleteBackup(string $filename): bool
    {
        return Storage::disk($this->disk)->delete($this->directory.'/'.$filename);
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }
}
