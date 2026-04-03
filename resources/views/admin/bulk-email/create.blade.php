@extends('layouts.admin')

@section('title', 'Send Bulk Email to Shops')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                Send Bulk Email to All Shops
            </h2>
            <p class="text-gray-600 mt-1">Send important announcements, updates, or newsletters to all active shop owners.</p>
        </div>

        <form action="{{ route('admin.bulk-email.send') }}" method="POST" id="bulkEmailForm">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Stats -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-blue-800 font-medium">This email will be sent to <strong>{{ $totalShops }}</strong> active shops.</p>
                            <p class="text-blue-600 text-sm mt-1">Emails will be processed in queue for better performance.</p>
                        </div>
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Subject <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="subject" 
                           id="subject" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 @enderror"
                           placeholder="Enter email subject..."
                           value="{{ old('subject') }}">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="10" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('content') border-red-500 @enderror"
                              placeholder="Write your message here...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview Section -->
                <div class="border border-gray-200 rounded-lg">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </h3>
                            <button type="button" 
                                    id="previewBtn"
                                    class="px-3 py-1 text-xs bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Update Preview
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <div id="previewContainer" class="text-gray-600 text-sm">
                            Fill in the subject and content above, then click "Update Preview" to see how your email will look.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            id="sendBtn"
                            class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send to All Shops
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewBtn = document.getElementById('previewBtn');
    const previewContainer = document.getElementById('previewContainer');
    const subjectInput = document.getElementById('subject');
    const contentInput = document.getElementById('content');
    const sendBtn = document.getElementById('sendBtn');
    const form = document.getElementById('bulkEmailForm');

    previewBtn.addEventListener('click', function() {
        const subject = subjectInput.value.trim();
        const content = contentInput.value.trim();

        if (!subject || !content) {
            previewContainer.innerHTML = '<div class="text-red-600">Please fill in both subject and content to see preview.</div>';
            return;
        }

        previewBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
        previewBtn.disabled = true;

        fetch('{{ route("admin.bulk-email.preview") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                subject: subject,
                content: content
            })
        })
        .then(response => response.text())
        .then(html => {
            previewContainer.innerHTML = html;
        })
        .catch(error => {
            previewContainer.innerHTML = '<div class="text-red-600">Error loading preview. Please try again.</div>';
            console.error('Preview error:', error);
        })
        .finally(() => {
            previewBtn.innerHTML = '<i class="fas fa-eye mr-2"></i>Update Preview';
            previewBtn.disabled = false;
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
        sendBtn.disabled = true;
        
        form.submit();
    });
});
</script>
@endpush