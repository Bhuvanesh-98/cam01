<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index(Request $request)
    {

        
        $pageTitle = 'Manage Pages';

        $pages = Page::when($request->search, function($query) use($request){
            $query->where('name','LIKE','%'.$request->search.'%');
        })->orderBy('page_order','ASC')->paginate();

        $sections = [];

        $jsonUrl = resource_path('views/').'sections.json';


        $allSections = json_decode(file_get_contents($jsonUrl),true);

        

        foreach($allSections as $key => $section){
            if(isset($section['no_selection']) && $section['no_selection']){
                continue;
            }
           $sections[$key] = $section;
        }
       
        return view('admin.frontend.pages',compact('pageTitle','pages','sections'));
    }

    public function pageCreate()
    {
        $pageTitle = 'Create Page';

        $sections = [];

        $jsonUrl = resource_path('views/').'sections.json';


        $allSections = json_decode(file_get_contents($jsonUrl),true);

        

        foreach($allSections as $key => $section){
            if(isset($section['no_selection']) && $section['no_selection']){
                continue;
            }
           $sections[$key] = $section;
        }

        return view('admin.frontend.pages_create',compact('pageTitle', 'sections'));
    }

    public function pageInsert(Request $request)
    {
       
        $request->validate([
            'page' => 'required|unique:pages,name',
            'sections' => 'required|array',
            'seo_description' => 'required',
            'status' => 'required|in:0,1',
            'dropdown' => 'required|in:0,1',
            'page_order' => 'required|integer|min:1|unique:pages,page_order'
        ]);

        Page::create([
            'name' => $request->page,
            'sections' => array_unique($request->sections),
            'seo_description' => $request->seo_description,
            'slug' => Str::slug($request->page),
            'status' => $request->status,
            'is_dropdown' => $request->dropdown,
            'custom_section_data' => $request->custom_section,
            'page_order' => $request->page_order
        ]);

        $notify[] = ['success' ,'Page Created Successfully'];

        return redirect()->route('admin.frontend.pages')->withNotify($notify);
    }

    public function pageEdit(Request $request, Page $page)
    {
        $pageTitle ="Edit Page";

        $sections = [];

        $jsonUrl = resource_path('views/').'sections.json';


        $allSections = json_decode(file_get_contents($jsonUrl),true);

        

        foreach($allSections as $key => $section){
            if(isset($section['no_selection']) && $section['no_selection']){
                continue;
            }
           $sections[$key] = $section;
        }

        return view('admin.frontend.page_edit',compact('pageTitle','page','sections'));
    }

    public function pageUpdate(Request $request, Page $page)
    {

        $request->validate([
            'page' => 'required|unique:pages,name,'. $page->id,
            'sections' => 'required|array',
            'seo_description' => 'required',
            'status' => 'required|in:0,1',
            'dropdown' => 'required|in:0,1',
            'page_order' => 'required|integer|min:1|unique:pages,page_order,'.$page->id
        ]);
       

        $page->update([
            'name' => $request->page,
            'sections' => array_unique($request->sections),
            'seo_description' => $request->seo_description,
            'slug' => Str::slug($request->page),
            'status' => $request->status,
            'is_dropdown' => $request->dropdown,
            'custom_section_data' => $request->custom_section,
            'page_order' => $request->page_order
        ]);

        $notify[] = ['success' ,'Page Updated Successfully'];

        return back()->withNotify($notify);
    }

    public function pageDelete (Request $request,Page $page)
    {
        if($page->name == 'home'){

            $notify[] = ['error' ,'At least One page is Required'];

            return back()->withNotify($notify);
        }
        $page->delete();

        $notify[] = ['success' ,'Page Deleted Successfully'];

        return back()->withNotify($notify);
    }
}
