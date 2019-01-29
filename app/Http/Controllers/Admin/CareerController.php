<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Career;
use App\Models\Admin\Career_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CareerController extends Controller
{
    /**
     * CareerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function categories_index()
    {
        $categories = Career_category::all();

        return view('admin-panel.career.all-categories', compact('categories'));
    }

    public function create_category()
    {
        return view('admin-panel.career.add-category');
    }

    public function save_category(Request $request)
    {
        $category_id = $request->input('id');

        Career_category::updateOrCreate(['id' => $category_id], $request->all());
        if(isset($category_id) && $category_id != ''){
            session()->flash('msg-success', 'Category has been updated successfully');
        }else{
            session()->flash('msg-success', 'Category has been added successfully');
        }
        return redirect()->route('all.career.categories');
    }

    public function edit_category($category_id)
    {
        $category = Career_category::find($category_id);

        return view('admin-panel.career.add-category', compact('category'));
    }

    public function delete_category($category_id)
    {
        $category = Career_category::find($category_id);

        if($category)
        {
            foreach ($category->careers as $career)
            {
                $career->category_id = 1;
                $career->save();
            }

            $category->delete();
            session()->flash('msg-success', 'Category has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.career.categories');
    }

    public function career_index()
    {
        $careers = Career::all();
        return view('admin-panel.career.all-careers', compact('careers'));
    }

    public function create_career()
    {
        $categories = Career_category::all();

        return view('admin-panel.career.add-career', compact('categories'));
    }

    public function save_career(Request $request)
    {
        $career_id = $request->input('id');

        $career = Career::updateOrCreate(['id' => $career_id],
            ['title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'location' => $request->input('location'),
                'description' => $request->input('ckeditor'),
                'category_id' => $request->input('category'),
                'status' => $request->input('status'),
            ]);

//        if ($request->hasFile('image')) {
//            $path = 'images/blogs/' .$news->id.'/';
//            $fileName = request()->image->getClientOriginalName();
//            $request->image->storeAs($path,$fileName);
//            $post->image = $fileName;
//            $post->save();
//        }
        if(isset($career_id) && $career_id != ''){
            session()->flash('msg-success', 'Career post has been updated successfully');
        }else{
            session()->flash('msg-success', 'Career post has been added successfully');
        }
        return redirect()->route('all.careers');
    }

    public function edit_career($career_id)
    {
        $career = Career::find($career_id);
        $categories = Career_category::all();

        return view('admin-panel.career.add-career', compact('career', 'categories'));
    }

    public function delete_career($career_id)
    {
        $career = Career::find($career_id);

        if($career)
        {
            $career->delete();
            session()->flash('msg-success', 'Career post has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.careers');
    }
}
