{{-- filepath: resources/views/Admin/Fl_addp.blade.php --}}
@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Thêm Sản Phẩm Vào Chương Trình: {{ $flashSale->name }}</div>

    <form method="POST" action="{{ url('/admin/flash-sale/'.$flashSale->id.'/add-product') }}" class="bg-white p-6 rounded shadow w-full max-w-xl">
        @csrf

        {{-- Hiển thị lỗi nếu có --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Chọn sản phẩm</label>
            <select id="variantSelect" name="variant_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach ($variants as $variant)
                    <option
                        value="{{ $variant->id }}"
                        data-img="{{ $variant->img ? asset('img/' . $variant->img->name) : '' }}"
                    >
                        {{ $variant->product->name ?? 'Sản phẩm?' }} - Size: {{ $variant->size }}
                    </option>
                @endforeach
            </select>
            <div id="variantImgWrap" style="margin-top:10px;">
                <img id="variantImg" src="" alt="Ảnh sản phẩm" style="max-width:100px; display:none;">
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('variantSelect');
            const img = document.getElementById('variantImg');
            select.addEventListener('change', function() {
                const selected = select.options[select.selectedIndex];
                const imgUrl = selected.getAttribute('data-img');
                if(imgUrl) {
                    img.src = imgUrl;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }
            });
        });
        </script>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Giá flash sale</label>
            <input type="number" name="sale_price" min="0" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Số lượng flash sale</label>
            <input type="number" name="flash_quantity" min="1" required class="w-full border px-3 py-2 rounded" />
        </div>

        <button class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Thêm sản phẩm</button>
    </form>
</main>
@endsection
