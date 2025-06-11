@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
        ➕ Thêm Sản Phẩm Vào:
        <span class="text-indigo-600">{{ $flashSale->name }}</span>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
            <strong class="font-semibold">Lỗi:</strong>
            <ul class="mt-2 list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/admin/flash-sale/'.$flashSale->id.'/add-product') }}"
          class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 w-full max-w-2xl mx-auto space-y-6">
        @csrf

        <!-- Sản phẩm -->
        <div>
            <label for="productSelect" class="block text-sm font-semibold text-gray-700 mb-2">📦 Chọn sản phẩm</label>
            <select id="productSelect" name="product_id"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                            data-img="{{ $product->img && $product->img->first() ? asset('img/' . $product->img->first()->name) : '' }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            <!-- Ảnh preview -->
            <div id="variantImgWrap" class="mt-4">
                <img id="variantImg" src="" alt="Ảnh sản phẩm"
                     class="max-w-[120px] h-auto rounded border border-gray-300 shadow-sm hidden transition-opacity duration-300">
            </div>
        </div>

        <!-- Giá Flash Sale -->
        <div>
            <label for="sale_price" class="block text-sm font-semibold text-gray-700 mb-2">💰 Giá flash sale</label>
            <input type="number" name="sale_price" id="sale_price" min="0" step="1000"
                   placeholder="Nhập giá giảm trong chương trình"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required />
        </div>

        <!-- Số lượng Flash Sale -->
        <div>
            <label for="flash_quantity" class="block text-sm font-semibold text-gray-700 mb-2">📦 Số lượng flash sale</label>
            <input type="number" name="flash_quantity" id="flash_quantity" min="1"
                   placeholder="Nhập số lượng áp dụng giảm giá"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required />
        </div>

        <!-- Nút submit -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                ✅ Thêm sản phẩm
            </button>
        </div>
    </form>

    <!-- JS hiện ảnh -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('productSelect');
            const img = document.getElementById('variantImg');

            select.addEventListener('change', function () {
                const selected = select.options[select.selectedIndex];
                const imgUrl = selected.getAttribute('data-img');
                if (imgUrl) {
                    img.src = imgUrl;
                    img.classList.remove('hidden');
                } else {
                    img.classList.add('hidden');
                }
            });
        });
    </script>
</main>
@endsection
