@extends('template.admin')
@section('content')
     <main class="flex-1 p-6 overflow-y-auto">
            <!-- Top bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-2xl font-semibold">Danh Sách Người Dùng</div>
                <a href="{{ url('/admin/add') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                    + Người Dùng
                </a>
            </div>

            <!-- Table -->
            <div class="bg-white p-4 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <div>Showing
                        <select class="border px-2 py-1 rounded ml-2">
                            <option>10</option>
                            <option>20</option>
                        </select>
                    </div>

                <form action="{{ url('/admin/searchUser') }}" method="GET" class="flex items-center">
                    <div>
                        <input type="text" name="search" class="border px-2 py-1 rounded" placeholder="Tìm kiếm người dùng..." >
                        <button class="ml-2 bg-indigo-500 text-white px-3 py-1 rounded">Tìm kiếm</button>
                    </div>
                </form>

                </div>

                <table class="min-w-full table-auto text-left">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                            <th class="p-2"><input type="checkbox"></th>
                            <th class="p-2">STT</th>
                            <th class="p-2">Tên Người Dùng</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Số Điện Thoại</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">Tình Trạng</th>
                            <th class="p-2">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample row -->
                        @foreach ( $users as  $user)
                             <tr class="border-t hover:bg-gray-50">
                            <td class="p-2"><input type="checkbox"></td>
                            <td class="p-2 text-indigo-600">{{$user->id}}</td>
                            <td class="p-2"><a href="/admin/profile/user">{{$user->name}}</a></td>
                            <td class="p-2">{{$user->email}}</td>
                            <td class="p-2">{{$user->phone}}</td>
                            <td class="p-2">
                                @if ($user->role == 'admin')
                                    <span class="bg-blue-100 text-blue-500 text-xs px-2 py-1 rounded">Admin</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">User</span>
                                @endif
                            @if ($user->is_active == 'on')
                                <td class="p-2">
                                    <span class="bg-green-100 text-green-500 text-xs px-2 py-1 rounded">Đang hoạt động</span>
                                </td>
                            @else
                                <td class="p-2">
                                    <span class="bg-red-100 text-red-500 text-xs px-2 py-1 rounded">Ngưng kích hoạt</span>
                                </td>
                            @endif

                            {{-- <td class="p-2">
                                @if ($product->status == 'còn hàng')
                                    <span class="bg-green-100 text-green-500 text-xs px-2 py-1 rounded">Còn hàng</span>
                                @else
                                    <span class="bg-red-100 text-red-500 text-xs px-2 py-1 rounded">Hết hàng</span>
                                @endif --}}
                            <td class="p-2 flex gap-2">
                                <a href="{{url ('/admin/editUser/'. $user->id )}}"  class="bg-green-100 text-green-500 px-2 py-1 rounded">
                                    <i class="ph ph-pencil"></i>
                                </a>
                                <button class="bg-red-100 text-red-500 px-2 py-1 rounded"><i class="ph ph-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </main>
@endsection
