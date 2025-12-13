<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchKeyword = $request->get('search');
        $categories = Category::when($searchKeyword, function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories', 'searchKeyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validatedData);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        $searchKeyword = $request->get('search');

        $products = $category->products()
            ->with(['category', 'detail']) 
            ->when($searchKeyword, function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.show', compact('category', 'products', 'searchKeyword'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}