<?php

namespace App\Http\Controllers\Pages\User;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // view user dashboard
    public function index()
    {
        $authId = Auth::user()->id; // user id
        // get user uploads using id
        $uploads = Upload::where('user_id', $authId)->limit(10)->orderbyDesc('id')->get();
        return view('pages.user.dashboard', ['uploads' => $uploads]);
    }

    // Charts get all days
    public function getAllDays()
    {
        $authId = Auth::user()->id; // user id
        $day_array = array();
        $uploads_dates = Upload::where('user_id', $authId)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'ASC')->pluck('created_at');
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

    // get daily count uploads
    public function getDailyUploadCount($day)
    {
        $authId = Auth::user()->id;
        $daily_upload_count = Upload::where('user_id', $authId)->whereDate('created_at', $day)->get()->count();
        return $daily_upload_count;
    }

    // get daily uploads data
    public function getDailyUploadData()
    {
        $daily_upload_count_array = array();
        $day_array = $this->getAllDays();
        $day_name_array = array();
        if (!empty($day_array)) {
            foreach ($day_array as $day_no => $day_name) {
                $daily_upload_count = $this->getDailyUploadCount($day_no);
                array_push($daily_upload_count_array, $daily_upload_count);
                array_push($day_name_array, $day_name);
            }
        }
        $max_no = max($daily_upload_count_array);
        $daily_upload_data_array = array(
            'days' => $day_name_array,
            'upload_count_data' => $daily_upload_count_array,
        );
        return $daily_upload_data_array;

    }
}
