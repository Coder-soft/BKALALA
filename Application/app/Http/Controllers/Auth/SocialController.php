<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use File;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    // Redirect to provider
    public function redirectToProvider($provider)
    {
        if ($provider == 'facebook') {
            if (env('FACEBOOK_CLIENT_ID') == null) {
                echo "Please adjust Facebook login settings from the admin panel";
            } else {
                return Socialite::driver($provider)->redirect();
            }
        } else {
            return redirect('/');
        }
    }

    // Handle provider callback
    public function handleProviderCallback($provider)
    {

        if ($provider == 'facebook') {

            $user = Socialite::driver($provider)->user();

            try {
                $finduser = User::where('facebook_id', $user->id)->first();
                if ($finduser) {
                    if ($finduser->status != 2) {
                        Auth::login($finduser);
                        return redirect('/#success');
                    } else {
                        session()->flash('error', 'You account is blocked please contact us for more information');
                        return redirect('/login/#error');
                    }
                } else {
                    $findemail = User::where('email', $user->email)->first();
                    if ($findemail) {
                        $update = User::where('email', $user->email)
                            ->update(['facebook_id' => $user->id]);
                        if ($findemail->status != 2) {
                            if ($update) {
                                Auth::login($findemail);
                                return redirect('/user/dashboard/#success');
                            }
                        } else {
                            session()->flash('error', 'You account is blocked please contact us for more information');
                            return redirect('/login/#error');
                        }
                    } else {
                        $fileContents = file_get_contents($user->avatar);
                        $string = Str::random(50);
                        File::put('path/cdn/avatars/' . $string . ".jpg", $fileContents);
                        $avatar = $string . ".jpg";
                        $newUser = User::create([
                            'name' => $user['name'],
                            'email' => $user->email,
                            'avatar' => $avatar,
                            'facebook_id' => $user->id,
                        ]);
                        if ($newUser) {
                            Auth::login($newUser);
                            return redirect('/user/dashboard/#success');
                        }
                    }
                }

            } catch (Exception $e) {
                dd($e->getMessage());
            }

        } else {
            abort(404);
        }

    }

}
