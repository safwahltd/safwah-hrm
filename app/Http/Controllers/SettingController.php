<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Exception;

class SettingController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin settings index')){
            $companySetting = Setting::first();
            return view('admin.settings.index',compact('companySetting'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function companySettingUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin company setting update')){
            try {
                $setting = Setting::find($id);
                $setting->company_name = $request->company_name;
                $setting->company_title = $request->company_title;
                $setting->phone = $request->phone;
                $setting->hotLine = $request->hotLine;
                $setting->email = $request->email;
                $setting->address = $request->address;
                if ($request->file('logo')){
                    if (isset($setting->logo)){
                        unlink($setting->logo);
                    }
                    $logo = $request->file('logo');
                    $logoExtension = $logo->getClientOriginalExtension();
                    $logoName = time().'.'.$logoExtension;
                    $directory = 'upload/company-setting/';
                    $logo->move($directory,$logoName);
                    $logoUrl = $directory.$logoName;
                    $setting->logo = $logoUrl;
                }
                if ($request->file('favicon')){
                    if (isset($setting->favicon)){
                        unlink($setting->favicon);
                    }
                    $favicon = $request->file('favicon');
                    $faviconExtension = $favicon->getClientOriginalExtension();
                    $faviconName = time().'.'.$faviconExtension;
                    $directory = 'upload/company-setting/';
                    $favicon->move($directory,$faviconName);
                    $faviconUrl = $directory.$faviconName;
                    $setting->favicon = $faviconUrl;
                }
                $setting->website_link = $request->website_link;
                $setting->app_link = $request->app_link;
                $setting->ios_link = $request->ios_link;
                $setting->meta_title = $request->meta_title;
                $setting->meta_keyword = $request->meta_keyword;
                $setting->meta_description = $request->meta_description;
                $setting->meta_author = $request->meta_author;
                $setting->save();
                toastr()->success('update success.');
                return back();
            }
            catch (Exception $exception){
                toastr()->error($exception->getMessage());
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    /*public function emailSetting(){
        $emailSetting = Setting::first();
        return view('admin.settings.email',compact('emailSetting'));
    }
    public function emailSettingUpdate(Request $request,$id){
        try {
            $setting = Setting::find($id);
            $setting->sender_name = $request->sender_name;
            $setting->sender_email = $request->sender_email;
            $setting->mail_mailer = $request->mail_mailer;
            $setting->mail_host = $request->mail_host;
            $setting->mail_port = $request->mail_port;
            $setting->mail_encryption = $request->mail_encryption;
            $setting->mail_username = $request->mail_username;
            $setting->mail_password = $request->mail_password;
            $setting->save();

            // Set dynamic email configurations
            Config::set('mail.mailers.smtp.mailer', $setting->mail_mailer);
            Config::set('mail.mailers.smtp.host', $setting->mail_host);
            Config::set('mail.mailers.smtp.port', $setting->mail_port);
            Config::set('mail.mailers.smtp.username', $setting->mail_username);
            Config::set('mail.mailers.smtp.password', $setting->mail_password);
            Config::set('mail.mailers.smtp.encryption', $setting->mail_encryption);
            Config::set('mail.from.address', $setting->sender_email);
            Config::set('mail.from.name', $setting->sender_name);

            toastr()->success('update success.');
            return back();
        }
        catch (Exception $exception){
            toastr()->error($exception->getMessage());
        }
    }*/
}
