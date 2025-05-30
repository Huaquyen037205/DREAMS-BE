@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Tạo Chương Trình Flash Sale</div>

    <form action="{{ url('/admin/flash-sale') }}" method="POST" class="bg-white p-6 rounded shadow w-full max-w-xl">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tên chương trình</label>
            <input type="text" name="name" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time" required class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Thời gian kết thúc</label>
            <input type="datetime-local" name="end_time" required class="w-full border px-3 py-2 rounded" />
        </div>

        <button class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Tạo chương trình</button>
    </form>
</main>
@endsection
