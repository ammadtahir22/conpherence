<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function get_news_index()
    {
        $news = News::where('status', 1)->orderBy('created_at', 'desc')->paginate(5);

        return view('site/news/index', compact('news'));
    }

    public function get_news($id)
    {
        $news = News::find($id);

        if($news)
        {
            return view('site/news/news', compact('news'));
        } else {
            return view('site/errors/404');
        }
    }

//    public function save_comment(Request $request)
//    {
//        $validation = Validator::make($request->all(), array(
//                'comment' => 'required',
//            )
//        );
//
//        $error_array = array();
//        $success_output = '';
//
//        if($validation->fails()) {
//            foreach($validation->messages()->getMessages() as $field_name => $messages)
//            {
//                $error_array[] = $messages;
//            }
//        } else {
//            $id = $request->input('id');
//            $comment = Blog_comment::updateOrCreate(['id' => $id],
//                ['user_id' => Auth::user()->id,
//                    'comment' => $request->input('comment'),
//                    'status' => 0
//                ]);
//            $success_output = '<div class="alert alert-success">Comment added and sent to the admin for approval</div>';
//        }
//
//        return response()->json(['data' => [], 'success' =>  $success_output, 'error'=>  $error_array]);
//
//    }
}
