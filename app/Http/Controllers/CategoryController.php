<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategorija sėkmingai pridėta.');
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategorija sėkmingai atnaujinta.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();

        if ($category->tickets()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Negalima pašalinti kategorijos, nes ji naudojama problemose.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategorija pašalinta.');
    }

    private function authorizeAdmin(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}