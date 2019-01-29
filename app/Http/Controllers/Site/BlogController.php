<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Blog_post;
use App\Models\Site\Blog_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function get_blog_index()
    {
        $blogs = Blog_post::where('status', 1)->orderBy('created_at', 'desc')->paginate(9);

        return view('site/blog/index', compact('blogs'));
    }

    public function get_blog($id)
    {
        $blog = Blog_post::find($id);
        $next = Blog_post::where('id', '>', $blog->id)->orderBy('id')->first();
        $previous = Blog_post::where('id', '<', $blog->id)->orderBy('id','desc')->first();

        if($blog)
        {
            return view('site/blog/blog', compact('blog', 'next', 'previous'));
        } else {
            return view('site/errors/404');
        }
    }

    public function save_comment(Request $request)
    {
        $validation = Validator::make($request->all(), array(
                'comment' => 'required',
            )
        );

        $error_array = array();
        $success_output = '';

        if($validation->fails()) {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {
            $id = $request->input('id');
            $comment = Blog_comment::updateOrCreate(['id' => $id],
                ['user_id' => Auth::user()->id,
                    'comment' => $request->input('comment'),
                    'blog_id' => $request->input('blog_id'),
                    'status' => 0
                ]);
            $success_output = '<div class="alert alert-success">Comment added and sent to the admin for approval</div>';
        }

        return response()->json(['data' => [], 'success' =>  $success_output, 'error'=>  $error_array]);

    }
}
