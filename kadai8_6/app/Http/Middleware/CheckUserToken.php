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
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // The session can be flushed for testing this way
        $request->session()->flush();

        // There should be both id and token with routes associated with this middleware
        if (!$request->id || !$request->token) {
            // Reject request if either is not supplied
            return response()->json(['data' => ['idとtoken(必須)フィールドに入力してください。']], 200);
        }

        // Variables for the id and token
        $userId = null;
        $userToken = null;

        // If the id value is cached, use it
        if ($request->session()->has('id')) {
            $userId = $request->session()->get('id');
        } else {
            // If the id wasn't in the session, check the id (as an int)
            $idToCheck = intval($request->id);
            // Get the correct id
            $userExists = $this->userService->userExistsWithId($idToCheck);
            if ($userExists) {
                $userId = $idToCheck;
            } else {
                return response()->json(['data' => ['有効idを入力してください。']], 200);
            }
            // If there is no error, the id is correct so store it in the session
            $request->session()->put('id', $userId);
        }

        // If the token value is cached, use it
        if ($request->session()->has('token')) {
            $userToken = $request->session()->get('token');
        } else {
            // If the token wasn't in the session, check the token
            $tokenToCheck = $request->token;
            // Get the correct token
            $correctToken = $this->userService->getTokenByUserID($userId);
            // The token is null by default, so reject in this case
            if (!$correctToken) {
                return response()->json(['data' => ['有効tokenを入力してください。']], 200);
            }

            if ($tokenToCheck == $correctToken) {
                return $next($request);
            } else {
                return response()->json(['data' => ['有効tokenを入力してください。']], 200);
            }
            // If there is no error, the token is correct so store it in the session
            $request->session()->put('token', $userToken);
        }
        // If no previous JSON response was returned, allow the request
        return $next($request);
    }
}
