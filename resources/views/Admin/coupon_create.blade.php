@extends('template.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 mt-10 rounded-2xl shadow-2xl border border-gray-100">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        ➕ <span>Thêm mã giảm giá</span>
    </h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('coupons.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🎫 Mã giảm giá</label>
            <input type="text" name="code"
                class="border border-gray-300 rounded-xl px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                placeholder="Nhập mã giảm giá..." required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">💸 Giá trị giảm</label>
            <input type="text" name="discount_value"
                class="border border-gray-300 rounded-xl px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                placeholder="Ví dụ: 50000" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📅 Ngày hết hạn</label>
            <input type="date" name="expiry_date"
                class="border border-gray-300 rounded-xl px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                required>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md transition duration-200 ease-in-out flex items-center gap-1">
                💾 <span>Lưu mã</span>
            </button>
        </div>
    </form>
</div>
@endsection
