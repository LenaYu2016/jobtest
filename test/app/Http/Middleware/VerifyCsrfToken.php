<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next); // TODO: Change the autogenerated stub
    }
    public function tokensMatch($request)
    {
       $token=$request->ajax()?$request->header('X-CSRF-Token'):$request->input('_token');
        return $request->session()->token()==$token;// TODO: Change the autogenerated stub
    }
}