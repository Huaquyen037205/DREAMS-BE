{{-- filepath: c:\xampp\htdocs\duantn\DREAMS-BE\resources\views\Admin\Fl_addp.blade.php --}}
@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto bg-gray-50 min-h-screen">
    <div class="text-2xl font-bold text-gray-800 mb-8 flex items-center gap-2">
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
          class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 w-full max-w-2xl mx-auto space-y-6">
        @csrf

        <!-- Sản phẩm -->
        <div>
            <label for="productSelect" class="block text-sm font-semibold text-gray-700 mb-2">📦 Chọn sản phẩm</label>
            <select id="productSelect" name="product_id"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Chọn size -->
        <div class="mt-4">
            <label for="sizeSelect" class="block text-sm font-semibold text-gray-700 mb-2">📏 Chọn size</label>
            <select id="sizeSelect" name="size"
                    class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                    required>
                <option value="">-- Chọn size --</option>
            </select>
        </div>

        <!-- Hiện số lượng còn lại -->
        <div class="mt-2">
            <span id="stockInfo" class="text-sm text-gray-600"></span>
        </div>

        <!-- Ảnh preview -->
        <div id="variantImgWrap" class="mt-4">
            <img id="variantImg" src="" alt="" class="hidden w-32 h-32 object-cover rounded-lg border" />
        </div>

        <!-- Giá Flash Sale -->
        <div>
            <label for="sale_price" class="block text-sm font-semibold text-gray-700 mb-2">💰 Giá flash sale</label>
            <input type="number" name="sale_price" id="sale_price" min="0" step="1000"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required>
        </div>

        <!-- Số lượng Flash Sale -->
        <div>
            <label for="flash_quantity" class="block text-sm font-semibold text-gray-700 mb-2">📦 Số lượng flash sale</label>
            <input type="number" name="flash_quantity" id="flash_quantity" min="1"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                   required>
        </div>

        <!-- Nút submit -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Thêm vào flash sale
            </button>
        </div>
    </form>

    <!-- JS hiện ảnh, size, số lượng -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('productSelect');
            const img = document.getElementById('variantImg');
            const sizeSelect = document.getElementById('sizeSelect');
            const stockInfo = document.getElementById('stockInfo');
            const flashQuantity = document.getElementById('flash_quantity');

            let variants = [];

            select.addEventListener('change', function () {
                sizeSelect.innerHTML = '<option value="">-- Chọn size --</option>';
                stockInfo.textContent = '';
                flashQuantity.value = '';
                flashQuantity.max = '';
                img.classList.add('hidden');

                const productId = select.value;
                if (productId) {
                    fetch(`/admin/flash-sale/api/product/${productId}/variants`)
                        .then(res => res.json())
                        .then(data => {
                            variants = data;
                            data.forEach(variant => {
                                const opt = document.createElement('option');
                                opt.value = variant.size;
                                opt.textContent = variant.size;
                                sizeSelect.appendChild(opt);
                            });
                        });
                }
            });

            sizeSelect.addEventListener('change', function () {
                const variant = variants.find(v => v.size === sizeSelect.value);
                if (variant) {
                    stockInfo.textContent = `Số lượng còn lại: ${variant.quantity}`;
                    flashQuantity.max = variant.quantity;
                    if (variant.img) {
                        img.src = variant.img;
                        img.classList.remove('hidden');
                    } else {
                        img.classList.add('hidden');
                    }
                } else {
                    stockInfo.textContent = '';
                    flashQuantity.max = '';
                    img.classList.add('hidden');
                }
                flashQuantity.value = '';
            });

            flashQuantity.addEventListener('input', function () {
                const max = parseInt(flashQuantity.max, 10);
                if (max && flashQuantity.value > max) {
                    flashQuantity.value = max;
                }
            });
        });
    </script>
</main>
@endsection
