@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-bold text-gray-800 mb-6">
        ➕ Thêm Sản Phẩm Vào: <span class="text-indigo-600">{{ $flashSale->name }}</span>
    </div>

    <form method="POST" action="{{ url('/admin/flash-sale/'.$flashSale->id.'/add-product') }}"
          class="bg-white p-6 rounded-lg shadow-md w-full max-w-2xl mx-auto">
        @csrf

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong class="font-semibold">Lỗi:</strong>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">📦 Chọn sản phẩm</label>
            <select id="productSelect" name="product_id"
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                            data-img="{{ $product->img && $product->img->first() ? asset('img/' . $product->img->first()->name) : '' }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            <div id="variantImgWrap" class="mt-3">
                <img id="variantImg" src="" alt="Ảnh sản phẩm"
                     class="max-w-[120px] rounded border border-gray-300 shadow-sm hidden">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">💰 Giá flash sale</label>
            <input type="number" name="sale_price" min="0"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required />
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">📦 Số lượng flash sale</label>
            <input type="number" name="flash_quantity" min="1"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" required />
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
                ✅ Thêm sản phẩm
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('productSelect');
            const img = document.getElementById('variantImg');
            select.addEventListener('change', function () {
                const selected = select.options[select.selectedIndex];
                const imgUrl = selected.getAttribute('data-img');
                if (imgUrl) {
                    img.src = imgUrl;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
            });
        });
    </script>
</main>
@endsection
