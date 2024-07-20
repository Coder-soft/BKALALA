<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    // View ads page
    public function index()
    {
        // Get ads data
        $ads = DB::table('ads')->find(1);
        return view('admin.ads', ['ads' => $ads]);
    }

    // Update ads
    public function adsStore(Request $request)
    {
        // Find Ads table
        $Ads = DB::table('ads')->find(1);

        // If Ads table null create it
        if ($Ads == null) {
            // Create Ads table with id = 1
            $createAdsTable = DB::table('ads')->insert(['id' => 1]);
        }

        // Update Ads
        $updateAds = DB::table('ads')->where('id', 1)->update([
            'home_ads_top' => $request['home_ads_top'],
            'home_ads_bottom' => $request['home_ads_bottom'],
            'mobile_ads' => $request['mobile_ads'],
            'user_account_ads' => $request['user_account_ads'],
            'download_top_ads' => $request['download_top_ads'],
            'download_left_top_ads' => $request['download_left_top_ads'],
            'download_left_bottom_ads' => $request['download_left_bottom_ads'],
        ]);

        // if update
        if ($updateAds) {
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
