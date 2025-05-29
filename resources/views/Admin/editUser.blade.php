@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold mb-4">Chỉnh sửa</h2>
            <a href="{{ url('/admin/user/list') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                Danh sách người dùng
            </a>
        </div>

        @if (session('success'))
            <div class="flex items-center mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 4h2v6H9V4zm0 8h2v2H9v-2z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ url('/admin/editUser/' . $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full border px-3 py-2 rounded">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>user</option>
                </select>
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Trạng Thái Hoạt Động</label>
                <select name="is_active" class="w-full border px-3 py-2 rounded">
                    <option value="on" {{ $user->is_active == 'on' ? 'selected' : '' }}>Đang hoạt động</option>
                    <option value="off" {{ $user->is_active == 'off' ? 'selected' : '' }}>Ngưng kích hoạt</option>
                </select>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Cập nhật thông tin </button>
                <a href="{{ url('/admin/user/list') }}" class="ml-3 text-gray-600 hover:text-indigo-500">Hủy</a>
            </div>
        </form>
    </div>
</main>
@endsection
<script>
    setTimeout(() => {
        document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(el => el.remove());
    }, 4000);
</script>
