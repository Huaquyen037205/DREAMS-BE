@extends('template.admin')
@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Thông Báo</h2>
    <div class="space-y-4">
        @php
            $grouped = $notifications->groupBy(function($item) {
                return $item->created_at->format('d/m/Y');
            });
        @endphp

        @forelse($grouped as $date => $notis)
            <h4 class="font-bold text-indigo-600 mt-4 mb-2">{{ $date }}</h4>
            <ul class="mb-4">
                @foreach($notis as $notification)
                    @php
                        $message = $notification->message;
                        $isOrder = Str::contains($message, 'đơn hàng mới') || Str::contains($message, 'Đơn hàng');
                        $isOutOfStock = Str::contains($message, 'đã hết hàng');
                        $isLowStock = Str::contains($message, 'chỉ còn') && Str::contains($message, 'sản phẩm!');
                    @endphp

                    <li class="p-4 rounded-md shadow mb-2
                        @if($isOrder)
                            bg-green-100 border-l-4 border-green-500
                        @elseif($isOutOfStock)
                            bg-red-100 border-l-4 border-red-500
                        @elseif($isLowStock)
                            bg-yellow-100 border-l-4 border-yellow-500
                        @else
                            bg-blue-100 border-l-4 border-blue-500
                        @endif
                    ">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold
                                    @if($isOrder) text-green-700
                                    @elseif($isOutOfStock) text-red-700
                                    @elseif($isLowStock) text-yellow-700
                                    @else text-blue-700
                                    @endif
                                ">
                                    {{ $notification->message }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @empty
            <div class="text-gray-400">Không có thông báo nào.</div>
        @endforelse
    </div>
</div>
@endsection
