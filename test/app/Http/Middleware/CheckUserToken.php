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
        // The session can be flushed for testing this way
        // $request->session()->flush();

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
            $idToCheck = $request->session()->get('id');
            // Check if a stored session id is set first
            if ($this->userService->userExistsWithId($idToCheck)) {
                $userId = $idToCheck;
            } else {
                // If it's not correct, then set the user-sent id
                $idToCheck = $request->id;
                if ($this->userService->userExistsWithId($idToCheck)) {
                    $userId = $idToCheck;
                    $request->session()->put('id', $userId);
                } else {
                    // Neither the cached id or the sent id were valid
                    return response()->json(['data' => ['有効idを入力してください。']], 200);
                }
            }
        } else {
            // If the id wasn't in the session, use the passed id
            $userId = $request->id;
            $request->session()->put('id', $userId);
        }

        // If the token value is cached, opt to use it
        if ($request->session()->has('token')) {
            $tokenToCheck = $request->session()->get('token');
            // Check if a stored session token is set first
            if ($this->userService->confirmUserToken($userId, $tokenToCheck)) {
                $userToken = $tokenToCheck;
            } else {
                // If it's not correct, then set the user-sent token
                $tokenToCheck = $request->token;
                if ($this->userService->confirmUserToken($userId, $tokenToCheck)) {
                    $userToken = $tokenToCheck;
                    $request->session()->put('token', $userToken);
                } else {
                    // Neither the cached token or the sent token were valtoken
                    return response()->json(['data' => ['有効tokenを入力してください。']], 200);
                }
            }
        } else {
            // If the token wasn't in the session, use the passed token
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
