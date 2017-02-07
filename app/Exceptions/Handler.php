<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
//        AuthorizationException::class,
//        HttpException::class,
//        ModelNotFoundException::class,
//        ValidationException::class,
//        MethodNotAllowedHttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([], 405);
        /**
         * Request required authorization
         */
        } else if($e instanceof AuthorizationException){
            return response()->json([], 403);
        } else if($e instanceof FatalErrorException){
            return response()->json([], 500);
        } else if($e instanceof \ErrorException){
            return response()->json([], 500);
        /**
         * Model got some additional parameters that can override existing business logic (like role, balance, etc..)
         */
        } else if($e instanceof MassAssignmentException){
            return response()->json([], 500);
        /**
         * Model got some broken builded query (log query?)
         */
        } else if($e instanceof QueryException){
            return response()->json([], 500);
        }
        return parent::render($request, $e);
    }
}
