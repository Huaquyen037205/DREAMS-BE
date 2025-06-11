@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-3xl font-bold text-gray-800 mb-8">
        ⚡ Tạo Chương Trình Flash Sale Mới
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
            <strong class="font-semibold">Đã xảy ra lỗi:</strong>
            <ul class="mt-2 list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/flash-sale') }}" method="POST"
          class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 w-full max-w-2xl mx-auto space-y-6">
        @csrf

        <!-- Tên chương trình -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">📋 Tên chương trình</label>
            <input type="text" name="name" id="name"
                   placeholder="Ví dụ: Flash Sale Tháng 7"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required />
        </div>

        <!-- Thời gian bắt đầu -->
        <div>
            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">🕒 Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time" id="start_time"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required />
        </div>

        <!-- Thời gian kết thúc -->
        <div>
            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">⏰ Thời gian kết thúc</label>
            <input type="datetime-local" name="end_time" id="end_time"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required />
        </div>

        <!-- Nút tạo -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                ✅ Tạo chương trình
            </button>
        </div>
    </form>
</main>
@endsection
