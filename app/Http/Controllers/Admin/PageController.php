<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $pages= Page::all();
        return view('admin-panel.pages.index', compact('pages'));
    }


    public function create()
    {
        return view('admin-panel.pages.create');
    }


    public function edit($id)
    {
        $pages = Page::findOrFail($id);


        return view('admin-panel.pages.edit' , compact('pages'));
    }



    public function save(Request $request)
    {
        //dd($request);
        $data = new Page;
        $data->slug = $request->slug;
        $data->title = $request->title;
        $data->content = $request->ckeditor;
        $data->status = $request->status;

        if (empty($request->seo)) {
            $data->seo = strip_tags(str_limit($request->ckeditor, 150));
        } else {
            $data->seo = $request->seo;
        }
        if (empty($request->keyword)) {
            $data->keyword = $request->title;
        } else {
            $data->keyword = $request->keyword;
        }
        $data->save();

        if ($request->status == 1) {
            $status = 'Publish';
        } elseif ($request->status == 0) {
            $status = 'Draft';
        }

        return redirect(route('admin.pages'))->with('message', 'Success Update');

    }


    public function update(Request $request, $id)
    {
        $data = Page::findOrFail($id);

        $data->slug = $request->slug;
        $data->title = $request->title;
        $data->content = $request->ckeditor;
        $data->status = $request->status;
        

        if (empty($request->seo)) {
            $data->seo = strip_tags(str_limit($request->ckeditor, 150));
        } else {
            $data->seo = $request->seo;
        }
        if (empty($request->keyword)) {
            $data->keyword = $request->title;
        } else {
            $data->keyword = $request->keyword;
        }
        $data->save();

        //return view('admin-panel.pages.index');
        return redirect(route('admin.pages'))->with('message', 'Success Update');
    }


    public function delete($id)
    {
        $data = Page::findOrFail($id);

        $data->delete();

        //return view('admin-panel.pages.index');
        return redirect(route('admin.pages'))->with('message', 'Success Delete');
    }

}