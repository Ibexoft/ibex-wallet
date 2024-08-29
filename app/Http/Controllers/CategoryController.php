<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Categories';

        $categories = Auth::user()->categories()->where('parent_category_id', null)->get();
        return view(
            'categories.index',
            compact('categories', 'page_title')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::where('user_id', '=', auth()->id())->where('parent_category_id', null)->get();

        return view('categories.create', compact(['parentCategories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:35',
        ]);

        $subcategory = Category::create([
            'user_id'               => auth()->id(),
            'name'                  => $request->name,
            'parent_category_id'    => $request->parent_category_id,
            'icon'                  => $request->icon,
        ]);

        // Return a JSON response with the subcategory and a success flag
        return response()->json([
            'success' => true,
            'message' => "Category Added successfully",
            'subcategory' => $subcategory
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $page_title = 'Category';

        return view('categories.show', compact('category', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('user_id', '=', auth()->id())->where('parent_category_id', null)->get();

        return view('categories.create', compact(['category', 'parentCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category            $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Validate the input to ensure 'name' is present
        $request->validate([
            'name' => 'required|string|max:35',
        ]);

        // Update only the 'name' field of the category
        $category->where('user_id', Auth::id())
                ->where('id', $category->id)
                ->update([
                    'name' => $request->name,
                ]);

        return response()->json(['success' => true, 'message' => 'Category name updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $hasChildren = Category::where('parent_category_id', $category->id)->exists();
        $hasTransactions = \DB::table('transactions')->where('category_id', $category->id)->exists();

        if ($hasChildren) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a parent category'
            ]);
        }
        if($hasTransactions) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a category associated with a transaction'
            ]);
        }

        // If both checks pass, delete the category
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
