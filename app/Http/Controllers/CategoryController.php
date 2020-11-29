<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Categories';

        $categories = \Auth::user()->categories()->where('parent_category_id', null)->get();

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
        Category::create([
            'user_id'               => auth()->id(),
            'name'                  => $request->name,
            'parent_category_id'    => $request->parent_category_id,
            'icon'                  => $request->icon,
        ]);

        return redirect('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
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
     * @param \App\Category $category
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
     * @param \App\Category            $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        Category::where('user_id', Auth::id())
        ->where('id', $category->id)
        ->update([
            'name'                  => $request->name,
            'parent_category_id'    => $request->parent_category_id,
            'icon'                  => $request->icon
        ]);

        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
