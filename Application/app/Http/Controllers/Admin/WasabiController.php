<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;

class WasabiController extends Controller
{
    // View wasabi page
    public function index()
    {
        // Get S3 data
        $wasabi = DB::table('wasabi')->find(1);
        return view('admin.wasabi', ['wasabi' => $wasabi]);
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

    // Update wasabi details
    public function wasabiStore(Request $request)
    {
        // get settings info
        $settings = Setting::find(1);
        if ($settings->storage == 3) {
            // Error response
            return response()->json([
                'error' => ['You are using wasabi s3 as storage please change it on settings then you can update it'],
            ]);
        }

        // Find wasabi table
        $wasabi = DB::table('wasabi')->find(1);

        // If wasabi table null create it
        if ($wasabi == null) {
            // Create api table with id = 1
            $createwasabiTable = DB::table('wasabi')->insert(['id' => 1]);
        }

        if (env('AWS_ACCESS_KEY_ID') != null
            && env('AWS_SECRET_ACCESS_KEY') != null
            && env('AWS_DEFAULT_REGION') != null
            && env('AWS_BUCKET') != null
            && env('AWS_URL') != null) {
            // Error response
            return response()->json([
                'error' => ['You Cannot use wasabi with amazon at the same time please remove amazon information to avoid problems'],
            ]);
        }

        // Update wasabi
        $updatewasabi = DB::table('wasabi')->where('id', 1)->update([
            'wasabi_access_key_id' => $request['wasabi_access_key_id'],
            'wasabi_secret_access_key' => $request['wasabi_secret_access_key'],
            'wasabi_default_region' => $request['wasabi_default_region'],
            'wasabi_bucket' => $request['wasabi_bucket'],
            'wasabi_root' => $request['wasabi_root'],
        ]);

        // if update
        if ($updatewasabi) {
            // Set on env file
            $this->setEnv('WASABI_ACCESS_KEY_ID', $request['wasabi_access_key_id']);
            $this->setEnv('WASABI_SECRET_ACCESS_KEY', $request['wasabi_secret_access_key']);
            $this->setEnv('WASABI_DEFAULT_REGION', $request['wasabi_default_region']);
            $this->setEnv('WASABI_BUCKET', $request['wasabi_bucket']);
            $this->setEnv('WASABI_ROOT', $request['wasabi_root']);
            // Set Aws
            $this->setEnv('AWS_ACCESS_KEY_ID', $request['wasabi_access_key_id']);
            $this->setEnv('AWS_SECRET_ACCESS_KEY', $request['wasabi_secret_access_key']);
            $this->setEnv('AWS_DEFAULT_REGION', $request['wasabi_default_region']);
            $this->setEnv('AWS_BUCKET', $request['wasabi_bucket']);
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
