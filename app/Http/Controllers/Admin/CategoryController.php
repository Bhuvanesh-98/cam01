<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageTitle = 'All Categories';

        $search = $request->search;

        $categories = Category::when($request, function($query) use($search){
            $query->where('name','LIKE','%'.$search.'%')->get();
        })->latest()->paginate();

        

        return view('admin.category.index',compact('pageTitle','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $pageTitle = 'Create Category';

       return view('admin.category.create',compact('pageTitle'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'status' => 'required|in:0,1',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if($request->hasFile('image')){
            $filename = uploadImage($request->image,filePath('category'));
        }
       

        Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'image' => $filename
        ]);

        $notify[] = ['success','Category Created Successfully'];

        return redirect()->route('admin.category.store')->withNotify($notify);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $pageTitle = 'Edit Category';

        return view('admin.category.edit',compact('pageTitle','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', Rule::unique('categories')->ignore($category->id)],
            'status' => 'required|in:0,1',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg'
        ]);

        
        if($request->hasFile('image')){
            $filename = uploadImage($request->image,filePath('category'), $category->image);
        }

     

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'image' => $filename ?? $category->image
        ]);

        $notify[] = ['success','Category Updated Successfully'];

        return redirect()->back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        @unlink(filePath('category').'/'.$category->image);
       

        $category->delete();

        $notify[] = ['success','Category Deleted Successfully'];

        return redirect()->back()->withNotify($notify);
    }
}
