@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-bold text-gray-800 mb-6">🛠️ Chỉnh Sửa Chương Trình Flash Sale</div>

    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong class="font-semibold">Lỗi:</strong>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/flash-sale/' . $sale->id) }}" method="POST"
          class="bg-white p-6 rounded-lg shadow w-full max-w-2xl mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">📛 Tên chương trình</label>
            <input type="text" name="name" id="name"
                   value="{{ $sale->name }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div class="mb-5">
            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">🕒 Thời gian bắt đầu</label>
            <input type="datetime-local" name="start_time" id="start_time"
                   value="{{ \Carbon\Carbon::parse($sale->start_time)->format('Y-m-d\TH:i') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div class="mb-6">
            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">⏰ Thời gian kết thúc</label>
            <input type="datetime-local" name="end_time" id="end_time"
                   value="{{ \Carbon\Carbon::parse($sale->end_time)->format('Y-m-d\TH:i') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg transition duration-200">
                💾 Cập nhật
            </button>
        </div>
    </form>
</main>
@endsection
