<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    // View pages
    public function index()
    {
        // Get pages data
        $pages = Page::all();
        return view('admin.pages', ['pages' => $pages]);
    }

    // View add new page
    public function addPageIndex()
    {
        return view('admin.add.page');
    }

    // Add new page store
    public function addPageStore(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:100', 'unique:pages'],
        ]);

        // Errors response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        // Create new page
        $page = Page::create([
            'title' => $request['title'],
            'slug' => str_replace(' ', '-', $request['slug']),
            'content' => $request['content'],
        ]);

        if ($page) {
            // Success response
            return response()->json([
                'success' => 'New page added successfully',
            ]);
        } else {
            // Error response
            return response()->json([
                'error' => 'Error please refresh page and try again',
            ]);
        }
    }

    // View edit page
    public function editPage($id)
    {
        // Get page data
        $page = Page::where('id', $id)->first();
        // if data not null
        if ($page != null) {
            return view('admin.edit.page', ['page' => $page]);
        } else {
            // Abort 404 if data null
            return abort(404);
        }

    }

    // update page info
    public function editPageStore(Request $request)
    {
        // Get page data
        $page = Page::where('id', $request['page_id'])->first();
        // If page data is null
        if ($page != null) {
            // Validate null
            $validator = null;
            // If slug is the same validate without unique one
            if ($page->slug === $request['slug']) {
                // Validate form
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:50'],
                    'slug' => ['required', 'string', 'max:100'],
                ]);
            } else {
                // Validate form
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:50'],
                    'slug' => ['required', 'string', 'max:100', 'unique:pages'],
                ]);
            }

            // Errors response
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }

            // update page
            $pageUpdate = Page::where('id', $request['page_id'])->update([
                'title' => $request['title'],
                'slug' => str_replace(' ', '-', $request['slug']),
                'content' => $request['content'],
            ]);

            if ($pageUpdate) {
                // Success response
                return response()->json([
                    'success' => 'updated successfully',
                ]);
            } else {
                // Error response
                return response()->json([
                    'error' => 'Error please refresh page and try again',
                ]);
            }
        } else {
            // Error response
            return response()->json([
                'error' => 'illegal request',
            ]);
        }
    }

    // Delete page
    public function deletePage($id)
    {
        // get page by id
        $page = Page::where('id', $id)->first();
        // if data not null
        if ($page != null) {
            // Delete page
            $delete = Page::where('id', $id)->delete();
            // if delete
            if ($delete) {
                // Success response
                return response()->json([
                    'success' => 'Page deleted successfully',
                ]);
            } else {
                // Error response
                return response()->json(['error' => 'Delete error please refresh page and try again']);
            }
        } else {
            // Error response if data is null
            return response()->json(['error' => 'Delete error please refresh page and try again']);
        }
    }
}
