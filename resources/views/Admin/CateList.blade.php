@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-semibold">Danh Sách Danh Mục Sản Phẩm</div>
        <button onclick="openAddModal()" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
            + Thêm Danh Mục
        </button>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <table class="min-w-full table-auto text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                    <th class="p-2">STT</th>
                    <th class="p-2">Hình Ảnh</th>
                    <th class="p-2">Tên Danh Mục</th>
                    <th class="p-2">Trạng Thái</th>
                    <th class="p-2">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                <tr class="border-t hover:bg-gray-50"
                    style="cursor:pointer"
                    onclick="window.location='{{ url('/admin/categories/'.$category->id) }}'">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">
                        <img src="{{ asset('img/'.$category->image_url) }}" alt="Ảnh danh mục" class="w-16 h-16 object-cover rounded">
                    </td>
                    <td class="p-2">{{ $category->name }}</td>
                    <td class="p-2">
                        @if ($category->status)
                            <span class="text-green-600 text-sm">Hiển thị</span>
                        @else
                            <span class="text-red-600 text-sm">Ẩn</span>
                        @endif
                    </td>
                    <td class="p-2 flex gap-2" onclick="event.stopPropagation();">
                        <button
                            onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', {{ $category->status }})"
                            class="text-blue-500">Sửa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal Thêm -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Thêm Danh Mục Mới</h2>
            <form action="{{ url('/admin/categories') }}" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="mb-4">
                    <label class="block text-gray-700 mb-1" for="image_url">Thêm hình ảnh</label>
                    <input type="file" name="image_url" id="image_url" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1" for="name">Tên danh mục</label>
                    <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-300 rounded">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Sửa -->
    <div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Sửa Danh Mục</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Tên hình ảnh</label>
                    <input type="file" name="image_url" id="editImageUrl" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Tên danh mục</label>
                    <input type="text" name="name" id="editName" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" id="editStatus" class="w-full border rounded px-3 py-2">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- JavaScript điều khiển modal -->
<script>
    function openAddModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addCategoryModal').classList.add('hidden');
    }

    function openEditModal(id, name, status) {
        const modal = document.getElementById('editCategoryModal');
        document.getElementById('editName').value = name;
        document.getElementById('editStatus').value = status;
        document.getElementById('editForm').action = `/admin/categories/${id}`;
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
</script>
@endsection
