<?php

namespace App\Http\Controllers\Pages\User;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;

class FilesController extends Controller
{
    // View user files
    public function index(Request $request)
    {
        $authId = Auth::user()->id; // user id
        // on search
        if ($request->input('q')) {
            $q = $request->input('q');
            $uploads = Upload::where([['user_id', $authId], ['main_filename', 'LIKE', '%' . $q . '%']])
                ->orWhere([['user_id', $authId], ['file_id', 'like', '%' . $q . '%']])
                ->orWhere([['user_id', $authId], ['id', 'like', '%' . $q . '%']])
                ->orderbyDesc('id')
                ->get();
        } else {
            // user uploads data
            $uploads = Upload::where('user_id', $authId)->with('user')->orderbyDesc('id')->paginate(12);
        }

        return view('pages.user.files', ['uploads' => $uploads]);
    }

    // delete file
    public function deleteFile($id)
    {
        $authID = Auth::user()->id;
        // get file data
        $file = Upload::where([['user_id', $authID], ['id', $id]])->first();
        // if data not null
        if ($file != null) {
            // if storage is local server
            if ($file->method == 1) {
                $theFile = str_replace(url('/') . '/', '', $file->file_path);
                if (file_exists($theFile)) {
                    $delete = File::delete($theFile);
                }
            } elseif ($file->method == 2) {
                $fileS3 = pathinfo(storage_path() . $file->file_path, PATHINFO_EXTENSION); // file ext
                $awsFile = $file->file_id . '.' . $fileS3; // file name
                if (Storage::disk('s3')->has($awsFile)) {
                    // Delete file from amazon s3
                    $delete = Storage::disk('s3')->delete($awsFile);
                }
            } elseif ($file->method == 3) {
                $fileS3 = pathinfo(storage_path() . $file->file_path, PATHINFO_EXTENSION); // file ext
                $awsFile = $file->file_id . '.' . $fileS3; // file name
                if (Storage::disk('wasabi')->has($awsFile)) {
                    // Delete file from wasabi s3
                    $delete = Storage::disk('wasabi')->delete($awsFile);
                }
            } elseif ($file->method == 4) {
                $fileS3 = pathinfo(storage_path() . $file->file_path, PATHINFO_EXTENSION); // file ext
                $awsFile = $file->file_id . '.' . $fileS3; // file name
                if (Storage::disk('b2')->has($awsFile)) {
                    // Delete file from backblaze
                    $delete = Storage::disk('b2')->delete($awsFile);
                }

            } else {
                // error response
                return response()->json(['error' => 'Unknown error']);
            }

            // Delete from database
            $delete = Upload::where([['user_id', $authID], ['id', $id]])->delete();
            if ($delete) {
                // success response
                return response()->json(['success' => 'File deleted successfully']);
            }
        } else {
            // error response
            return response()->json(['error' => 'Please refresh page and try agian']);
        }
    }

}
