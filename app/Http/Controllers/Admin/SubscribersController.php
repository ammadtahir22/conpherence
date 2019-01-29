<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Subscribers;
use Illuminate\Support\Facades\Mail;



class SubscribersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //
    /**
     * AdminController constructor.
     */

    public function index()
    {
        $subscribers= Subscribers::all();
        return view('admin-panel.subscribers.index', compact('subscribers'));
    }



    public function postSubscribeAjax(Request $request) {
       // return "test";
        //dd($request);
        $validation = Validator::make($request->all(), array(
                //email field should be required, should be in an email//format, and should be unique
                'email' => 'required|email|unique:subscribers,email'
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

            $create = Subscribers::create(array(
                'email' => $request->get('email')
            ));


            $success_output = '<div class="alert alert-success">Thank You For Subscribing</div>';
            //If successful, we will be returning the '1' so the form//understands it's successful
            //or if we encountered an unsuccessful creation attempt,return its info

            Mail::to($create)->send(new Subscribe($create));

        }

        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);

    }

    public function delete($id)
    {
        $data = Subscribers::findOrFail($id);

        $data->delete();

        //return view('admin-panel.pages.index');
        return redirect(route('admin.subscribers'))->with('message', 'Success Delete');
    }



}
