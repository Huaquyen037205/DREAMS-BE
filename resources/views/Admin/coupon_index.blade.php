@extends('template.admin')

@section('content')
<div class="p-6 min-h-screen bg-gradient-to-b from-gray-100 via-white to-gray-50">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">🎟 Danh sách mã giảm giá</h2>
            <p class="text-gray-500 mt-1">Quản lý, chỉnh sửa và xoá mã giảm giá đang hoạt động.</p>
        </div>
        <a href="{{ route('coupons.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg transition">
            ➕ Thêm mã giảm giá
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-xl rounded-2xl border border-gray-100">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Mã</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Giá trị</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Hạn dùng</th>
                    <th class="px-6 py-4 font-semibold uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $coupon->code }}</td>
                    <td class="px-6 py-4 text-green-600 font-semibold">{{ number_format($coupon->discount_value, 0, ',', '.') }}₫</td>
                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="inline-block px-3 py-1 text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md transition">
                            ✏️ Sửa
                        </a>
                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa mã này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded-md transition">
                                🗑 Xoá
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-gray-500 italic">
                        Không có mã giảm giá nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
