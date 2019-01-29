<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Site\Credit_card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function Sodium\crypto_aead_aes256gcm_decrypt;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function save_credit_card(Request $request)
    {
        $validation = Validator::make($request->all(), array(
                // 'card_email' => 'required|email:',
                'card_number' => 'required',
                'card_month' => 'required',
                'card_year' => 'required',
                'card_currency' => 'required',
                'card_security_code' => 'required',
                'card_first_name' => 'required',
                'card_last_name' => 'required',
                'card_address' => 'required',
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
            $credit_card_id = $request->input('id');
            Credit_card::updateOrCreate(['id' => $credit_card_id],
                ['user_id' => Auth::user()->id,
                    'card_number' => $request->input('card_number'),
                    'month' => $request->input('card_month'),
                    'year' => $request->input('card_year'),
                    'currency' => $request->input('card_currency'),
                    'security_code' => $request->input('card_security_code'),
                    'first_name' => $request->input('card_first_name'),
                    'last_name' => $request->input('card_last_name'),
                    // 'email' => $request->input('card_email'),
                    'address' => $request->input('card_address'),
                ]);

            $success_output = '<div class="alert alert-success">Card Saved successfully</div>';
        }

    $credit_cards = Credit_card::where('user_id', Auth::user()->id)->get();
    $data = '';

    if (count($credit_cards) > 0)
    {
        foreach ($credit_cards as $credit_card)
        {
            $data .= '<div class="pay-inner-card">';
            $data .= '<h4>Visa'. $credit_card->card_number .'</h4>';
            $data .= '<h5>Last charged 07/04/2018</h5>';
            $data .= '<a href="#" class="del-card" data-toggle="modal" data-target="#delpopup" onclick="show_delete('. $credit_card->id .')"><img src="' . url('/images/delete.png') . '" alt=""></a>';
            $data .= '<a href="#" class="edit" data-toggle="modal" data-target="#editpopup" onclick="show_edit('. $credit_card->id .')"><img src="' . url('/images/edit.png') . '" alt="" /></a>';
            $data .= '<div class="dash-pay-gray">';
            $data .= '<div class="dash-pay-l-gray col-xs-6">';
            $data .= '<p>Card Holder Name<span>'. $credit_card->first_name .' '. $credit_card->last_name .' </span></p>';
            $data .= '<p>Expires<span>'. $credit_card->month .' '. $credit_card->year .'</span></p>';
            $data .= '<p>Currency<span>'. $credit_card->currency. '</span></p>';
            $data .= '</div>';
            $data .= '<div class="dash-pay-r-gray col-xs-6">';
            // $data .= '<p>Email<span><a href="mailto:'. $credit_card->email. '">'. $credit_card->email.'</a></span></p>';
            $data .= '<p>Billing Information
        <span>'. $credit_card->address.'</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>';
        }
    } else {
        $data .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No Credit Card added yet. </div> </div>';
    }
        return response()->json(['data' => $data, 'success' =>  $success_output, 'error'=>  $error_array]);

    }

    public function delete_card(Request $request)
    {
        $id = $request->input('id');
        $success_output = '';
        $error_output = '';
        $data = '';

        if($id){
            $credit_card = Credit_card::find($id);
            $credit_card->delete();

            $credit_cards = Credit_card::where('user_id', Auth::user()->id)->get();

            if (count($credit_cards) > 0)
            {
                foreach ($credit_cards as $credit_card)
                {
                    $data .= '<div class="pay-inner-card">';
                    $data .= '<h4>Visa'. $credit_card->card_number .'</h4>';
                    $data .= '<h5>Last charged 07/04/2018</h5>';
                    $data .= '<a href="#" class="del-card" data-toggle="modal" data-target="#delpopup" onclick="show_delete('. $credit_card->id .')"><img src="' . url('/images/delete.png') . '" alt=""></a>';
                    $data .= '<a href="#" class="edit" data-toggle="modal" data-target="#editpopup" onclick="show_edit('. $credit_card->id .')"><img src="' . url('/images/edit.png') . '" alt="" /></a>';
                    $data .= '<div class="dash-pay-gray">';
                    $data .= '<div class="dash-pay-l-gray col-xs-6">';
                    $data .= '<p>Card Holder Name<span>'. $credit_card->first_name .' '. $credit_card->last_name .' </span></p>';
                    $data .= '<p>Expires<span>'. $credit_card->month .' '. $credit_card->year .'</span></p>';
                    $data .= '<p>Currency<span>'. $credit_card->currency. '</span></p>';
                    $data .= '</div>';
                    $data .= '<div class="dash-pay-r-gray col-xs-6">';
                    // $data .= '<p>Email<span><a href="mailto:'. $credit_card->email. '">'. $credit_card->email.'</a></span></p>';
                    $data .= '<p>Billing Information
        <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>';
                }
            } else {
                $data .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No Credit Card added yet. </div> </div>';
            }


            $success_output .= '<div class="alert alert-success">Card Delete successfully</div>';
        } else {
            $error_output = '<div class="alert alert-danger">Card Not found</div>';
        }

        return response()->json(['data' => $data, 'success' =>  $success_output, 'error'=>  $error_output]);
    }

    //ajax call
    /**
     * @param Request $request
     * @return array
     */
    public function edit_credit_card(Request $request)
    {
        $id = $request->input('id');

        $credit_card = Credit_card::find($id);

        if ($credit_card)
        {
            return ['success' => true, 'data' => $credit_card];
        } else {
            return ['success' => false, 'data' => 'no data'];
        }
    }
}
