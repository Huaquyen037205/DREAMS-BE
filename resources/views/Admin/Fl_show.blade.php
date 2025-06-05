@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Chi Tiết Chương Trình Flash Sale</div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-xl font-bold mb-2">{{ $flashSale->name }}</h2>
        <p class="text-gray-700"><strong>Thời gian bắt đầu:</strong> {{ $flashSale->start_time }}</p>
        <p class="text-gray-700"><strong>Thời gian kết thúc:</strong> {{ $flashSale->end_time }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">🛒 Danh sách sản phẩm trong chương trình</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left border border-gray-200 rounded-lg">
                <thead class="bg-indigo-100 text-sm text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">Tên sản phẩm</th>
                        <th class="px-4 py-3">Giá Flash Sale</th>
                        <th class="px-4 py-3">Số lượng</th>
                        <th class="px-4 py-3">Đã bán</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($flashSale->variants as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $item->variant->product->name ?? 'Không xác định' }}</td>
                            <td class="px-4 py-3 text-green-600 font-semibold">{{ number_format($item->sale_price) }}₫</td>
                            <td class="px-4 py-3">{{ $item->flash_quantity }}</td>
                            <td class="px-4 py-3">{{ $item->flash_sold ?? 0 }}</td>
                            <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                                <button
                                    onclick="openEditModal({{ $item->id }}, '{{ $item->sale_price }}', '{{ $item->flash_quantity }}')"
                                    class="text-blue-600 hover:underline">Sửa</button>

                                <form action="{{ route('flashsale.variant.destroy', [$flashSale->id, $item->id]) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($flashSale->variants->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Chưa có sản phẩm nào trong chương trình.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Sửa -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">✏️ Sửa Sản Phẩm Flash Sale</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="variant_id" id="edit_variant_id">

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Giá Flash Sale</label>
                    <input type="number" name="sale_price" id="edit_sale_price"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Số lượng</label>
                    <input type="number" name="flash_quantity" id="edit_flash_quantity"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</button>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Cập nhật</button>
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

        const form = document.getElementById('editForm');
        form.action = `/admin/flash-sale/{{ $flashSale->id }}/variant/${id}`;

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
@endsection
