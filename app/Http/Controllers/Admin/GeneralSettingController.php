<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = 'General Setting';

        $general = GeneralSetting::first();

        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));

        return view('admin.setting.general', compact('pageTitle', 'general','timezones'));
    }

    public function generalSettingUpdate(Request $request)
    {
       
        $general = GeneralSetting::first();

        $request->validate([
            'sitename' => 'required',
            'site_currency' => 'required',
            'logo' => [Rule::requiredIf(function () use ($general) {return !$general;}),'image','mimes:jpg,jpeg,png'],
            'icon' => [Rule::requiredIf(function () use ($general) {return !$general;}),'image','mimes:jpg,jpeg,png'],
            'user_reg' => 'required|integer|in:0,1',
            'color' => 'required',
            'currency_icon' => 'required',
            'blog_comment' => 'required',
            'secondary_color' => 'required',
            'fb_app_key' => 'sometimes|required',
            'default_image' => 'sometimes|image|mimes:jpg,jpeg,png',
            'commission' => 'required|numeric',
            'service_default_image' => 'sometimes|image|mimes:jpg,png,jpeg'
        ]);

        

        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = '.$request->timezone.' ?>';
        file_put_contents($timezoneFile, $content);

        

        if (!$general) {
            if ($request->hasFile('logo')) {
                $filename = 'logo' . '.' . $request->logo->getClientOriginalExtension();
                @unlink(getFile('logo', @$general->logo));
                $request->logo->move(filePath('logo'), $filename);
            }

            if ($request->hasFile('icon')) {
                $icon = 'icon' . '.' . $request->icon->getClientOriginalExtension();
                @unlink(getFile('logo',@$general->icon));
                $request->icon->move(filePath('logo'), $icon);
            }
            
            if ($request->hasFile('default_image')) {
                $default_image = 'default_image' . '.' . $request->default_image->getClientOriginalExtension();
                @unlink(getFile('logo',@$general->default_image));
                $request->default_image->move(filePath('logo'), $default_image);
            }
            
            if ($request->hasFile('service_default_image')) {
                $service_default_image = 'service_default_image' . '.' . $request->service_default_image->getClientOriginalExtension();
                @unlink(getFile('logo',@$general->service_default_image));
                $request->service_default_image->move(filePath('logo'), $service_default_image);
            }
            GeneralSetting::create([
                'sitename' => $request->sitename,
                'site_currency' => $request->site_currency,
                'logo' => $filename,
                'icon' => $icon,
                'user_reg' => $request->user_reg,
                'color' => $request->color,
                'currency_icon' => $request->currency_icon,
                'blog_comment' => $request->blog_comment,
                'secondary_color' => $request->secondary_color,
                'fb_app_key' => $request->fb_app_key,
                'default_image' => $default_image,
                'commission' => $request->commission,
                'service_default_image' => $service_default_image
            ]);

            $notify[] = ['success', "Setting Updated Successfully"];

            return redirect()->back()->withNotify($notify);
        }

        if ($request->hasFile('logo')) {
            $filename = 'logo' . '.' . $request->logo->getClientOriginalExtension();

            $request->logo->move(filePath('logo'), $filename);
        }

        if ($request->hasFile('icon')) {
            $icon = 'icon' . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(filePath('logo'), $icon);
        }


        if ($request->hasFile('default_image')) {
            $default_image = 'default_image' . '.' . $request->default_image->getClientOriginalExtension();
            @unlink(getFile('logo',@$general->default_image));
            $request->default_image->move(filePath('logo'), $default_image);
        }

        if ($request->hasFile('service_default_image')) {
            $service_default_image = 'service_default_image' . '.' . $request->service_default_image->getClientOriginalExtension();
            @unlink(getFile('logo',@$general->service_default_image));
            $request->service_default_image->move(filePath('logo'), $service_default_image);
        }


        $general->update([
            'sitename' => $request->sitename,
            'site_currency' => $request->site_currency,
            'logo' => $filename ?? $general->logo,
            'icon' => $icon ?? $general->icon,
            'user_reg' => $request->user_reg,
            'color' => $request->color,
            'currency_icon' => $request->currency_icon,
            'blog_comment' => $request->blog_comment,
            'secondary_color' => $request->secondary_color,
            'fb_app_key' => $request->fb_app_key,
            'default_image' => $default_image ?? $general->default_image,
            'commission' => $request->commission,
            'service_default_image' => $service_default_image ?? $general->service_default_image
            
        ]);

        $notify[] = ['success', "Setting Updated Successfully"];

        return redirect()->back()->withNotify($notify);
    }


    public function preloader ()
    {
        $pageTitle = 'Preloader Setting';

        $general = GeneralSetting::first();

        return view('admin.setting.preloader',compact('pageTitle','general'));
    }

    public function preloaderUpdate(Request $request)
    {
        $general = GeneralSetting::first();

        $request->validate([
            'preloader_status' => 'required',
            'preloader_image' => 'sometimes|required|image|mimes:jpg,png,gif,jpeg'
        ]);

        if($request->hasFile('preloader_image')){
            $filename = uploadImage($request->preloader_image,filePath('preloader'),$general->preloader_image);

            $general->preloader_image = $filename;
        }

        $general->preloader_status = $request->preloader_status;

        $general->save();



        $notify[] = ['success', "Preloader Updated Successfully"];

        return redirect()->back()->withNotify($notify);

       
    }
    
    public function analytics ()
    {
        $pageTitle = 'Google Analytics Setting';

        $general = GeneralSetting::first();

        return view('admin.setting.analytics',compact('pageTitle','general'));
    }

    public function analyticsUpdate(Request $request)
    {
        $general = GeneralSetting::first();

        $data = $request->validate([
            'analytics_key' => 'required',
            'analytics_status' => 'required'
        ]);

        $general->update($data);

      
        $notify[] = ['success', "Analytics Updated Successfully"];

        return redirect()->back()->withNotify($notify);

       
    }

    public function cookieConsent()
    {
        $pageTitle = 'Cookie Consent';

        $cookie = CookieConsent::first();

        return view('admin.setting.cookie',compact('pageTitle','cookie'));
    }

    public function cookieConsentUpdate(Request $request)
    {
        $data = $request->validate([
            'allow_modal' => 'required|integer',
            'button_text' => 'required|max:100',
            'cookie_text' => 'required'
        ]);

        $cookie = CookieConsent::first();

        if(!$cookie){
            CookieConsent::create($data);

            $notify[] = ['success', "Cookie Consent Created Successfully"];

            return redirect()->back()->withNotify($notify);

        }


        $cookie->update($data);

        $notify[] = ['success', "Cookie Consent Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }

    public function rechaptcha()
    {
        $pageTitle = 'Google Recaptcha';

        $rechaptcha = GeneralSetting::first();

        return view('admin.setting.recaptcha',compact('pageTitle','rechaptcha'));
    }

    public function rechaptchaUpdate(Request $request)
    {
        $data = $request->validate([
            'allow_recaptcha' => 'required',
            'recaptcha_key' => 'required',
            'recaptcha_secret' => 'required'
        ]);

        $rechaptcha = GeneralSetting::first();

        $rechaptcha->update($data);

        $notify[] = ['success', "Recaptcha Updated Successfully"];

        return redirect()->back()->withNotify($notify);
        
    }

    public function liveChat()
    {
        $pageTitle = 'Twak To Live Chat Setting';

        $twakto = GeneralSetting::first();

        return view('admin.setting.twakto',compact('pageTitle','twakto'));
    }

    public function liveChatUpdate(Request $request)
    {
        $data = $request->validate([
            'twak_allow' => 'required',
            'twak_key' => 'required'
        ]);

        $twak = GeneralSetting::first();

        $twak->update($data);

        $notify[] = ['success', "Twak Updated Successfully"];

        return redirect()->back()->withNotify($notify);
        
    }

    public function seoManage()
    {
        $pageTitle = 'Manage SEO';

        $seo = GeneralSetting::first();

        return view('admin.setting.seo',compact('pageTitle','seo'));
    }

    public function seoManageUpdate(Request $request)
    {
        
        $general = GeneralSetting::first();

        $data = $request->validate([
            'seo_description' => 'required',
        ]);


        $general->update($data);


        $notify[] = ['success', "Seo Updated Successfully"];

        return redirect()->back()->withNotify($notify);

    }

}
