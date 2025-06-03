@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Chi Tiết Chương Trình Flash Sale</div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-2">{{ $flashSale->name }}</h2>
        <div><b>Thời gian bắt đầu:</b> {{ $flashSale->start_time }}</div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Danh sách sản phẩm trong chương trình</h3>
        <table class="min-w-full table-auto text-left">
            <thead>
                <tr>
                    <th class="p-2">Tên sản phẩm</th>
                    <th class="p-2">Giá Flash Sale</th>
                    <th class="p-2">Số lượng</th>
                    <th class="p-2">Đã bán</th>
                    <th class="p-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flashSale->variants as $item)
                    <tr>
                        <td class="p-2">{{ $item->variant->product->name ?? '' }}</td>
                        <td class="p-2">{{ number_format($item->sale_price) }}</td>
                        <td class="p-2">{{ $item->flash_quantity }}</td>
                        <td class="p-2">{{ $item->flash_sold ?? 0 }}</td>
                        <td class="p-2">
                            <button
                                onclick="openEditModal({{ $item->id }}, '{{ $item->sale_price }}', '{{ $item->flash_quantity }}')"
                                class="text-blue-600 hover:underline mr-2">Sửa</button>

                            <form action="{{ route('flashsale.variant.destroy', [$flashSale->id, $item->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Sửa -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Sửa Sản Phẩm Flash Sale</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="variant_id" id="edit_variant_id">

                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Giá Flash Sale</label>
                    <input type="number" name="sale_price" id="edit_sale_price" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Số lượng</label>
                    <input type="number" name="flash_quantity" id="edit_flash_quantity" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function openEditModal(id, sale_price, flash_quantity) {
        document.getElementById('edit_variant_id').value = id;
        document.getElementById('edit_sale_price').value = sale_price;
        document.getElementById('edit_flash_quantity').value = flash_quantity;

        let form = document.getElementById('editForm');
        form.action = `/admin/flash-sale/{{ $flashSale->id }}/variant/${id}`;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
