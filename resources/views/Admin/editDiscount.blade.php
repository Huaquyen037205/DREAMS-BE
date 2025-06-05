@extends('template.admin')
@section('content')
<div class="container mx-auto max-w-3xl p-6">
    <h2 class="text-3xl font-bold text-purple-700 mb-6 flex items-center gap-2">
        ✏️ Chỉnh Sửa Mã Giảm Giá
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
            <strong>⚠️ Lỗi nhập liệu:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/edit/discount/' . $discount->id) }}" method="POST"
          class="bg-white p-8 rounded-xl shadow-md space-y-6 border border-gray-200">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Tên Chương Trình</label>
            <input type="text" name="name" id="name" value="{{ old('name', $discount->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>

        <div>
            <label for="percentage" class="block text-sm font-semibold text-gray-700 mb-1">Phần Trăm Giảm (%)</label>
            <input type="number" name="percentage" id="percentage" min="1" max="100"
                   value="{{ old('percentage', $discount->percentage) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_day" class="block text-sm font-semibold text-gray-700 mb-1">Ngày Bắt Đầu</label>
                <input type="date" name="start_day" id="start_day"
                       value="{{ old('start_day', \Carbon\Carbon::parse($discount->start_day)->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>

            <div>
                <label for="end_day" class="block text-sm font-semibold text-gray-700 mb-1">Ngày Kết Thúc</label>
                <input type="date" name="end_day" id="end_day"
                       value="{{ old('end_day', \Carbon\Carbon::parse($discount->end_day)->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>
        </div>

        <div class="flex items-center justify-start gap-4 pt-2">
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 transition text-white font-semibold py-2 px-5 rounded-lg shadow">
                    Cập nhật
            </button>
            <a href="{{ url('/admin/discount') }}"
               class="text-sm text-gray-600 hover:text-purple-600 transition underline underline-offset-2">
                ← Quay lại danh sách
            </a>
        </div>
    </form>
</div>
@endsection
