@extends('template.admin')

@section('content')
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Thêm bài viết mới</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Form bên trái --}}
        <form action="{{ url('/admin/posts') }}" method="POST" enctype="multipart/form-data" id="post-form">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="block mb-1">Tiêu đề</label>
                <input type="text" name="title" id="title" class="border rounded w-full p-2" required>
            </div>

            {{-- Slug --}}
            <div class="mb-4">
                <label class="block mb-1">Slug (tự sinh nếu bỏ trống)</label>
                <input type="text" name="slug" class="border rounded w-full p-2">
            </div>

            {{-- Loại --}}
            <div class="mb-4">
                <label class="block mb-1">Loại</label>
                <select name="type" class="border rounded w-full p-2" required>
                    <option value="product">Sản phẩm</option>
                    <option value="event">Sự kiện</option>
                </select>
            </div>

            {{-- Product ID --}}
            <div class="mb-4">
                <label class="block mb-1">Sản phẩm liên kết (ID)</label>
                <input type="number" name="product_id" class="border rounded w-full p-2">
            </div>

            {{-- Trạng thái --}}
            <div class="mb-4">
                <label class="block mb-1">Trạng thái</label>
                <select name="status" class="border rounded w-full p-2">
                    <option value="draft">Nháp</option>
                    <option value="published">Công khai</option>
                </select>
            </div>

            {{-- Nổi bật --}}
            <div class="mb-4">
                <label class="block mb-1">Nổi bật?</label>
                <select name="is_featured" class="border rounded w-full p-2">
                    <option value="0">Không</option>
                    <option value="1">Có</option>
                </select>
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <label class="block mb-1">Tags (phân cách bằng dấu phẩy)</label>
                <input type="text" name="tags" id="tags" class="border rounded w-full p-2">
            </div>

            {{-- Nội dung --}}
            <div class="mb-4">
                <label class="block mb-1">Nội dung</label>
                <textarea name="content" id="content" class="border rounded w-full p-2 h-40" required></textarea>
            </div>

            {{-- Ảnh chính --}}
            <div class="mb-4">
                <label class="block mb-1">Ảnh chính</label>
                <input type="file" name="image" id="image" class="border rounded w-full p-2" accept="image/*">
            </div>

            {{-- Thumbnail --}}
            <div class="mb-4">
                <label class="block mb-1">Thumbnail</label>
                <input type="file" name="thumbnail" class="border rounded w-full p-2">
            </div>

            {{-- Ngày --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" class="border rounded w-full p-2">
                </div>
                <div>
                    <label class="block mb-1">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="border rounded w-full p-2">
                </div>
            </div>

            {{-- SEO --}}
            <div class="mb-4">
                <label class="block mb-1">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="border rounded w-full p-2">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Meta Description</label>
                <input type="text" name="meta_description" id="meta_description" class="border rounded w-full p-2">
            </div>

            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">
                Thêm bài viết
            </button>
        </form>
<div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
    {{-- Avatar + info --}}
    <div class="flex items-center px-6 pt-6 pb-4">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500 text-white flex items-center justify-center text-base font-bold shadow-md">
            U
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-900">Tác giả #1</p>
            <p class="text-xs text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="ml-auto text-xs text-gray-400 italic">#slug</div>
    </div>

    {{-- Ảnh chính --}}
    <img id="preview-image" class="w-full h-[300px] object-cover hidden" src="" alt="preview" />

    {{-- Nội dung bài viết --}}
    <div class="px-6 py-5">
        <h2 id="preview-title" class="text-xl font-bold mb-2 text-gray-800">Tiêu đề bài viết</h2>
        <p id="preview-meta-description" class="text-gray-500 italic text-sm mb-4">Meta description</p>

        <div id="preview-content" class="prose prose-sm prose-indigo max-w-none text-gray-800 mb-5">
            Nội dung bài viết sẽ hiển thị ở đây...
        </div>

        {{-- Tags --}}
        <div id="preview-tags" class="flex flex-wrap gap-2 text-xs text-gray-600 mb-4">
            {{-- Mỗi tag sẽ được render bằng JS --}}
        </div>

        <hr class="my-3">
        <div class="text-sm text-gray-400 italic">
            <div id="preview-meta-title"></div>
            <div id="preview-date-range"></div>
        </div>
    </div>
</div>

    </div>
</main>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bind = (id, cb) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => cb(el.value));
            }
        };

        // === Title ===
        bind('title', val => {
            document.getElementById('preview-title').innerText = val || 'Tiêu đề bài viết';
        });

        // === Content (hiển thị dưới dạng HTML) ===
        bind('content', val => {
            document.getElementById('preview-content').innerHTML = val || 'Nội dung bài viết sẽ hiển thị ở đây...';
        });

        // === Tags dạng #pill ===
        bind('tags', val => {
            const tagEl = document.getElementById('preview-tags');
            tagEl.innerHTML = '';
            if (val) {
                val.split(',').forEach(tag => {
                    const span = document.createElement('span');
                    span.className = 'bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full transition text-xs';
                    span.innerText = #${tag.trim()};
                    tagEl.appendChild(span);
                });
            }
        });

        // === Meta Title ===
        bind('meta_title', val => {
            const el = document.getElementById('preview-meta-title');
            el.innerText = val ? Meta Title: ${val} : '';
        });

        // === Meta Description ===
        bind('meta_description', val => {
            const el = document.getElementById('preview-meta-description');
            el.innerText = val ? val : '';
        });

        // === Date range ===
        const start = document.getElementById('start_date');
        const end = document.getElementById('end_date');
        const dateEl = document.getElementById('preview-date-range');

        const updateDateRange = () => {
            const startVal = start.value;
            const endVal = end.value;
            if (startVal || endVal) {
                dateEl.innerText = Thời gian: ${startVal || '...'} → ${endVal || '...'};
            } else {
                dateEl.innerText = '';
            }
        };

        if (start && end) {
            start.addEventListener('input', updateDateRange);
            end.addEventListener('input', updateDateRange);
        }

        // === Preview ảnh ===
        const imageInput = document.getElementById('image');
        const previewImg = document.getElementById('preview-image');

        if (imageInput && previewImg) {
            imageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('hidden');
                }
            });
        }
    });
</script>
