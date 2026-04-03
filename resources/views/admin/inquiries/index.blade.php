@extends('layouts.admin')

@section('header', 'Contact Inquiries')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Inquiry List</h3>
                <p class="text-sm text-gray-500 text-sm">Manage messages from potential customers</p>
            </div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Total: {{ $inquiries->total() }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sender</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Date
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                        {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $inquiry->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $inquiry->email }}</div>
                                        <div class="text-xs text-gray-400">{{ $inquiry->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-[150px]">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium truncate block"
                                    title="{{ $inquiry->subject }}">
                                    {{ Str::limit($inquiry->subject, 20) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-gray-600 truncate" title="{{ $inquiry->message }}">
                                    {{ Str::limit($inquiry->message, 50) }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="text-sm text-gray-900">{{ $inquiry->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $inquiry->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="alert('Message Details:\n\n' + {{ json_encode($inquiry->message) }})"
                                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                        title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-envelope-open text-gray-400 text-2xl"></i>
                                    </div>
                                    <div class="text-gray-500 font-medium text-sm">No inquiries found</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($inquiries->hasPages())
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
@endsection
