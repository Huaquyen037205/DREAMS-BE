{{-- filepath: resources/views/Admin/Fl_edit.blade.php --}}
@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Chỉnh Sửa Chương Trình Flash Sale</div>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/flash-sale/' . $sale->id) }}" method="POST" class="bg-white p-6 rounded shadow w-full max-w-xl">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tên chương trình</label>
            <input type="text" name="name" value="{{ $sale->name }}"  class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($sale->start_time)->format('Y-m-d\TH:i') }}"  class="w-full border px-3 py-2 rounded" />
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Thời gian kết thúc</label>
            <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($sale->end_time)->format('Y-m-d\TH:i') }}"  class="w-full border px-3 py-2 rounded" />
        </div>

        <button class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Cập nhật</button>
    </form>
</main>
@endsection
