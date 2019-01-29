<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Mail\Application;
use App\Models\Admin\Blog_post;
use App\Models\Admin\Career;
use App\Models\Admin\Career_category;
use App\Models\Site\Blog_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    public function get_career_index()
    {
//        $career_categories = DB::table('career_categories')
//            ->join('careers', 'career_categories.id', '=', 'careers.category_id')
//            ->select( 'career_categories.*')
//            ->where('career_categories.title', '!=', 'Uncategorized')
//            ->where('careers.status', '=', 1)
//            ->get()->unique();

//        $career_categories = Career_category::wherehas('careers')->get();

        $career_categories = Career_category::whereHas('careers', function ($query)  {
            $query->where('status', 1);
        })->get();

        return view('site/career/index', compact('career_categories'));
    }

    public function search_career(Request $request)
    {
        $value = $request->input('value');

//        $career_categories = Career_category::whereHas('careers', function ($query) use ($value) {
//            $query->where('status', 1)
//                ->where(function($innerQuery) use ($value){
//                    $innerQuery->orWhere('title','LIKE','%'.$value.'%')->orWhere('location','LIKE','%'.$value.'%');
//                })->get();
//        })->get();


        if($value != '')
        {
            $career_categories = DB::table('career_categories')
                ->join('careers', 'career_categories.id', '=', 'careers.category_id')
                ->select('career_categories.*')
                ->where('career_categories.title', '!=', 'Uncategorized')
                ->where('careers.status', '=', 1)
                ->where(function($innerQuery) use ($value){
                    $innerQuery->orWhere('careers.title','LIKE','%'.$value.'%')->orWhere('careers.location','LIKE','%'.$value.'%');
                })
                ->get()->unique();
        } else {
            $career_categories = DB::table('career_categories')
                ->join('careers', 'career_categories.id', '=', 'careers.category_id')
                ->select('career_categories.*')
                ->where('career_categories.title', '!=', 'Uncategorized')
                ->where('careers.status', '=', 1)
                ->get()->unique();
        }

        $date = '';
        $error = '';

        if(count($career_categories) > 0)
        {
            foreach ($career_categories as $key=>$category)
            {
                if($key == 0)
                {
                    $collapse ='in';
                } else {
                    $collapse ='';
                }

                $date .= '<div class="panel panel-default">';
                $date .= '<div class="panel-heading" role="tab" id="heading'.$key.'">';
                $date .= '<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$key.'" aria-expanded="true" aria-controls="collapse'.$key.'">'.$category->title.'</a> </h4>';
                $date .= '</div>';
                $date .= '<div id="collapse'.$key.'" class="panel-collapse collapse '. $collapse .'  no-transition" role="tabpanel" aria-labelledby="heading'.$key.'">';
                $date .= '<div class="panel-body">';

                $careers = [];
                $innerData = '';
                $careers = search_careers_by_category($category->id, $value);

                foreach ($careers as $innerKey=>$career)
                {
                    if($innerKey == 0)
                    {
                        $active ='active';
                    } else {
                        $active ='';
                    }

                    $innerData .= '<div class="panel-body">';
                    $innerData .= '<div class="faq-row full-col '.$active.'">';
                    $innerData .= '<div class="faq-info col-sm-7">'.$career->title.'</div>';
                    $innerData .= '<div class="faq-loaction col-sm-3">'.$career->location.'</div>';
                    $innerData .= '<div class="faq-btn col-sm-2"><a href="#">Apply Now</a></div>';
                    $innerData .= '</div><!-- faq-row -->';
                    $innerData .= '</div><!-- panel-body -->';
                }
                $date .= $innerData;
                $date .= '</div><!-- panel-collapse -->';;
                $date .= '</div><!-- container-->';
            }
        } else {
            $error = '<div class="alert alert-danger">Nothing Found</div>';
        }


        return response()->json(['data' => $date, 'success' =>  '', 'error'=>  $error]);

    }

    public function get_career($career_id)
    {
        $career = Career::find($career_id);

        return view('site/career/career', compact('career'));
    }

    public function apply_career(Request $request)
    {
        $validation = Validator::make($request->all(), array(
                //email field should be required, should be in an email//format, and should be unique
                'name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required',
                'resume' => 'required|file',
            )
        );



        $career_id = $request->input('career_id');
        $career = Career::find($career_id);

        if ($request->hasFile('resume')) {
            $path = 'files/application/'.$career_id.'/';
            $fileName = request()->resume->getClientOriginalName();
            $request->resume->storeAs($path,$fileName);
        }

        $error_array = array();
        $success_output = '';

        if($validation->fails()) {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        } else {
            $success_output = 'Thank You For Applying';

            $data = array(
                'name'=> $request->name,
                'email'=> $request->email,
                'phone_number'=> $request->phone_number
            );

            Mail::send('site.mail.application', $data, function ($message) use($data, $request, $career){
                $message->to('info@conpherence.com')->subject('New Application Received for '.$career->title);
                $message->attach($request->file('resume')->getRealPath(), [
                    'as' => $request->file('resume')->getClientOriginalName(),
                    'mime' => $request->file('resume')->getMimeType()
                ]);

            });
        }

        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );

        if($success_output != '')
        {
            session()->flash('msg-success', $success_output);
            return redirect()->back();
        } else {
            session()->flash('msg-error', $error_array);
            return redirect()->back();
        }



    }
}
