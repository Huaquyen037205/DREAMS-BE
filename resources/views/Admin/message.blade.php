@extends('template.admin')
@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md mt-6">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Đánh giá & Bình luận</h2>

    <div class="space-y-6">
        <!-- Bình luận 1 -->
        <div class="flex items-start space-x-4 border-b pb-4">
            <img src="https://i.pravatar.cc/40" alt="Avatar" class="w-10 h-10 rounded-full">
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold text-gray-700">Nguyễn Văn A</h4>
                    <span class="text-sm text-gray-400">27/05/2025</span>
                </div>
                <div class="flex items-center text-yellow-400 mt-1">
                    <!-- 4 sao -->
                    <span>★★★★☆</span>
                </div>
                <p class="mt-2 text-gray-600">Sản phẩm rất tốt, giao hàng nhanh. Sẽ ủng hộ lần sau!</p>
            </div>
            <div class="flex space-x-2 ml-4">
                <button class="text-sm text-blue-600 hover:underline">Ẩn</button>
                <button class="text-sm text-red-600 hover:underline">Xóa</button>
            </div>
        </div>

        <!-- Bình luận 2 -->
        <div class="flex items-start space-x-4">
            <img src="https://i.pravatar.cc/41" alt="Avatar" class="w-10 h-10 rounded-full">
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold text-gray-700">Trần Thị B</h4>
                    <span class="text-sm text-gray-400">25/05/2025</span>
                </div>
                <div class="flex items-center text-yellow-400 mt-1">
                    <!-- 5 sao -->
                    <span>★★★★★</span>
                </div>
                <p class="mt-2 text-gray-600">Rất hài lòng, nhân viên hỗ trợ nhiệt tình!</p>
            </div>
            <div class="flex space-x-2 ml-4">
                <button class="text-sm text-blue-600 hover:underline">Ẩn</button>
                <button class="text-sm text-red-600 hover:underline">Xóa</button>
            </div>
        </div>
    </div>
</div>

@endsection
