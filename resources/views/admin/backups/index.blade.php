@extends('layouts.admin')

@section('header', 'Database Backups')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">System Backups</h2>
                <p class="text-gray-500 mt-1">Manage and restore your database snapshots</p>
            </div>
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-plus-circle"></i>
                    Create New Backup
                </button>
            </form>
        </div>

        <!-- Alert for Destruction -->
        <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100 flex gap-4 items-start">
            <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-amber-800">Restoration Warning</h4>
                <p class="text-xs text-amber-700 mt-0.5 leading-relaxed">
                    Restoring a backup will overwrite your current database. This action is irreversible. Please ensure you have a current backup before restoring an older version.
                </p>
            </div>
        </div>
    </div>

    <!-- Backups Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">File Details</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Size</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Date Created</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($backups as $backup)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                    <i class="fa-solid fa-database text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">{{ $backup['filename'] }}</span>
                                    <span class="text-xs text-gray-400 font-medium">SQL Dump File</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                {{ $backup['size'] }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex flex-col text-center">
                                <span class="text-sm font-semibold text-gray-700">{{ \Carbon\Carbon::parse($backup['created_at'])->format('d M, Y') }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($backup['created_at'])->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Download -->
                                <a href="{{ route('admin.backups.download', $backup['filename']) }}" 
                                   class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50 rounded-xl transition-all shadow-sm"
                                   title="Download File">
                                    <i class="fa-solid fa-download"></i>
                                </a>

                                <!-- Restore -->
                                <button type="button" 
                                        onclick="confirmRestore('{{ $backup['filename'] }}')"
                                        class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-amber-600 hover:border-amber-100 hover:bg-amber-50 rounded-xl transition-all shadow-sm"
                                        title="Restore Database">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.backups.destroy', $backup['filename']) }}" method="POST" id="delete-form-{{ loop->index }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete('{{ loop->index }}')"
                                            class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-100 hover:bg-red-50 rounded-xl transition-all shadow-sm"
                                            title="Delete Backup">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-3xl">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-lg font-bold">No Backups Found</span>
                                    <span class="text-sm">Create your first database snapshot today.</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts for Modals -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(idx) {
        Swal.fire({
            title: 'Delete Backup?',
            text: "This file will be permanently removed from storage.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            borderRadius: '1.25rem'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + idx).submit();
            }
        })
    }

    function confirmRestore(filename) {
        Swal.fire({
            title: 'Restore Database?',
            html: `You are about to restore <b>${filename}</b>. <br><br><span class="text-red-500 font-bold">WARNING: This will overwrite your current data!</span>`,
            icon: 'caution',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, restore now',
            borderRadius: '1.25rem'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.backups.restore', '') }}/" + filename;
                form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
                document.body.appendChild(form);
                
                Swal.fire({
                    title: 'Restoring Database...',
                    text: 'Please wait while we apply the snapshot.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        form.submit();
                    }
                });
            }
        })
    }
</script>
@endsection
