<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;

class AmazonS3Controller extends Controller
{
    // View amazon page
    public function index()
    {
        // Get S3 data
        $amazonS3 = DB::table('amazons3')->find(1);
        return view('admin.amazon', ['amazonS3' => $amazonS3]);
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

    // Update amazon details
    public function amazons3Store(Request $request)
    {
        // get settings info
        $settings = Setting::find(1);
        if ($settings->storage == 2) {
            // Error response
            return response()->json([
                'error' => ['You are using amazon s3 as storage please change it on settings then you can update it'],
            ]);
        }

        // Find amazons3 table
        $amazonS3 = DB::table('amazons3')->find(1);

        // If amazons3 table null create it
        if ($amazonS3 == null) {
            // Create api table with id = 1
            $createAmazonS3Table = DB::table('amazons3')->insert(['id' => 1]);
        }

        if (env('WASABI_ACCESS_KEY_ID') != null
            && env('WASABI_SECRET_ACCESS_KEY') != null
            && env('WASABI_DEFAULT_REGION') != null
            && env('WASABI_BUCKET') != null
            && env('WASABI_ROOT') != null) {
            // Error response
            return response()->json([
                'error' => ['You Cannot use amazon with wasabi at the same time please remove wasabi information to avoid problems'],
            ]);
        }

        // Update amazons3
        $updateAmazonS3 = DB::table('amazons3')->where('id', 1)->update([
            'aws_access_key_id' => $request['aws_access_key_id'],
            'aws_secret_access_key' => $request['aws_secret_access_key'],
            'aws_default_region' => $request['aws_default_region'],
            'aws_bucket' => $request['aws_bucket'],
            'aws_url' => $request['aws_url'],
        ]);

        // if update
        if ($updateAmazonS3) {
            // Set on env file
            $this->setEnv('AWS_ACCESS_KEY_ID', $request['aws_access_key_id']);
            $this->setEnv('AWS_SECRET_ACCESS_KEY', $request['aws_secret_access_key']);
            $this->setEnv('AWS_DEFAULT_REGION', $request['aws_default_region']);
            $this->setEnv('AWS_BUCKET', $request['aws_bucket']);
            $this->setEnv('AWS_URL', $request['aws_url']);
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
