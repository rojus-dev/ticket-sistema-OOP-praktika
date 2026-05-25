<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali valdyti kategorijas.');
        }

        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali kurti kategorijas.');
        }

        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali išsaugoti kategorijas.');
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorija sėkmingai pridėta.');
    }

    public function edit(Category $category)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali redaguoti kategorijas.');
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali atnaujinti kategorijas.');
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategorija sėkmingai atnaujinta.');
    }

    public function destroy(Category $category)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tik administratorius gali šalinti kategorijas.');
        }

        if ($category->tickets()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Negalima pašalinti kategorijos, nes ji naudojama problemose.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategorija pašalinta.');
    }
}