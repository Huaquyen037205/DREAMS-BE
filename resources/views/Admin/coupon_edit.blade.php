@extends('template.admin')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        ✏️ Sửa mã giảm giá
    </h2>
    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Mã giảm giá</label>
            <input type="text" name="code" id="code" value="{{ $coupon->code }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
            <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-1">Giá trị giảm</label>
            <input type="text" name="discount_value" id="discount_value" value="{{ $coupon->discount_value }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
            <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn</label>
            <input type="date" name="expiry_date" id="expiry_date"
                   value="{{ \Illuminate\Support\Str::substr($coupon->expiry_date,0,10) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg transition duration-200 shadow">
                💾 Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
