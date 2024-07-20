<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Page;
use App\Models\Upload;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // View admin dashboard
    public function index()
    {
        // Count uploads
        $countUploads = Upload::all()->count();
        // Count messages
        $countMessages = Message::all()->count();
        // Count users
        $countUsers = User::where('permission', 2)->count();
        // Count pages
        $countPages = Page::all()->count();
        // Get last registerd users
        $lastUsers = User::where('permission', 2)->limit(4)->orderbyDesc('id')->get();
        return view('admin.dashboard', [
            'countUploads' => $countUploads,
            'countUsers' => $countUsers,
            'countMessages' => $countMessages,
            'lastUsers' => $lastUsers,
            'countPages' => $countPages,
        ]);
    }

    // Get all upload days
    public function getAllDays()
    {
        $day_array = array();
        $uploads_dates = Upload::orderBy('created_at', 'ASC')->whereMonth('created_at', Carbon::now()->month)->pluck('created_at');
        $uploads_dates = json_decode($uploads_dates);
        if (!empty($uploads_dates)) {
            foreach ($uploads_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $day_no = $date->format('Y-m-d');
                $day_name = $date->format('Y-m-d');
                $day_array[$day_no] = $day_name;
            }
        }
        return $day_array;
    }

    // Count daily uploads
    public function getDailyUploadsCount($day)
    {
        $daily_upload_count = Upload::whereDate('created_at', $day)->get()->count();
        return $daily_upload_count;
    }

    // Get uploads data
    public function getDailyUploadsData()
    {
        $daily_upload_count_array = array();
        $day_array = $this->getAllDays();
        $day_name_array = array();
        if (!empty($day_array)) {
            foreach ($day_array as $day_no => $day_name) {
                $daily_upload_count = $this->getDailyUploadsCount($day_no);
                array_push($daily_upload_count_array, $daily_upload_count);
                array_push($day_name_array, $day_name);
            }
        }
        $max_no = max($daily_upload_count_array);
        $daily_upload_data_array = array('days' => $day_name_array, 'upload_count_data' => $daily_upload_count_array);
        return $daily_upload_data_array;
    }

    // Charts get users days
    public function getAllUsersDays()
    {
        $day_array = array();
        $users_dates = User::where('permission', 2)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'ASC')->pluck('created_at');
        $users_dates = json_decode($users_dates);
        if (!empty($users_dates)) {
            foreach ($users_dates as $unformatted_date) {
                $date = new \DateTime($unformatted_date);
                $day_no = $date->format('d');
                $day_name = $date->format('D');
                $day_array[$day_no] = $day_name;
            }
        }
        return $day_array;
    }

    // Get daily users count
    public function getDailyUsersCount($day)
    {
        $daily_user_count = User::where('permission', 2)->whereDay('created_at', $day)->get()->count();
        return $daily_user_count;
    }

    // Get daily users data
    public function getDailyUsersData()
    {
        $daily_user_count_array = array();
        $day_array = $this->getAllUsersDays();
        $day_name_array = array();
        if (!empty($day_array)) {
            foreach ($day_array as $day_no => $day_name) {
                $daily_user_count = $this->getDailyUsersCount($day_no);
                array_push($daily_user_count_array, $daily_user_count);
                array_push($day_name_array, $day_name);
            }
        }
        $max_no = max($daily_user_count_array);
        $max = round(($max_no + 10 / 2) / 10) * 10;
        $daily_user_data_array = array(
            'days' => $day_name_array,
            'users_count_data' => $daily_user_count_array,
        );
        return $daily_user_data_array;
    }

    // Redirect to admin dashboard
    public function RedirectToDashboard()
    {
        return redirect('/admin/dashboard');
    }

}
