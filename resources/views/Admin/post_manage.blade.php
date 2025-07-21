@extends('template.admin')
@section('content')
<main class="p-6">

    {{-- Thông báo flash message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Quản lý bài viết</h2>
        <a href="{{ url('/admin/posts/create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            Tạo bài viết mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Tiêu đề</th>
                    <th class="py-2 px-4 border-b text-left">Loại</th>
                    <th class="py-2 px-4 border-b text-left">Tác giả</th>
                    <th class="py-2 px-4 border-b text-left">Trạng thái</th>
                    <th class="py-2 px-4 border-b text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr id="post-{{ $post->id }}">
                    <td class="py-2 px-4 border-b">{{ $post->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $post->title }}</td>
                    <td class="py-2 px-4 border-b capitalize">{{ $post->type }}</td>
                    <td class="py-2 px-4 border-b">{{ $post->author->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">
                        <span class="status-text status-{{ $post->status }}">
                            {{ $post->status === 'published' ? 'Công khai' : 'Nháp' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <div class="flex gap-2">
                            {{-- Toggle Ẩn/Hiện --}}
                            <button class="toggle-status-btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                    data-post-id="{{ $post->id }}"
                                    data-current-status="{{ $post->status }}">
                                {{ $post->status === 'published' ? 'Ẩn' : 'Hiện' }}
                            </button>

                            {{-- Nút sửa --}}
                            <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm inline-flex items-center">
                                ✏️ <span class="ml-1">Sửa</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

{{-- Script cập nhật trạng thái --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.dataset.postId;
                const currentStatus = this.dataset.currentStatus;
                const newStatus = currentStatus === 'published' ? 'draft' : 'published';

                axios.put(`/api/admin/posts/${postId}/toggle-status`, {
                    status: newStatus
                })
                .then(response => {
                    // Cập nhật nút
                    this.textContent = newStatus === 'published' ? 'Ẩn' : 'Hiện';
                    this.dataset.currentStatus = newStatus;

                    const statusTextSpan = document.querySelector(`#post-${postId} .status-text`);
                    if (statusTextSpan) {
                        statusTextSpan.textContent = newStatus === 'published' ? 'Công khai' : 'Nháp';
                        statusTextSpan.classList.remove('status-published', 'status-draft');
                        statusTextSpan.classList.add(`status-${newStatus}`);
                    }

                    console.log(response.data.message);
                })
                .catch(error => {
                    console.error('Lỗi cập nhật:', error);
                    alert('Lỗi khi cập nhật trạng thái bài viết.');
                });
            });
        });
    });
</script>

{{-- CSS --}}
<style>
    .status-published {
        color: green;
        font-weight: bold;
    }
    .status-draft {
        color: orange;
        font-weight: bold;
    }
</style>
@endsection
