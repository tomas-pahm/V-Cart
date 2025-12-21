<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index(Request $request)
{
    $query = Category::withCount('products');

    // Search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Has product
    if ($request->has('has_product')) {
        if ($request->has_product === '1') {
            $query->has('products');
        } elseif ($request->has_product === '0') {
            $query->doesntHave('products');
        }
    }

    // Date filter
    if ($request->filled('date')) {

        if ($request->date === 'today') {
            $query->whereDate('created_at', today());

        } elseif ($request->date === 'week') {
            $query->where('created_at', '>=', now()->subDays(7));

        } elseif ($request->date === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);

        } elseif ($request->date === 'custom') {
            if ($request->filled('created_from')) {
                $query->whereDate('created_at', '>=', $request->created_from);
            }

            if ($request->filled('created_to')) {
                $query->whereDate('created_at', '<=', $request->created_to);
            }
        }
    }

    $categories = $query->orderBy('category_id', 'DESC')
                        ->paginate(10)
                        ->withQueryString();

    return view('admin.categories.index', compact('categories'));
}


public function create() {
    return view('admin.categories.create');
}

public function store(Request $request) {
    $request->validate(['name' => 'required|max:255']);
    Category::create(['name' => $request->name]);
    return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục!');
}

public function edit(Category $category) {
    return view('admin.categories.edit', compact('category'));
}

public function update(Request $request, Category $category) {
    $request->validate(['name' => 'required|max:255']);
    $category->update(['name' => $request->name]);
    return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
}

public function destroy(Category $category) {
    $category->delete();
    return back()->with('success', 'Đã xóa danh mục');
}

}
