<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
//        $url = Request::url();
//
//        $admin = false;
//        $site = false;
//        $api = false;
//
//        if (strpos($url, 'admin') !== false) {
//            $admin = true;
//        } elseif (strpos($url, 'api') !== false)
//        {
//            $api = true;
//        } else {
//            $site = true;
//        }
//
//        if($admin)
//        {
//            if (! view()->exists("admin-panel.errors.{$e->getStatusCode()}")) {
//                return response()->view('admin-panel.errors.default', ['exception' => $e], 500, $e->getHeaders());
//            } else {
//                return response()->view("admin-panel.errors.{$e->getStatusCode()}");
//            }
//        }
//        if($site) {
//            if (!view()->exists("site.errors.{$e->getStatusCode()}")) {
//                return response()->view('site.errors.default', ['exception' => $e], $e->getStatusCode(), $e->getHeaders());
//            } else {
//                return response()->view("site.errors.{$e->getStatusCode()}");
//            }
//        }
//
//        if($api) {
//            $request ='';
//            return parent::prepareJsonResponse($request, $e);
//        }

        return parent::renderHttpException($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            //put the intended URL into the session data so that the user will
            //get redirected to the intended URL once after the user logs in
            $request->session()->put('url.intended', url()->previous());
            return response()->json(['error' => 'Unauthenticated.'],401);
        }
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'admin': $login = 'admin.login';
                break;
            default: $login = 'login';
                break;
        }
        return redirect()->guest(route($login));
    }
}
