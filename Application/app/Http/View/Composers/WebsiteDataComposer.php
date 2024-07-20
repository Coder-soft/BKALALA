<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use DB;
use Illuminate\View\View;

class WebsiteDataComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */

    // Get website data
    public function compose(View $view)
    {
        // Get website settings
        $settings = Setting::find(1);
        // Get seo settings
        $seo = DB::table('seo')->find(1);
        // get ads data
        $ads = DB::table('ads')->find(1);
        $view->with(['settings' => $settings, 'seo' => $seo, 'ads' => $ads]);
    }
}
