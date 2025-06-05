@extends('template.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">🎟 Danh sách mã giảm giá</h2>
        <a href="{{ route('coupons.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded shadow">
            ➕ Thêm mã giảm giá
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-100 text-gray-700">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold uppercase">Mã</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold uppercase">Giá trị</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold uppercase">Hạn dùng</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($coupons as $coupon)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $coupon->code }}</td>
                    <td class="px-6 py-4 text-sm text-green-600 font-semibold">{{ number_format($coupon->discount_value, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm space-x-3">
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="text-blue-600 hover:underline font-medium">Sửa</a>
                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa mã này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($coupons->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Không có mã giảm giá nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
