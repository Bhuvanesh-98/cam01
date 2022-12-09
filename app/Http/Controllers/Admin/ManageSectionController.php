<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\FaqCategory;
use App\Models\SectionData;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManageSectionController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Sections';

        $sections = [];

        $jsonUrl = resource_path('views/').'sections.json';

        $sections = array_filter(json_decode(file_get_contents($jsonUrl),true));
        
       

        return view('admin.frontend.sections', compact('pageTitle','sections'));
    }

    public function section(Request $request)
    {
        $search = $request->search;

        $pageTitle = "Manage {$request->name} Section";

        $section = $this->getJsonData($request->name);

        $content = SectionData::where('key', "$request->name.content")->first();


        $elements = SectionData::when($search,function($query) use ($search){
            return $query->where('data->heading','LIKE','%'.$search.'%');
        })->where('key', "$request->name.element")->latest()->paginate();

        return view('admin.frontend.index',compact('pageTitle','section','content','elements'));
    }

    public function sectionContentUpdate(Request $request)
    {

        $section = $this->getJsonData($request->name)['content'];
        
        $rules = [];

        foreach($section as $key => $sec){
           
            if($sec == 'file'){
                $rules += [
                    $key => 'sometimes|required|image|mimes:jpg,jpeg,png|max:4096'
                ];
            }elseif($sec == 'text'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'textarea'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'textarea_nic'){
                $rules += [
                    $key => 'required'
                ];
            }
        }
        $data = [];

        $data = $request->validate($rules);

        $content = SectionData::where('key', "$request->name.content")->first();

       

        if(in_array('file', array_values($section))){
            $key = array_search('file',$section);
 
            if($request->hasFile($key)){
               
                $filename = uploadImage($request->$key,filePath($request->name), @$content->data->$key);
 
                $data[$key] = $filename;
            }else{
                $data[$key] = @$content->data->$key;
            }
         }
       
       if(!$content){
            SectionData::create([
                'key' => "$request->name.content",
                'data' => $data
            ]);

       }else{
        $content->data = $data;

        $content->save();
       }


       $notify[] = ['success', "{$request->name} Created Successfully"];

       return redirect()->back()->withNotify($notify);

    }

    public function sectionElement(Request $request)
    {
        $pageTitle = ucwords($request->name)." Element";

        $section = $this->getJsonData($request->name)['element'];


        if($request->name == 'faq'){
            $categories = FaqCategory::latest()->get();
        }else{

            $categories = BlogCategory::latest()->get();
        }

       
        return view('admin.frontend.element',compact('pageTitle','section','categories'));
    }

    public function sectionElementCreate(Request $request)
    {
       
        
        $section = $this->getJsonData($request->section)['element'];
        

        $rules = [];

        foreach($section as $key => $sec){
            
            if($sec == 'on'){
                $rules += [
                    'category' => 'required'
                ];
            }
            elseif($sec == 'file'){
                $rules += [
                    $key => 'required|image|mimes:jpg,jpeg,png|max:4096'
                ];
            }elseif($sec == 'text'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'textarea' || $sec == 'textarea_nic'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'icon'){
                $rules += [
                    $key => 'required'
                ];
            }
        }

        $data = $request->validate($rules);

        if(array_key_exists('unique',$section)){
            $uniqueField = $section['unique'];

            $isDataFound = SectionData::whereJsonContains("data->$uniqueField", $request->$uniqueField)->first();

            if($isDataFound){
               
                $notify[] = ['error', "Already has a {$request->section} {$uniqueField}"];

                return redirect()->back()->withNotify($notify);
            }
        }

        
        if(array_key_exists('slug',$section)){
            $data['slug'] = Str::slug($request->slug);
        }
        

        if(in_array('file', array_values($section))){
           $key = array_search('file',$section);

           if($key && $request->hasFile($key)){

               $filename = uploadImage($request->$key,filePath($request->section));

               $data[$key] = $filename;
           }
        }

        SectionData::create([
            'key' => "$request->section.element",
            'category' => make_clean($request->category) ?? '',
            'data' => $data
        ]);

        $notify[] = ['success', "{$request->section} Created Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function editElement($name, SectionData $element)
    {
        $pageTitle = 'Edit Element';

        $section = $this->getJsonData($name)['element'];

        if($name == 'faq'){
            $categories = FaqCategory::latest()->get();
        }else{

            $categories = BlogCategory::latest()->get();
        }

        return view('admin.frontend.edit', compact('pageTitle','element','section','name','categories'));
    }

    public function updateElement($name, SectionData $element, Request $request)
    {
        $section = $this->getJsonData($request->name)['element'];

        

        $rules = [];

        foreach($section as $key => $sec){
            if($sec == 'on'){
                $rules += [
                    'category' => 'required'
                ];
            }
            elseif($sec == 'file'){
                $rules += [
                    $key => 'sometimes|image|mimes:jpg,jpeg,png|max:4096'
                ];
            }elseif($sec == 'text'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'textarea' || $sec == 'textarea_nic'){
                $rules += [
                    $key => 'required'
                ];
            }elseif($sec == 'icon'){
                $rules += [
                    $key => 'required'
                ];
            }
        }


        $data = $request->validate($rules);

        if(array_key_exists('is_category', $data)){

            unset($data['category']);
        }

        if(array_key_exists('unique',$section)){
            $uniqueField = $section['unique'];

            $isDataFound = SectionData::where('id','!=',$element->id)->whereJsonContains("data->$uniqueField", $request->$uniqueField)->first();

            if($isDataFound){
               
                $notify[] = ['error', "Already has a {$request->section} {$uniqueField}"];

                return redirect()->back()->withNotify($notify);
            }
        }

        $image = array_search('file',$section);

        
        if($image && in_array('file', array_values($section))){
           
           if($request->hasFile($image)){
                
               $filename = uploadImage($request->$image,filePath($request->name), $element->data->$image);

               $data[$image] = $filename;
           }
        }

        if($image && !array_key_exists($image, $data)){
            $data[$image] = $element->data->$image;
        }

        if(array_key_exists('slug',$section)){
            $data['slug'] = Str::slug($request->slug);
        }

        $element->update([
            'data' => $data,
            'category' => make_clean($request->category) ?? null
        ]);

        $notify[] = ['success', "{$name} Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }

    public function deleteElement($name, SectionData $element)
    {
        
        $section = $this->getJsonData($name)['element'];

        if(in_array('file', array_values($section))){

            $image = array_search('file',$section);

            
            unlink(filePath($name).'/'.$element->data->$image);
        }

        $element->delete();

        $notify[] = ['success', "{$name} Deleted Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    private function getJsonData($name){

        $jsonUrl = resource_path('views/').'sections.json';

        $sections = json_decode(file_get_contents($jsonUrl),true);

        return $sections[$name] ?? [];
    }

    public function blogCategory()
    {
        $pageTitle = "Manage Blog Category";


        $categories = BlogCategory::latest()->paginate();
        
        return view('admin.frontend.blog',compact('categories','pageTitle'));

    }

    public function blogCategoryStore(Request $request)
    {
       $request->validate([
           'name' => 'required|unique:blog_categories,name',
           'slug' => 'required|unique:blog_categories,slug'
       ]);

       BlogCategory::create(
           [
            'name' => $request->name,
            'slug' => $request->slug
           ]
           );

           $notify[] = ['success', "Blog Category Added Successfully"];

           return redirect()->back()->withNotify($notify);
    }

    public function blogCategoryUpdate(Request $request,BlogCategory $blog)
    {
       
        $request->validate([
            'name' => ['required',Rule::unique('blog_categories','name')->ignore($blog->id)],
            'slug' => ['required',Rule::unique('blog_categories','slug')->ignore($blog->id)],
        ]);

        $blog->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        $notify[] = ['success', "Blog Category Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function blogCategoryDelete(BlogCategory $blog)
    {
        $blog->delete();

        $notify[] = ['success', "Blog Category Deleted Successfully"];

        return redirect()->back()->withNotify($notify);

    }
    public function faqCategory()
    {
        $pageTitle = "Manage Faq Category";

        $categories = FaqCategory::latest()->paginate();
        
        return view('admin.frontend.faq',compact('categories','pageTitle'));

    }

    public function faqCategoryStore(Request $request)
    {
       $request->validate([
           'name' => 'required|unique:blog_categories,name'
       ]);

       FaqCategory::create(
           [
            'name' => $request->name
           ]
           );

           $notify[] = ['success', "Faq Category Added Successfully"];

           return redirect()->back()->withNotify($notify);
    }

    public function faqCategoryUpdate(Request $request,FaqCategory $faq)
    {
       
        $request->validate([
            'name' => ['required',Rule::unique('faq_categories','name')->ignore($faq->id)]
        ]);

        $faq->update([
            'name' => $request->name
        ]);

        $notify[] = ['success', "Faq Category Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }

    public function faqCategoryDelete(FaqCategory $faq)
    {
        $faq->delete();

        $notify[] = ['success', "Faq Category Deleted Successfully"];

        return redirect()->back()->withNotify($notify);

    }
}
