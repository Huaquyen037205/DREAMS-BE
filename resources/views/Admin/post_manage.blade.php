@extends('template.admin')

@section('content')
<main class="p-6 space-y-6 bg-gray-50 min-h-screen">

    {{-- Flash message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded-md shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h2 class="text-3xl font-semibold text-gray-800">📝 Quản lý bài viết</h2>
        <a href="{{ url('/admin/posts/create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tạo bài viết mới
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-500 border-b">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Tiêu đề</th>
                    <th class="px-6 py-4">Loại</th>
                    <th class="px-6 py-4">Tác giả</th>
                    <th class="px-6 py-4">Trạng thái</th>
                    <th class="px-6 py-4 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr id="post-{{ $post->id }}" class="hover:bg-gray-50 transition-all border-b">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $post->id }}</td>
                    <td class="px-6 py-4">{{ $post->title }}</td>
                    <td class="px-6 py-4 capitalize">{{ $post->type }}</td>
                    <td class="px-6 py-4">{{ $post->author->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}
                            status-text status-{{ $post->status }}">
                            {{ $post->status === 'published' ? 'Công khai' : 'Nháp' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2 justify-center">
                            {{-- Toggle Status --}}
                            <button class="toggle-status-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs"
                                    data-post-id="{{ $post->id }}"
                                    data-current-status="{{ $post->status }}">
                                {{ $post->status === 'published' ? 'Ẩn' : 'Hiện' }}
                            </button>

                            {{-- Edit --}}
                            <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs">
                                 Sửa
                            </a>

                            {{-- Detail --}}
                            <a href="{{ route('admin.posts.adminDetail', $post->id) }}"
                               class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-md text-xs">
                                 Chi tiết
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

{{-- Axios toggle script --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.dataset.postId;
                const currentStatus = this.dataset.currentStatus;
                const newStatus = currentStatus === 'published' ? 'draft' : 'published';

                axios.put(`/api/admin/posts/${postId}/toggle-status`, { status: newStatus })
                    .then(response => {
                        this.textContent = newStatus === 'published' ? 'Ẩn' : 'Hiện';
                        this.dataset.currentStatus = newStatus;

                        const statusSpan = document.querySelector(`#post-${postId} .status-text`);
                        if (statusSpan) {
                            statusSpan.textContent = newStatus === 'published' ? 'Công khai' : 'Nháp';
                            statusSpan.className = `inline-block px-2 py-1 rounded-full text-xs font-semibold status-text status-${newStatus} ${
                                newStatus === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'
                            }`;
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi cập nhật:', error);
                        alert('❌ Không thể cập nhật trạng thái bài viết.');
                    });
            });
        });
    });
</script>
@endsection
