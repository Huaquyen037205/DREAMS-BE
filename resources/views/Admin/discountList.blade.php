@extends('template.admin')
@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Danh Sách Mã Giảm Giá</h2>
        <a href="{{url('/admin/addDiscount')}}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            + Mã Giảm Giá
        </a>
    </div>

    <form method="GET" action="/admin/searchDiscount" class="mb-4 flex items-center gap-2">
        <input type="text" name="search" placeholder="Tìm mã giảm giá..." class="border px-3 py-2 rounded w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">STT</th>
                <th class="py-2 px-4 border">Chương trình giảm giá</th>
                <th class="py-2 px-4 border">Phần Trăm</th>
                <th class="py-2 px-4 border">Ngày Bắt Đầu</th>
                <th class="py-2 px-4 border">Ngày Kết Thúc</th>
                <th class="py-2 px-4 border">Tình Trạng</th>
                <th class="py-2 px-4 border">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $index => $discount)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                    <td class="py-2 px-4 border">{{ $discount->name }}</td>
                    <td class="py-2 px-4 border">{{ $discount->percentage }}%</td>
                    <td class="py-2 px-4 border">{{$discount->start_day ? \Carbon\Carbon::parse($discount->start_day)->format('d-m-Y') : '' }}</td>
                    <td class="py-2 px-4 border">{{$discount->end_day ? \Carbon\Carbon::parse($discount->end_day)->format('d-m-Y') : '' }}</td>
                    <td class="py-2 px-4 border">
                        @if(now()->between($discount->start_day, $discount->end_day))
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Đang hoạt động</span>
                        @elseif (now()->lt($discount->start_day))
                            <span class="bg-yellow-100 text-red-700 px-2 py-1 rounded text-sm">Sắp bắt đầu</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Hết hạn</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border flex justify-center gap-2">
                        <a href={{url('/admin/editDiscount/' . $discount->id) }} class="bg-green-100 text-green-500 px-2 py-1 rounded">
                            <i class="ph ph-pencil"></i>
                        </a>
                        <a href="{{url('/admin/discount/detail/' . $discount->id)}}" class="bg-green-100 text-green-500 px-2 py-1 rounded">
                            <i class="ph ph-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
