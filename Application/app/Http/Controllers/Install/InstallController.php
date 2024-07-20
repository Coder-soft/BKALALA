<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{

    // Set Env function
    private function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)));
        }
    }

    public function index()
    {
        // view step 1
        return redirect('/install/step1');
    }

    // View step 1 page
    public function step1()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 1) {
            return redirect()->route('install/step2');
        }

        return view('install.step1');
    }

    // Step 1 Set database information
    public function set_database(Request $request)
    {

        $validate = $request->validate([
            'database_name' => ['required'],
            'database_user_name' => ['required'],
            'database_host_name' => ['required'],
        ]);

        if (function_exists('curl_version')) {
            if (is_writable(base_path('.env'))) {

                if (@mysqli_connect(
                    $request['database_host_name'],
                    $request['database_user_name'],
                    $request['database_password'],
                    $request['database_name']
                )) {

                    $this->setEnv('DB_DATABASE', $request['database_name']);
                    $this->setEnv('DB_USERNAME', $request['database_user_name']);
                    $this->setEnv('DB_PASSWORD', $request['database_password']);
                    $this->setEnv('DB_HOST', $request['database_host_name']);
                    $this->setEnv('DB_INSTALLED', 1);
                    return redirect('/install/step2');
                } else {

                    $request->session()->flash('error', 'Incorrect database information');
                    return redirect()->back();

                }

            } else {

                $request->session()->flash('error', 'Some of your file does not have writable permission');
                return redirect()->back();
            }

        } else {

            $request->session()->flash('error', 'CURL does not exist in server');
            return redirect()->back();
        }

    }

    // View step 2 page
    public function step2()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 1) {
            return redirect()->route('install/step3');
        }

        return view('install.step2');
    }

    // Step 2 Import database file
    public function import_database()
    {

        $sql_path = base_path('database/data.sql');
        $do = DB::unprepared(file_get_contents($sql_path));

        if ($do) {
            $this->setEnv('DB_IMPORTED', 1);
            return redirect('/install/step3');
        }

    }

    // View step 3 page
    public function step3()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 0) {
            return redirect()->route('install/step2');
        }
        if (env('INFO_INSTALLED') == 1) {
            return redirect()->route('install/step4');
        }

        return view('install.step3');
    }

    // Step 3 Update site name & set asset URL
    public function set_siteinfo(Request $request)
    {

        $validate = $request->validate([
            'site_name' => ['required', 'string'],
            'site_url' => ['required'],
        ]);

        $update = Setting::where('id', 1)->update(['site_name' => $request['site_name']]);

        if ($update) {
            $this->setEnv('INFO_INSTALLED', 1);
            $this->setEnv('APP_URL', $request['site_url']);
            return redirect('/install/step4');

        } else {

            $request->session()->flash('error', 'Cannot find settings id');
            return redirect()->back();
        }

    }

    // View step 4 page
    public function step4()
    {

        if (env('SYSTEM_INSTALLED') == 1) {
            return redirect()->route('dashboard');
        }
        if (env('DB_INSTALLED') == 0) {
            return redirect()->route('install/step1');
        }
        if (env('DB_IMPORTED') == 0) {
            return redirect()->route('install/step2');
        }
        if (env('INFO_INSTALLED') == 0) {
            return redirect()->route('install/step3');
        }

        return view('install.step4');
    }

    // Step 4 Set admin information
    public function set_admininfo(Request $request)
    {

        $validate = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $permission = 1;
        $avatar = "default.png";

        $register = User::create([
            'name' => 'Admin',
            'email' => $request['email'],
            'avatar' => $avatar,
            'password' => Hash::make($request['password']),
            'permission' => $permission,
        ]);

        if ($register) {

            $this->setEnv('SYSTEM_INSTALLED', 1);
            $this->setEnv('ADMIN_INSTALLED', 1);
            Auth::login($register);
            return redirect('admin/dashboard');
        }
    }

}
