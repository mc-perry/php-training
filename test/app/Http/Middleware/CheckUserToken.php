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
        // There should be both id and token with routes associated with this middleware
        if (!$request->id || !$request->token) {
            // Reject request if either is not supplied
            return response()->json(['data' => ['idとtoken(必須)フィールドに入力してください。']], 200);
        }
        // Variables for the id and token
        $userId = null;
        $userToken = null;
        // If the id value is cached, opt to use it
        if ($request->session()->has('id')) {
            // This line confirms that the caching by session is working
            // var_dump($request->session()->get('token'));
            $userId = $request->session()->get('id');
        } else {
            $userId = $request->id;
            $request->session()->put('id', $userId);
        }
        // If the token value is cached, opt to use it
        if ($request->session()->has('token')) {
            $userToken = $request->session()->get('token');
        } else {
            $userToken = $request->token;
            $request->session()->put('token', $userToken);
        }
        $tokenResponse = $this->userService->confirmUserToken($userId, $userToken);
        if ($tokenResponse['code']) {
            return response()->json($tokenResponse, 200);
        }
        return $next($request);
    }
}