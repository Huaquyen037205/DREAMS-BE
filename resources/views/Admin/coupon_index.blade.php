{{-- filepath: c:\xampp\htdocs\duantn\DREAMS-BE\resources\views\admin\coupons\index.blade.php --}}
@extends('template.admin')
@section('content')
<h2 class="text-xl font-bold mb-4">Danh sách mã giảm giá</h2>
<a href="{{ route('coupons.create') }}" class="bg-indigo-500 text-white px-4 py-2 rounded">Thêm mã giảm giá</a>
<table class="min-w-full mt-4 bg-white border">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">Mã</th>
            <th class="py-2 px-4 border-b">Giá trị</th>
            <th class="py-2 px-4 border-b">Hạn dùng</th>
            <th class="py-2 px-4 border-b">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <td class="py-2 px-4 border-b">{{ $coupon->code }}</td>
            <td class="py-2 px-4 border-b">{{ $coupon->discount_value }}</td>
            <td class="py-2 px-4 border-b">{{ $coupon->expiry_date }}</td>
            <td class="py-2 px-4 border-b">
                <a href="{{ route('coupons.edit', $coupon->id) }}" class="text-blue-500">Sửa</a>
                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500" onclick="return confirm('Xóa?')">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
