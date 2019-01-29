<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{

//    private $result;

//    /**
//     * JsonResult constructor.
//     * @param null $message
//     * @param null $data
//     * @param string $code
//     */
//    public function __construct($message =null, $code='200', $data=null)
//    {
//        $this->result = response()->json(['success' => true, 'error' => false, 'message' => $message, 'code' => $code, 'data' => $data]);
//    }
//
//        public function JSONSuccessResult($message=null, $code='200' , $data=null)
//    {
//        $result = ['success' => true, 'error' => false, 'message' => $message, 'code' => $code, 'data' => $data];
//        return response()->json($result);
//    }
//
//    public function JSONErrorResult($message=null, $code='404' , $data=null)
//    {
//        $result = ['success' => false, 'error' => true, 'message' => $message, 'code' => $code, 'data' => $data];
//        return response()->json($result);
//    }


    protected function outputJSON($message = '', $responseCode = 200, $result = null) {

//        if ($message != '') {
            $response["message"] = $message;
            $response["code"] = $responseCode;
//        }
//        if ($result != null) {
            $response["data"] = $result;
//        }

        return response()->json($response);
    }


    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return \Illuminate\Http\Response
     */
//    public function sendResponse($result, $message)
//    {
//        $response = [
//            'success' => true,
//            'data'    => $result,
//            'message' => $message,
//        ];
//
//
//        return response()->json($response, 200);
//    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
//    public function sendError($error, $errorMessages = [], $code = 404)
//    {
//        $response = [
//            'success' => false,
//            'message' => $error,
//        ];
//
//        if(!empty($errorMessages)){
//            $response['data'] = $errorMessages;
//        }
//
//        return response()->json($response, $code);
//    }
}