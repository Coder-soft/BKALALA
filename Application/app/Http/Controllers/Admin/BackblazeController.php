<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use DB;
use Illuminate\Http\Request;

class BackblazeController extends Controller
{

    // View backblaze page
    public function index()
    {
        // Get backblaze data
        $backblaze = DB::table('backblaze')->find(1);
        return view('admin.backblaze', ['backblaze' => $backblaze]);
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

    // Update backblaze details
    public function backblazeStore(Request $request)
    {
        // get settings info
        $settings = Setting::find(1);
        if ($settings->storage == 4) {
            // Error response
            return response()->json([
                'error' => ['You are using backblaze as storage please change it on settings then you can update it'],
            ]);
        }

        // Find backblaze table
        $backblaze = DB::table('backblaze')->find(1);

        // If backblaze table null create it
        if ($backblaze == null) {
            // Create backblaze table with id = 1
            $createBackblazeTable = DB::table('backblaze')->insert(['id' => 1]);
        }

        // Update backblaze
        $updateBackblaze = DB::table('backblaze')->where('id', 1)->update([
            'b2_bucket' => $request['b2_bucket'],
            'b2_account_id' => $request['b2_account_id'],
            'b2_application_key' => $request['b2_application_key'],
            'b2_url' => $request['b2_url'],
        ]);

        // if update
        if ($updateBackblaze) {
            // Set on env file
            $this->setEnv('B2_BUCKET', $request['b2_bucket']);
            $this->setEnv('B2_ACCOUNTID', $request['b2_account_id']);
            $this->setEnv('B2_APPLICATIONKEY', $request['b2_application_key']);
            $this->setEnv('B2_URL', $request['b2_url']);
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
