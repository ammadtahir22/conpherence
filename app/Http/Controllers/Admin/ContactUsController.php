<?php

namespace App\Http\Controllers\Admin;

use App\Mail\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ContactUS;
use Illuminate\Support\Facades\Mail;


class ContactUsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $contactus= ContactUS::all();
        return view('admin-panel.mails.index', compact('contactus'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /** * Show the application dashboard. * * @return \Illuminate\Http\Response */
    public function contactUSPost(Request $request)
    {
       // dd($request);
        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);
        $contact = ContactUS::create($request->all());
        $email_from = $request->get('email');
        Mail::send('site.mail.contact',
            array(
                'name' => $request->get('name'),
                'email' => $email_from,
                'user_message' => $request->get('message')
            ), function($message) use ($email_from)
            {
                $message->from($email_from);
                $message->to('info@conpherence.com', 'Conpherence')->subject('Contact Us');
            });

        return redirect()->back()->with('success', 'Thanks for contacting us!');
    }

    public function delete($id)
    {
        $data = ContactUS::findOrFail($id);

        $data->delete();

        //return view('admin-panel.pages.index');
        return redirect(route('admin.mails'))->with('message', 'Success Delete');
    }
}
