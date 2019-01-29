<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\News;
use App\Models\Admin\News_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NewsController extends Controller
{
    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function categories_index()
    {
        $categories = News_category::all();

        return view('admin-panel.news.all-categories', compact('categories'));
    }

    public function create_category()
    {
        return view('admin-panel.news.add-category');
    }

    public function save_category(Request $request)
    {
        $category_id = $request->input('id');

        News_category::updateOrCreate(['id' => $category_id], $request->all());
        if(isset($category_id) && $category_id != ''){
            session()->flash('msg-success', 'Category has been updated successfully');
        }else{
            session()->flash('msg-success', 'Category has been added successfully');
        }
        return redirect()->route('all.news.categories');
    }

    public function edit_category($category_id)
    {
        $category = News_category::find($category_id);

        return view('admin-panel.news.add-category', compact('category'));
    }

    public function delete_category($category_id)
    {
        $category = News_category::find($category_id);

        if($category)
        {
            foreach ($category->news as $news)
            {
                $news->category_id = 1;
                $news->save();
            }

            $category->delete();
            session()->flash('msg-success', 'Category has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.news.categories');
    }

    public function news_index()
    {
        $news = News::all();

        return view('admin-panel.news.all-news', compact('news'));
    }

    public function create_news()
    {
        $categories = News_category::all();

        return view('admin-panel.news.add-news', compact('categories'));
    }

    public function save_news(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:500',
            'description' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            session()->flash('msg-success', $validator->errors());
            return redirect()->back();
        }
        $news_id = $request->input('id');
        if(isset($news_id))
        {
            $news = News::find($news_id);
            $image = $news['image'];
        } else {
            $news = new News();
            $image = ' ';
        }
        $news->title = $request->input('title');
        $news->slug = createSlug($request->input('title'));
        $news->image = $image;
        $news->description = $request->input('description');
        $news->category_id = $request->input('category_id');
        $news->status = $request->input('status');
        $news->save();

        if ($request->hasFile('image')) {
            $path = 'images/news/' .$news->id.'/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $news->image = $fileName;
            $news->save();
        }
        if(isset($news_id))
        {
            session()->flash('msg-success', 'News has been updated successfully');
        } else {
            session()->flash('msg-success', 'News has been added successfully');
        }
        return redirect()->route('all.news');
    }

    public function edit_news($news_id)
    {
        $news = News::find($news_id);
        $categories = News_category::all();

        return view('admin-panel.news.add-news', compact('news', 'categories'));
    }

    public function delete_news($news_id)
    {
        $news = News::find($news_id);

        if($news)
        {
            $news->delete();
            session()->flash('msg-success', 'News has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.news');
    }

}
