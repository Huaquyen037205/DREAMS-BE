{{-- filepath: c:\xampp\htdocs\duantn\DREAMS-BE\resources\views\admin\coupon_edit.blade.php --}}
@extends('template.admin')
@section('content')
<h2 class="text-xl font-bold mb-4">Sửa mã giảm giá</h2>
<form action="{{ route('coupons.update', $coupon->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block">Mã giảm giá</label>
        <input type="text" name="code" value="{{ $coupon->code }}" class="border rounded px-3 py-2 w-full" required>
    </div>
    <div>
        <label class="block">Giá trị giảm</label>
        <input type="text" name="discount_value" value="{{ $coupon->discount_value }}" class="border rounded px-3 py-2 w-full" required>
    </div>
    <div>
        <label class="block">Ngày hết hạn</label>
        <input type="date" name="expiry_date" value="{{ \Illuminate\Support\Str::substr($coupon->expiry_date,0,10) }}" class="border rounded px-3 py-2 w-full" required>
    </div>
    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">Cập nhật</button>
</form>
@endsection
