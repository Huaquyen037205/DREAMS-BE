@extends('template.admin')

@section('content')
<main class="p-6 space-y-10 max-w-6xl mx-auto text-gray-800">

    {{-- Tiêu đề + Quay lại --}}
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold flex items-center gap-2">
            {{-- icon: document-text --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
            </svg>
            {{ $post->title }}
        </h1>

        <a href="{{ route('admin.posts.manage') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            {{-- icon: arrow-left --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Quay lại
        </a>
    </div>

    {{-- Thông tin chính --}}
    <section class="bg-white rounded-2xl shadow-md border p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Tác giả --}}
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 17.804A4.992 4.992 0 0112 15c1.657 0 3.156.804 4.121 2.053M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-gray-600 font-medium">Tác giả:</span> {{ $post->author->name ?? 'N/A' }}
        </div>

        {{-- Loại --}}
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7a2 2 0 00-2 2v1.586a1 1 0 00.293.707l7 7a1 1 0 001.414 0l3.586-3.586a1 1 0 000-1.414l-7-7A1 1 0 0011.586 7H10a2 2 0 00-2-2z"/>
            </svg>
            <span class="text-gray-600 font-medium">Loại:</span> {{ ucfirst($post->type) }}
        </div>

        {{-- Trạng thái --}}
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span class="text-gray-600 font-medium">Trạng thái:</span>
            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $post->status === 'published' ? 'Công khai' : 'Nháp' }}
            </span>
        </div>

        {{-- Ngày tạo --}}
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-gray-600 font-medium">Ngày tạo:</span> {{ $post->created_at->format('d/m/Y H:i') }}
        </div>
    </section>

    {{-- Reaction + Bình luận --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Reaction --}}
        <section class="bg-white rounded-2xl shadow-md border p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14 9l-5 5m0 0l5 5m-5-5h12"/>
                </svg>
                Thống kê biểu cảm
            </h2>
            <ul class="space-y-3 text-sm">
                @php
                    $emojiMap = [
                        'like' => '👍', 'love' => '❤️', 'haha' => '😂',
                        'wow' => '😮', 'sad' => '😢', 'angry' => '😡', 'dislike' => '👎',
                    ];
                @endphp
                @foreach ($reactions as $reaction => $total)
                    <li class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">{{ $emojiMap[$reaction] ?? '❓' }}</span>
                            <span class="capitalize">{{ $reaction }}</span>
                        </div>
                        <span class="font-bold text-blue-600">{{ $total }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Comment Count --}}
        <section class="bg-white rounded-2xl shadow-md border p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8h2a2 2 0 012 2v7a2 2 0 01-2 2h-2m-6 0h-2m0-5h6M7 8H5a2 2 0 00-2 2v7a2 2 0 002 2h2"/>
                </svg>
                Bình luận
            </h2>
            <p class="text-sm text-gray-700">Tổng số comment:</p>
            <p class="text-3xl font-bold text-blue-700">{{ $commentsCount }}</p>
        </section>
    </div>

    {{-- Danh sách bình luận --}}
    <section class="bg-white rounded-2xl shadow-md border p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m14 0v-2a4 4 0 00-4-4h-.5a4 4 0 00-4 4v2M9 7a4 4 0 110-8 4 4 0 010 8zm6 4a4 4 0 110-8 4 4 0 010 8z"/>
            </svg>
            Danh sách bình luận
        </h2>

        @if ($comments->count())
            <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-base border border-gray-300 rounded-lg overflow-hidden">
    <thead class="bg-gray-100 text-gray-700 font-semibold rounded-t-lg">
        <tr class="text-left">
            <th class="py-3 px-5 border-b">Người dùng</th>
            <th class="py-3 px-5 border-b">Nội dung</th>
            <th class="py-3 px-5 border-b">Thời gian</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach ($comments as $comment)
            <tr class="hover:bg-blue-50 last:rounded-b-lg">
                <td class="py-4 px-5">{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                <td class="py-4 px-5 text-gray-800">{{ $comment->content }}</td>
                <td class="py-4 px-5 text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

            </div>
        @else
            <p class="text-gray-500 italic">Chưa có comment nào.</p>
        @endif
    </section>
</main>
@endsection
