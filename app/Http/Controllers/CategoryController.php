<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

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

        $categories = \Auth::user()->categories()->get();

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
        $page_title = 'Add Category';

        $parentCategories = Category::latest()->get();

        // $accounts = Account::where('user_id', '=', auth()->id())->get();
        // $tags = Tag::where('user_id', '=', auth()->id())->get();
        return view('categories.create', compact(['page_title', 'parentCategories']));
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
        //
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
        //
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
