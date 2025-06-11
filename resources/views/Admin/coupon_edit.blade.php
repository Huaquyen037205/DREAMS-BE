@extends('template.admin')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-xl transition-shadow duration-300 hover:shadow-2xl border border-gray-100">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        ✏️ <span>Sửa mã giảm giá</span>
    </h2>

    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="code" class="block text-sm font-semibold text-gray-700 mb-1">🎫 Mã giảm giá</label>
            <input type="text" name="code" id="code" value="{{ $coupon->code }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Nhập mã..." required>
        </div>

        <div>
            <label for="discount_value" class="block text-sm font-semibold text-gray-700 mb-1">💸 Giá trị giảm</label>
            <input type="text" name="discount_value" id="discount_value" value="{{ $coupon->discount_value }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="Ví dụ: 100000" required>
        </div>

        <div>
            <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-1">📅 Ngày hết hạn</label>
            <input type="date" name="expiry_date" id="expiry_date"
                   value="{{ \Illuminate\Support\Str::substr($coupon->expiry_date, 0, 10) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   required>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md transition duration-200 ease-in-out flex items-center gap-1">
                💾 <span>Cập nhật mã</span>
            </button>
        </div>
    </form>
</div>
@endsection
