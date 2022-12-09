<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Purifier;

class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Services';

        $search = $request->search;

        $services = Service::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%');
        })->whereHas('category')->where('user_id', auth()->id())->latest()->with('category')->paginate();

        return view('frontend.user.provider.index', compact('pageTitle', 'services'));
    }

    public function createService()
    {
        $pageTitle = "Service Create";

        $categories = Category::where('status', 1)->latest()->get();

        return view('frontend.user.provider.service_create', compact('pageTitle', 'categories'));
    }

    public function storeService(Request $request)
    {

        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'duration' => 'required|between:0,5',
            'rate' => 'required',
            'status' => 'sometimes|in:0,1',
            'details' => 'required',
            'faq' => 'array',
            'video' => 'required|array',
            'service_image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'location' => 'required',
            'gallery_image' => 'array',
            'gallery_image.*' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $faq = [];

        foreach ($request->faq as $key => $value) {
            if($value['question'] == null || $value['answer'] == null){
                continue;
            }
            array_push($faq, array_filter($value, 'strlen'));
        }

        

        $images = [];

        if ($request->hasFile('service_image')) {
            $service_image = uploadImage($request->service_image, filePath('service'));
        }

        if ($request->has('gallery_image')) {
            foreach ($request->gallery_image as $key => $gallery) {
                $images[$key] = uploadImage($gallery, filePath('service'));
            }
        }


        Service::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'rate' => $request->rate,
            'duration' => $request->duration,
            'user_id' => auth()->id(),
            'status' => 0,
            'details' => Purifier::clean($request->details),
            'faq' => $faq,
            'video' => $request->video,
            'service_image' => $service_image ?? '',
            'gallery' => json_encode($images),
            'location' => json_encode($request->location)
        ]);

        $notify[] = ['success', 'Service Created Successfully'];

        return redirect()->route('user.service')->withNotify($notify);
    }

    public function serviceEdit(Service $service)
    {
        $pageTitle = "Service Edit";

        $categories = Category::where('status', 1)->latest()->get();

        return view('frontend.user.provider.service_edit', compact('pageTitle', 'categories', 'service'));
    }

    public function serviceUpdate(Request $request, Service $service)
    {

        
        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'duration' => 'required|between:0,5',
            'rate' => 'required',
            'status' => 'sometimes|in:0,1',
            'details' => 'required',
            'faq' => 'array',
            'video' => 'required|array',
            'service_image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'location' => 'required',
            'gallery_image' => 'sometimes|array',
            'gallery_image.*' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $faq = [];
        foreach ($request->faq as $key => $value) {
            if($value['question'] == null || $value['answer'] == null){
                continue;
            }
            array_push($faq, array_filter($value, 'strlen'));
        }

        $images = json_decode($service->gallery, true);

        if ($request->has('delete_image')) {
            foreach ($request->delete_image as $delete) {
                array_splice($images, $delete, 1);
            }
        }

        if ($request->hasFile('service_image')) {
            $service_image = uploadImage($request->service_image, filePath('service'), $service->service_image);
        }

        if ($request->has('gallery_image')) {
            foreach ($request->gallery_image as $key => $gallery) {
                
                if (array_key_exists($key, $images)) {
                   
                    $images[$key] = uploadImage($gallery, filePath('service'), json_decode($service->gallery, true)[$key]);
                } else {
                   
                    $images[$key] = uploadImage($gallery, filePath('service'),);
                }
            }
        }

      

        $service->update([
            'category_id' => $request->category,
            'name' => $request->name,
            'rate' => $request->rate,
            'duration' => $request->duration,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'details' => Purifier::clean($request->details),
            'faq' => $faq,
            'video' => $request->video,
            'service_image' => $service_image ?? $service->service_image,
            'gallery' => json_encode($images),
            'location' => $request->location
        ]);

        $notify[] = ['success', 'Service Updated Successfully'];

        return back()->withNotify($notify);
    }

    public function serviceDelete(Service $service)
    {
        
        if (!$service->bookings || $service->bookings()->where('is_completed', 0)->count() == 0) {

            if ($service->service_image) {
                unlink(filePath('service').'/'.$service->service_image);
            }


            if ($service->gallery != null) {
                foreach (json_decode($service->gallery, true) as  $gallery) {
                    unlink(filePath('service').'/'.$gallery);
                }
            }

            $service->delete();

            $notify[] = ['success', 'Service Deleted Successfully'];

            return back()->withNotify($notify);
        }

        $service->delete();

        $notify[] = ['success', 'Service Deleted Successfully'];

        return back()->withNotify($notify);
    }


    public function serviceProfile()
    {
        $pageTitle = "Service Profile";

        return view('frontend.user.provider.service_profile', compact('pageTitle'));
    }

    public function schedule()
    {
        $pageTitle = 'Schedule For Service';

        $weeks = Schedule::where('user_id', auth()->id())->paginate();

        return view('frontend.user.provider.service_schedule', compact('pageTitle', 'weeks'));
    }

    public function scheduleCreate(Request $request)
    {
        $request->validate([
            'weekname' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'status' => 'required|in:0,1'
        ]);


        $start_time = Carbon::createFromFormat('H:i a', $request->start_time);

        $end_time = Carbon::createFromFormat('H:i a', $request->end_time);

        $weeks = Schedule::where('user_id', auth()->id())->where('week_name', $request->weekname)->get();

        foreach ($weeks as $week) {
            if (Carbon::parse($week->start_time)->between($start_time, $end_time, true) || Carbon::parse($week->end_time)->between($start_time, $end_time, true)) {
                $notify[] = ['error', 'Already Have a Schedule in This Time'];

                return back()->withNotify($notify);
            }
        }

        Schedule::create([
            'user_id' => auth()->id(),
            'week_name' => $request->weekname,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $request->status
        ]);


        $notify[] = ['success', 'Successfully Added Schedule'];

        return back()->withNotify($notify);
    }

    public function scheduleUpdate(Request $request, Schedule $schedule)
    {
        $request->validate([
            'weekname' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'status' => 'required|in:0,1'
        ]);


        $start_time = Carbon::createFromFormat('H:i a', $request->start_time);

        $end_time = Carbon::createFromFormat('H:i a', $request->end_time);



        $weeks = Schedule::where('id', '!=', $schedule->id)->where('user_id', auth()->id())->where('week_name', $request->weekname)->get();



        foreach ($weeks as $week) {
            if (Carbon::parse($week->start_time)->between($start_time, $end_time, true) || Carbon::parse($week->end_time)->between($start_time, $end_time, true)) {
                $notify[] = ['error', 'Already Have a Schedule in This Time'];

                return back()->withNotify($notify);
            }
        }



        $schedule->update([
            'user_id' => auth()->id(),
            'week_name' => $request->weekname,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $request->status
        ]);


        $notify[] = ['success', 'Successfully updated Schedule'];

        return back()->withNotify($notify);
    }
}
