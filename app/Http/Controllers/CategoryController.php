<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category, Request $request)
    {
        // Start building the query to retrieve permissions using Eloquent ORM
        $categories = $category::query();

        // If a search query is provided, filter permissions based on the name or description matching the search query
        $searchQuery = $request->input('search');
        if (!empty($searchQuery)) {
            $categories->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            });
        }
        $categories->where(function ($query) {
            $query->where('user_id', config('panel.super_admin'))
                  ->orWhere('user_id', auth()->user()->id ?? '');
        });
        // Pass the permissions and search query to the view
        return view('category.index', ['categories' => $categories->paginate(10), 'searchQuery' => $searchQuery,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $category = Category::create(['name' => $request->input('name'), 'user_id' => auth()->user()->id,]);
        if($category){
            return redirect()->route('category.index')->with('success', 'Successfully created Category!');
        }
        return redirect()->back()->with('error', 'Unable to create Category!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $category = Category::where('id', $id)->first();
        if($category){
            return view('category.edit', compact('category'));
        }
        return redirect()->back()->with('error', 'Category not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $category = Category::where('id', $id)->first();
        if($category){
            if($category->update(['name' => $request->input('name')])){
                return redirect()->back()->with('success', 'Successfully updated category!');
            }
            return redirect()->back()->with('error', 'Failed to update category!');
        }
        return redirect()->back()->with('error', 'Category not found');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $category = Category::where('id', $id)->first();
        if($category){
            if($category->delete()){
                return redirect()->back()->with('success', 'Successfully deleted category!');
            }
            return redirect()->back()->with('error', 'Failed to delete category!');
        }
        return redirect()->back()->with('error', 'Category not found');
    }
}
