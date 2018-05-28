<?php

namespace App\Exceptions;

use App\QueryExceptionUtil;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\MessageBag;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        if (is_a($exception, "Illuminate\Database\QueryException")) {
            $dbLog = new Logger("database_log");
            $dbLog->pushHandler(new StreamHandler(storage_path('logs/database.log')), Logger::INFO);
            $dbLog->error('dbLog', ["db:exception"=>$exception->getMessage()]);
        }

        if ($request->isXmlHttpRequest()) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        if (is_a($exception, "Illuminate\Database\QueryException")) {
            $errors = new MessageBag();
            $errors->add('database_error', QueryExceptionUtil::getErrorFromException($exception));
            return back()->withInput($request->all())->withErrors($errors);
        }
        
        return parent::render($request, $exception);
    }
}
