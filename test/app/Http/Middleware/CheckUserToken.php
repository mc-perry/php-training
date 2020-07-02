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
        // $request->session()->flush();

        // There should be both id and token with routes associated with this middleware
        if (!$request->id || !$request->token) {
            // Reject request if either is not supplied
            return response()->json(['data' => ['idとtoken(必須)フィールドに入力してください。']], 200);
        }

        // Variables for the id and token
        $userId = null;
        $userToken = null;

        // If the id value is cached, use it
        if ($request->session()->has('id') && $request->session()->has('access_token')) {
            $idToCheck = intval($request->id);
            $tokenToCheck = intval($request->token);

            $sessionId = $request->session()->get('id');
            $sessionToken = $request->session()->get('access_token');
            // Check if the request and session id match
            if ($sessionId != $idToCheck) {
                // If they don't, return an error
                return response()->json(['data' => ['他のユーザーの情報にアクセスしようとしています。']], 200);
            } else {
                $userId = $idToCheck;
            }
            // Check if the request and session token match
            if ($tokenToCheck != $sessionToken) {
                // If they don't, return an error
                return response()->json(['data' => ['トークンがセッションに保存されているものと一致しません。']], 200);
            } else {
                $userToken = $tokenToCheck;
            }
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

            $tokenToCheck = $request->token;
            // Get the correct token
            $correctToken = $this->userService->getTokenByUserID($userId);
            // The token is null by default, so reject in this case
            if (!$correctToken) {
                return response()->json(['data' => ['このユーザーのトークンはありません。']], 200);
            }

            if ($tokenToCheck == $correctToken) {
                $userToken = $tokenToCheck;
            } else {
                return response()->json(['data' => ['有効tokenを入力してください。']], 200);
            }

            // If there is no error, the id is correct so store it in the session
            $request->session()->put([
                'id' => $userId,
                'access_token' => $userToken
            ]);
        }
        // If no previous JSON response was returned, allow the request
        return $next($request);
    }
}
