@extends('template.admin')
@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">➕ Thêm Mã Giảm Giá</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/add/discount" method="POST" class="bg-white p-8 rounded-2xl shadow-lg max-w-3xl mx-auto space-y-6">
    @csrf

    <h2 class="text-2xl font-bold text-purple-700">Thêm Mã Giảm Giá</h2>

    <div>
        <label for="name" class="block font-semibold text-gray-700 mb-1">Tên Chương Trình Giảm Giá</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="percentage" class="block font-semibold text-gray-700 mb-1">Phần Trăm Giảm (%)</label>
        <input type="number" name="percentage" id="percentage" min="1" max="100" value="{{ old('percentage') }}"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        @error('percentage')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="start_day" class="block font-semibold text-gray-700 mb-1">Ngày Bắt Đầu</label>
            <input type="date" name="start_day" id="start_day" value="{{ old('start_day') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('start_day')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="end_day" class="block font-semibold text-gray-700 mb-1">Ngày Kết Thúc</label>
            <input type="date" name="end_day" id="end_day" value="{{ old('end_day') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('end_day')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-start gap-4 pt-2">
        <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 ease-in-out">
            💾 Lưu
        </button>
        <a href="{{ url('/admin/discount') }}" class="text-gray-600 hover:text-purple-600 transition">← Quay lại</a>
    </div>
</form>
</div>
@endsection
