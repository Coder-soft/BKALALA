<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Upload;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Storage;

class UploadController extends Controller
{
    // Upload images
    public function Upload(Request $request)
    {
        // Settings information
        $settings = Setting::find(1);
        try {
            // Accept files
            $types = "jpeg,png,jpg,gif,pdf,doc,docx,xlx,xlsx,csv,txt,mp4,m4v,wmv,mp3,m4a,wav,apk,zip,rar";
            // validate uploads
            $validator = \Validator::make($request->all(), [
                'uploads' => ['max:' . $settings->max_filesize . '000', 'mimes:' . $types],
            ]);
            // if validate fails
            if ($validator->fails()) {
                // errors array
                $response = array(
                    'type' => 'error',
                    'errors' => $validator->errors()->all(),
                );
                // error response
                return response()->json($response);
            } else {
                // request has file
                if ($request->hasFile('uploads')) {
                    // Original file
                    $main_file = $request->file('uploads');
                    // Main file name
                    $mainFileName = $main_file->getClientOriginalName();
                    // get fie size
                    $fileSize = $main_file->getSize();
                    // give file new name
                    $string = Str::random(15);
                    // file type
                    $fileType = $main_file->getclientoriginalextension();
                    // types array
                    $types_arr = array('jpeg', 'png', 'jpg', 'gif', 'pdf', 'doc', 'docx', 'xlx', 'xlsx', 'csv', 'txt', 'mp4', 'm4v', 'wmv', 'mp3', 'm4a', 'wav', 'apk', 'zip', 'rar');
                    // check if file type is supported
                    if (!in_array(strtolower($fileType), $types_arr)) {
                        // error response
                        return response()->json(array(
                            'type' => 'error',
                            'errors' => 'File type not supported.',
                        ));
                    }
                    // new file name
                    $uploadName = $string . '.' . $fileType;
                    // check if amazon s3 enabled
                    if ($settings->storage == 2) {
                        // Storage file to amazon S3
                        $upload = Storage::disk('s3')->put($uploadName, fopen($main_file, 'r+'), 'public');
                        // file name
                        $filename = Storage::disk('s3')->url($uploadName);
                        // method
                        $method = 2;
                    } elseif ($settings->storage == 3) { // if wasabi is enabled
                        // Storage file to wasabi
                        $upload = Storage::disk('wasabi')->put($uploadName, fopen($main_file, 'r+'), 'public');
                        // file name
                        $filename = Storage::disk('wasabi')->url($uploadName);
                        // method
                        $method = 3;
                    } elseif ($settings->storage == 4) { // if backblaze is enabled
                        // Storage file to backblaze
                        $upload = Storage::disk('b2')->put($uploadName, fopen($main_file, 'r+'), 'public');
                        // file name
                        $filename = env('B2_URL') . '/' . $uploadName;
                        // method
                        $method = 4;
                    } else {
                        // upload path
                        $path = 'filebob/uploads/storage/';
                        // if path not exists create it
                        if (!File::exists($path)) {
                            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                        }
                        // move file to path
                        $upload = $request->file('uploads')->move($path, $uploadName);
                        // file name
                        $filename = url($path) . '/' . $uploadName;
                        // method server host
                        $method = 1;
                    }
                    // if image uploded
                    if ($upload) {
                        // if user auth get user id
                        if (Auth::user()) {
                            $userID = Auth::user()->id;
                        } else {
                            $userID = null;
                        }
                        // create new image data
                        $data = Upload::create([
                            'user_id' => $userID,
                            'main_filename' => $mainFileName,
                            'file_id' => $string,
                            'file_path' => $filename,
                            'file_type' => strtolower($fileType),
                            'file_size' => $fileSize,
                            'method' => $method,
                        ]);
                        // if image data created
                        if ($data) {
                            // success array
                            $response = array(
                                'type' => 'success',
                                'msg' => 'success',
                                'data' => array('id' => $string),
                            );
                            // success response
                            return response()->json($response);
                        }
                    } else {
                        // error response
                        return response()->json(array(
                            'type' => 'error',
                            'errors' => 'Upload error.',
                        ));
                    }
                } else {
                    // error response
                    return response()->json(array(
                        'type' => 'error',
                        'errors' => 'Illegal Request.',
                    ));
                }
            }
        } catch (\Exception$e) {
            // error response
            return response()->json(array(
                'type' => 'error',
                'errors' => 'Server error please refresh page and try again.',
            ));
        }
    }
}
