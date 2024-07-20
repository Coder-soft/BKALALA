<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;

class UploadsController extends Controller
{

    // View uploadss
    public function index(Request $request)
    {
        // on search
        if ($request->input('q')) {
            $q = $request->input('q');
            $uploads = Upload::where('main_filename', 'LIKE', '%' . $q . '%')
                ->orWhere('file_id', 'like', '%' . $q . '%')
                ->orWhere('id', 'like', '%' . $q . '%')
                ->orderbyDesc('id')
                ->get();
        } else {
            // uploads data
            $uploads = Upload::orderbyDesc('id')->with('user')->paginate(15);
        }

        return view('admin.uploads', ['uploads' => $uploads]);
    }

    // Delete file
    public function deleteAdminFile($id)
    {
        // get file data
        $file = Upload::where('id', $id)->first();
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
            $delete = Upload::where('id', $id)->delete();
            if ($delete) {
                // success response
                return response()->json(['success' => 'File deleted successfully']);
            }
        } else {
            // error response
            return response()->json(['error' => 'Please refresh page and try agian']);
        }
    }

    // View file
    public function viewFile($id)
    {
        // Get file data
        $upload = Upload::where('id', $id)->with('user')->first();
        // if data not null
        if ($upload != null) {
            // Retrun to view with file data
            return view('admin.view.upload', ['upload' => $upload]);
        } else {
            // Abort 404 if data is null
            abort(404);
        }

    }
}
