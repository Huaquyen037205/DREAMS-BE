@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-bold text-gray-800 mb-6">
        ⚡ Tạo Chương Trình Flash Sale Mới
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong class="font-semibold">Đã xảy ra lỗi:</strong>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/flash-sale') }}" method="POST"
          class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto">
        @csrf

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">📋 Tên chương trình</label>
            <input type="text" name="name"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required />
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">🕒 Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required />
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1">🕔 Thời gian kết thúc</label>
            <input type="datetime-local" name="end_time"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required />
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                ✅ Tạo chương trình
            </button>
        </div>
    </form>
</main>
@endsection
