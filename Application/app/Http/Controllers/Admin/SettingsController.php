<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    // View settings page
    public function index()
    {
        // Get settings data
        $settings = Setting::find(1);
        // Get api data
        $api = DB::table('api')->find(1);
        // Get seo data
        $seo = DB::table('seo')->find(1);
        return view('admin.settings', ['settings' => $settings, 'api' => $api, 'seo' => $seo]);
    }

    // Set Env function
    private function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)));
        }
    }

    // Update information
    public function UpdateInfo(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'site_name' => ['required', 'string', 'max:100'],
            'site_analytics' => ['max:100'],
            'home_heading' => ['required', 'string', 'max:100'],
            'home_descritption' => ['required', 'string', 'max:255'],
            'max_filesize' => ['required', 'string', 'max:50'],
            'onetime_uploads' => ['required', 'string', 'max:50'],
        ]);

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // Check maxfile size and onetime uploads if not -0
        if ($request['max_filesize'] < 1) {
            // Error response
            return response()->json([
                'error' => ['Enter valid max file size'],
            ]);
        } elseif ($request['onetime_uploads'] < 1) {
            // Error response
            return response()->json([
                'error' => ['Enter valid one time uploads'],
            ]);
        }

        // Find settings table
        $settings = Setting::find(1);

        // If settings table null create it
        if ($settings == null) {
            // Create settings table with id = 1
            $createSettingsTable = Setting::create(['id' => 1]);
        }

        // Check storage request
        if ($request['storage'] != 1 && $request['storage'] != 2 && $request['storage'] != 3 && $request['storage'] != 4) {
            // Error response
            return response()->json([
                'error' => ['Please refresh page and try again'],
            ]);
        }

        // check if amazon or wasabi information is null
        if ($request['storage'] == 2) {
            if (env('AWS_ACCESS_KEY_ID') == null or
                env('AWS_SECRET_ACCESS_KEY') == null or
                env('AWS_DEFAULT_REGION') == null or
                env('AWS_BUCKET') == null or
                env('AWS_URL') == null) {
                // Error response
                return response()->json([
                    'error' => ['Error! Please check the amazon s3 information'],
                ]);
            }
        } elseif ($request['storage'] == 3) {
            if (env('WASABI_ACCESS_KEY_ID') == null or
                env('WASABI_SECRET_ACCESS_KEY') == null or
                env('WASABI_DEFAULT_REGION') == null or
                env('WASABI_BUCKET') == null) {
                // Error response
                return response()->json([
                    'error' => ['Error! Please check the wasabi s3 information'],
                ]);
            }
        } elseif ($request['storage'] == 4) {
            if (env('B2_BUCKET') == null or
                env('B2_ACCOUNTID') == null or
                env('B2_APPLICATIONKEY') == null or
                env('B2_URL') == null) {
                // Error response { {
                return response()->json([
                    'error' => ['Error! Please check the backblaze information'],
                ]);
            }

        }

        // Update information
        $updateSettings = Setting::where('id', 1)->update([
            'site_name' => $request['site_name'],
            'site_analytics' => $request['site_analytics'],
            'home_heading' => $request['home_heading'],
            'home_descritption' => $request['home_descritption'],
            'storage' => $request['storage'],
            'max_filesize' => $request['max_filesize'],
            'onetime_uploads' => $request['onetime_uploads'],
        ]);
        // If update
        if ($updateSettings) {
            // Success response
            return response()->json([
                'success' => 'Website information updated successfully',
            ]);
        } else {
            // Error response
            return response()->json([
                'error' => ['Please refresh page and try again'],
            ]);
        }
    }

