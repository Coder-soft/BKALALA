<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Storage;

class DownloadController extends Controller
{
    // view download page
    public function index($file_id)
    {
        // Get file data
        $file = Upload::where('file_id', $file_id)->first();
        // if data not null
        if ($file != null) {
            return view('pages.download', ['file' => $file]);
        } else {
            // Abort 404
            return abort(404);
        }
    }

    // Download file
    public function downloadFile($file_id)
    {
        // Get file data
        $file = Upload::where('file_id', $file_id)->first();
        // if data not null
        if ($file != null) {
            $file_id = $file->file_id; // file id
            $file_type = $file->file_type; // file type
            $filename = $file_id . '.' . $file_type; // file name
            // check file storage
            if ($file->method == 1) {
                $file_path = "filebob/uploads/storage/" . $filename;
                if (file_exists($file_path)) {
                    $downloads = $file->downloads + 1;
                    $update_downloads = Upload::where('file_id', $file_id)->update(['downloads' => $downloads]);
                    return \Response::download($file_path);
                } else {
                    // Abort 404
                    return abort(404);
                }
            } elseif ($file->method == 2) {
                if (Storage::disk('s3')->has($filename)) {
                    $downloads = $file->downloads + 1;
                    $update_downloads = Upload::where('file_id', $file_id)->update(['downloads' => $downloads]);
                    return redirect(Storage::disk('s3')->temporaryUrl($filename,now()->addHour(),['ResponseContentDisposition' => 'attachment']));
                } else {
                    // Abort 404
                    return abort(404);
                }
            } elseif ($file->method == 3) {
                if (Storage::disk('wasabi')->has($filename)) {
                    $downloads = $file->downloads + 1;
                    $update_downloads = Upload::where('file_id', $file_id)->update(['downloads' => $downloads]);
                    return redirect(Storage::disk('wasabi')->temporaryUrl($filename,now()->addHour(),['ResponseContentDisposition' => 'attachment']));
                } else {
                    // Abort 404
                    return abort(404);
                }
            } elseif ($file->method == 4) {
                if (Storage::disk('b2')->has($filename)) {
                    $downloads = $file->downloads + 1;
                    $update_downloads = Upload::where('file_id', $file_id)->update(['downloads' => $downloads]);
                    return Storage::disk('b2')->download($filename);
                } else {
                    return abort(404);
                }
            }
        } else {
            // Abort 404
            return abort(404);
        }
    }
}
