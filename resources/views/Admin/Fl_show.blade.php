@extends('template.admin')

@section('content')
<main class="flex-1 px-4 md:px-8 py-6 overflow-y-auto bg-gray-50 min-h-screen">
    <div class="text-2xl font-semibold mb-6 text-indigo-700">⚡ Chi Tiết Chương Trình Flash Sale</div>

    <div class="bg-white p-6 rounded-2xl shadow mb-6 border border-gray-200">
        <h2 class="text-xl font-bold mb-2">{{ $flashSale->name }}</h2>
        <p class="text-gray-700"><strong>⏰ Thời gian bắt đầu:</strong> {{ $flashSale->start_time }}</p>
        <p class="text-gray-700"><strong>⏰ Thời gian kết thúc:</strong> {{ $flashSale->end_time }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">🛒 Danh sách sản phẩm trong chương trình</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow">
                <thead class="bg-indigo-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Tên sản phẩm</th>
                        <th class="px-4 py-3 text-center">Size</th>
                        <th class="px-4 py-3 text-center">Giá Flash Sale</th>
                        <th class="px-4 py-3 text-center">Số lượng</th>
                        <th class="px-4 py-3 text-center">Đã bán</th>
                        <th class="px-4 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $grouped = $flashSale->variants->groupBy(function($item) {
                            return $item->variant->product->id ?? 0;
                        });
                    @endphp
                    @foreach ($grouped as $productId => $items)
                        @php
                            $productName = $items->first()->variant->product->name ?? 'Không xác định';
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-bold align-middle" rowspan="{{ $items->count() }}">{{ $productName }}</td>
                            <td class="px-4 py-3 text-center align-middle">{{ $items[0]->variant->size ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-green-600 font-semibold align-middle">{{ number_format($items[0]->sale_price) }}₫</td>
                            <td class="px-4 py-3 text-center align-middle">{{ $items[0]->flash_quantity }}</td>
                            <td class="px-4 py-3 text-center align-middle">{{ $items[0]->flash_sold ?? 0 }}</td>
                            <td class="px-4 py-3 text-center space-x-2 align-middle">
                                <button onclick="openEditModal({{ $items[0]->id }}, '{{ $items[0]->sale_price }}', '{{ $items[0]->flash_quantity }}')"
                                        class="px-3 py-1 text-sm text-white bg-blue-500 hover:bg-blue-600 rounded shadow transition">
                                    Sửa
                                </button>
                                <form action="{{ route('flashsale.variant.destroy', [$flashSale->id, $items[0]->id]) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded shadow transition">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @for ($i = 1; $i < $items->count(); $i++)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-center align-middle">{{ $items[$i]->variant->size ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-green-600 font-semibold align-middle">{{ number_format($items[$i]->sale_price) }}₫</td>
                                <td class="px-4 py-3 text-center align-middle">{{ $items[$i]->flash_quantity }}</td>
                                <td class="px-4 py-3 text-center align-middle">{{ $items[$i]->flash_sold ?? 0 }}</td>
                                <td class="px-4 py-3 text-center space-x-2 align-middle">
                                    <button onclick="openEditModal({{ $items[$i]->id }}, '{{ $items[$i]->sale_price }}', '{{ $items[$i]->flash_quantity }}')"
                                            class="px-3 py-1 text-sm text-white bg-blue-500 hover:bg-blue-600 rounded shadow transition">
                                        Sửa
                                    </button>
                                    <form action="{{ route('flashsale.variant.destroy', [$flashSale->id, $items[$i]->id]) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded shadow transition">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endfor
                    @endforeach

                    @if($flashSale->variants->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">Chưa có sản phẩm nào trong chương trình.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal chỉnh sửa -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-indigo-700">🛠 Sửa Thông Tin Sản Phẩm</h2>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_variant_id" name="variant_id">
            <div>
                <label class="block text-sm font-medium text-gray-600">Giá Flash Sale</label>
                <input type="number" id="edit_sale_price" name="sale_price"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Số lượng</label>
                <input type="number" id="edit_flash_quantity" name="flash_quantity"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded">
                    Hủy
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</div>

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
