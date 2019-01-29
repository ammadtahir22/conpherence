<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Blog_post;
use App\Models\Admin\Post_category;
use App\Models\Site\Blog_comment;
use App\Models\Site\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\DeclareDeclare;
use phpseclib\Crypt\Blowfish;

class BlogController extends Controller
{
    /**
     * BlogController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function posts_index()
    {
        $posts = Blog_post::all();

        return view('admin-panel.blog.all-posts', compact('posts'));
    }

    public function create_post()
    {
        $categories = Post_category::all();

        return view('admin-panel.blog.add-post', compact('categories'));
    }

    public function save_post(Request $request)
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

        $post_id = $request->input('id');

        if(isset($post_id))
        {
            $post = Blog_post::find($post_id);
            $image = $post['image'];
        } else {
            $post = new Blog_post();
            $image = ' ';
        }

        $post->title = $request->input('title');
        $post->slug = createSlug($request->input('title'));
        $post->image = $image;
        $post->description = $request->input('description');
        $post->category_id = $request->input('category_id');
        $post->status = $request->input('status');
        $post->save();

        if ($request->hasFile('image')) {
            $path = 'images/blogs/' .$post->id.'/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $post->image = $fileName;
        }

        $post->save();
        if(isset($post_id))
        {
            session()->flash('msg-success', 'Post has been updated successfully');
        } else {
            session()->flash('msg-success', 'Post has been added successfully');
        }
        return redirect()->route('all.posts');
    }

    public function save_post_image($id, Request $request)
    {
        dd($id);
        $post_id = $request->input('id');

        $post = Blog_post::find($post_id);

        if ($request->hasFile('image')) {
            $path = 'images/blogs/' .$post->id.'/';
            $fileName = request()->image->getClientOriginalName();
            $request->image->storeAs($path,$fileName);
            $post->image = $fileName;
        }

        if(isset($post_id))
        {
            $post = Blog_post::find($post_id);
            $image = $post['image'];
        } else {
            $post = new Blog_post();
            $image = ' ';
        }
    }

    public function edit_post($post_id)
    {
        $post = Blog_post::find($post_id);
        $categories = Post_category::all();

        return view('admin-panel.blog.add-post', compact('post', 'categories'));
    }

    public function delete_post($post_id)
    {
        $post = Blog_post::find($post_id);

        if($post)
        {
            $post->delete();
            session()->flash('msg-success', 'Post has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.posts');
    }

    public function categories_index()
    {
        $categories = Post_category::all();

        return view('admin-panel.blog.all-categories', compact('categories'));
    }

    public function create_category()
    {
        return view('admin-panel.blog.add-category');
    }

    public function save_category(Request $request)
    {
        $category_id = $request->input('id');

        Post_category::updateOrCreate(['id' => $category_id], $request->all());
        if(isset($category_id)){
            session()->flash('msg-success', 'Category has been updated successfully');
        }else{
            session()->flash('msg-success', 'Category has been added successfully');
        }
        return redirect()->route('all.post.categories');
    }

    public function edit_category($category_id)
    {
        $category = Post_category::find($category_id);

        return view('admin-panel.blog.add-category', compact('category'));
    }

    public function delete_category($category_id)
    {
        $category = Post_category::find($category_id);

        if($category)
        {
            foreach ($category->blog_posts as $post)
            {
                $post->category_id = 1;
                $post->save();
            }

            $category->delete();
            session()->flash('msg-success', 'Category has been deleted successfully');
        } else {
            session()->flash('msg-error', 'Error');
        }

        return redirect()->route('all.post.categories');
    }

    public function comment_index(Request $request)
    {
        $comments = Blog_comment::all();

        return view('admin-panel.blog.all-comments', compact('comments'));
    }

    public function change_comment_status(Request $request)
    {
        $comment_id = $request->input('id');
        $comment = Blog_comment::find($comment_id);

        if($comment)
        {
            if($comment->status == 1)
            {
                $comment->status = 0;
            } else {
                $comment->status = 1;
            }
            $comment->save();
        }

        return redirect()->route('all.comments');
    }

}
