<!--
@extends('template.admin')

@section('content')
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Chi tiết bài viết: {{ $post->title }}</h2>
    <div class="mb-6">
        <strong>Tác giả:</strong> {{ $post->author->name ?? 'N/A' }}<br>
        <strong>Loại:</strong> {{ ucfirst($post->type) }}<br>
        <strong>Trạng thái:</strong> {{ $post->status === 'published' ? 'Công khai' : 'Nháp' }}<br>
        <strong>Ngày tạo:</strong> {{ $post->created_at }}
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Thống kê tương tác</h3>
        <div class="mb-2">
            <strong>Tổng số comment:</strong> {{ $commentsCount }}
        </div>
        <div>
            <strong>Reactions:</strong>
           <ul>
    @foreach ($reactions as $reaction => $total)
        <li>{{ ucfirst($reaction) }}: <b>{{ $total }}</b></li>
    @endforeach
</ul>

        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Danh sách comment</h3>
        @if ($comments->count())
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Người dùng</th>
                        <th class="py-2 px-4 border-b">Nội dung</th>
                        <th class="py-2 px-4 border-b">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                        <td class="py-2 px-4 border-b">{{ $comment->content }}</td>
                        <td class="py-2 px-4 border-b">{{ $comment->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Chưa có comment nào.</p>
        @endif
    </div>

    <a href="{{ route('admin.posts.manage') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
        Quay lại quản lý bài viết
    </a>
</main>
@endsection -->
@extends('template.admin')

@section('content')
<main class="p-6 space-y-8 max-w-5xl mx-auto">
    {{-- Tiêu đề bài viết --}}
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-900">📄 {{ $post->title }}</h2>
        <a href="{{ route('admin.posts.manage') }}" class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-md shadow">
            ⬅️ Quay lại
        </a>
    </div>

    {{-- Thông tin chính --}}
    <div class="bg-white rounded-xl shadow p-6 space-y-2 border border-gray-200">
        <div><strong class="text-gray-700">👤 Tác giả:</strong> {{ $post->author->name ?? 'N/A' }}</div>
        <div><strong class="text-gray-700">📌 Loại:</strong> {{ ucfirst($post->type) }}</div>
        <div><strong class="text-gray-700">🕵️ Trạng thái:</strong>
            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $post->status === 'published' ? 'Công khai' : 'Nháp' }}
            </span>
        </div>
        <div><strong class="text-gray-700">📅 Ngày tạo:</strong> {{ $post->created_at->format('d/m/Y H:i') }}</div>
    </div>

    {{-- Reactions & Comment stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Reactions --}}
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">🔥 Thống kê biểu cảm</h3>
            <ul class="space-y-2">
                @foreach ($reactions as $reaction => $total)
                    <li class="flex items-center gap-2">
                        <span class="text-xl">
                            @php
                                $emojiMap = [
                                    'like' => '👍', 'love' => '❤️', 'haha' => '😂',
                                    'wow' => '😮', 'sad' => '😢', 'angry' => '😡', 'dislike' => '👎',
                                ];
                            @endphp
                            {{ $emojiMap[$reaction] ?? '❓' }}
                        </span>
                        <span class="capitalize text-gray-700">{{ $reaction }}</span>
                        <span class="ml-auto font-bold text-blue-700">{{ $total }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Tổng số comment --}}
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <h3 class="text-lg font-semibold mb-4">💬 Bình luận</h3>
            <p class="text-gray-700 text-sm">Tổng số comment: <strong class="text-blue-700 text-lg">{{ $commentsCount }}</strong></p>
        </div>
    </div>

    {{-- Danh sách comment --}}
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">📋 Danh sách bình luận</h3>

        @if ($comments->count())
            <table class="min-w-full text-sm text-left border border-gray-300 rounded overflow-hidden">
                <thead class="bg-gray-50 text-gray-700 font-semibold">
                    <tr>
                        <th class="py-2 px-4 border-b">Người dùng</th>
                        <th class="py-2 px-4 border-b">Nội dung</th>
                        <th class="py-2 px-4 border-b">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                            <td class="py-2 px-4 border-b text-gray-800">{{ $comment->content }}</td>
                            <td class="py-2 px-4 border-b text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 italic">Chưa có comment nào.</p>
        @endif
    </div>
</main>
@endsection