// Update logo and favicon
    public function UpdateLogoAndFavicon(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'logo' => ['max:2048', 'mimes:png,jpg,jpeg,svg'],
            'favicon' => ['max:2048', 'mimes:ico,png,jpg,jpeg'],
        ]);

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // Find settings table
        $settings = Setting::find(1);

        // If settings table null create it
        if ($settings == null) {
            // Create settings table with id = 1
            $createSettingsTable = Setting::create(['id' => 1]);
        }

        // if request logo is not null
        if ($request['logo'] != null) {
            // if favicon is not null
            if ($request['favicon'] != null) {
                // Get current logo and favicon
                $logo = $settings->logo;
                $favicon = $settings->favicon;
                // Check if file exist
                if (file_exists('images/main/' . $logo)) {
                    // delete old logo
                    $deleteOldLogo = File::delete('images/main/' . $logo);
                }
                if (file_exists('images/main/' . $favicon)) {
                    // delete old favicon
                    $deleteOldFavicon = File::delete('images/main/' . $favicon);
                }
                // Lets update New logo and new favicon
                $logo_name = 'logo.' . $request->logo->getclientoriginalextension();
                $fav_name = 'favicon.' . $request->favicon->getclientoriginalextension();
                $request->logo->move('images/main/', $logo_name);
                $request->favicon->move('images/main/', $fav_name);
                // Update logo & favicon
                $update = Setting::where('id', 1)->update(['logo' => $logo_name, 'favicon' => $fav_name]);
            } else {
                // Get current logo
                $logo = $settings->logo;
                // Check if file exist
                if (file_exists('images/main/' . $logo)) {
                    // delete old logo
                    $deleteOldLogo = File::delete('images/main/' . $logo);
                }
                // Lets update New logo
                $logo_name = 'logo.' . $request->logo->getclientoriginalextension();
                $request->logo->move('images/main/', $logo_name);
                // Update logo
                $update = Setting::where('id', 1)->update(['logo' => $logo_name]);
            }
        } else {
            // check if favicon is not null
            if ($request['favicon'] != null) {
                // Get current  favicon
                $favicon = $settings->favicon;
                // Check if file exist
                if (file_exists('images/main/' . $favicon)) {
                    // delete old favicon
                    $deleteOldFavicon = File::delete('images/main/' . $favicon);
                }
                // Lets update New favicon
                $fav_name = 'favicon.' . $request->favicon->getclientoriginalextension();
                $request->favicon->move('images/main/', $fav_name);
                // Update favicon
                $update = Setting::where('id', 1)->update(['favicon' => $fav_name]);
            } else {
                // Back with error
                return response()->json(['error' => ['You must upload new logo or favicon']]);
            }
        }

        // Success response
        return response()->json(['success' => 'Updated Successfully']);
    }

    public function UpdateApi(Request $request)
    {
        // Find api table
        $api = DB::table('api')->find(1);

        // If api table null create it
        if ($api == null) {
            // Create api table with id = 1
            $createApiTable = DB::table('api')->insert(['id' => 1]);
        }

        // Update api
        $updateApi = DB::table('api')->where('id', 1)->update([
            'google_key' => $request['google_key'],
            'google_secret' => $request['google_secret'],
            'facebook_clientid' => $request['facebook_clientid'],
            'facebook_clientsecret' => $request['facebook_clientsecret'],
            'facebook_reurl' => $request['facebook_reurl'],
        ]);

        // if update
        if ($updateApi) {
            // Set on env file
            $this->setEnv('NOCAPTCHA_SITEKEY', $request['google_key']);
            $this->setEnv('NOCAPTCHA_SECRET', $request['google_secret']);
            $this->setEnv('FACEBOOK_CLIENT_ID', $request['facebook_clientid']);
            $this->setEnv('FACEBOOK_CLIENT_SECRET', $request['facebook_clientsecret']);
            $this->setEnv('FACEBOOK_REDIRECT_URL', $request['facebook_reurl']);
            // Success response
            return response()->json([
                'success' => 'Updated Successfully',
            ]);
        } else {
            // Error response
            return response()->json([
                'error' => ['Nothing changed on the form'],
            ]);
        }
    }

    public function UpdateSeo(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'seo_title' => ['required', 'string', 'max:100'],
            'seo_description' => ['max:300'],
            'seo_keywords' => ['max:250'],
        ]);

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // Find seo table
        $seo = DB::table('seo')->find(1);

        // If seo table null create it
        if ($seo == null) {
            // Create seo table with id = 1
            $createSeoTable = DB::table('seo')->insert(['id' => 1]);
        }

        // Update seo
        $updateSeo = DB::table('seo')->where('id', 1)->update([
            'seo_title' => $request['seo_title'],
            'seo_description' => $request['seo_description'],
            'seo_keywords' => $request['seo_keywords'],
        ]);

        if ($updateSeo) {
            // Success response
            return response()->json([
                'success' => 'Updated Successfully',
            ]);
        } else {
            // Error response
            return response()->json([
                'error' => ['Nothing changed on the form'],
            ]);
        }

    }
}
