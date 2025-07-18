<?php

namespace App\Exceptions;

use App\Admin\Traits\Api\ApiResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

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
        if (env('APP_DEBUG') === true)
            return parent::render($request, $exception);
        if ($exception instanceof NotFoundHttpException) {
            abort(404);
        } elseif ($exception instanceof SelfException) {
            return $this->failed($exception->getMessage());
        } elseif ($exception instanceof \Throwable) {
            elog('全局抛出异常', $exception, $request->all());
        }
        return $this->failed('系统异常，请刷新重试');
    }
}
