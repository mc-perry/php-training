<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;

class CheckUserToken
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->id || !$request->token) {
            return response()->json(['data' => ['idとtoken(必須)フィールドに入力してください。']], 200);
        }
        $tokenResponse = $this->userService->confirmUserToken($request->id, $request->token);
        if ($tokenResponse['code']) {
            return response()->json($tokenResponse, 200);
        }
        return $next($request);
    }
}
