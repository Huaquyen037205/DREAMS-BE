<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CateList extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = Category::paginate(10);
        return view('Admin.CateList', compact('categories'));
    }

    // Hiển thị form tạo mới danh mục
    public function create()
    {
        return view('Admin.category_create');
    }

    // Xử lý lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        Category::create($request->only('name', 'description', 'status'));

        return redirect()->route('categories.index')->with('success', 'Tạo danh mục thành công!');
    }

    // Hiển thị chi tiết một danh mục
    public function show($id)
    {
        $category = Category::with('product')->findOrFail($id);
        return view('Admin.CateproList', compact('category'));
    }

    // Xử lý cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect('/admin/categories')->with('success', 'Cập nhật thành công!');
    }
}
