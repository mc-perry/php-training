<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;
use Illuminate\Support\Facades\Session;

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
        Session::flush();

        // There should be both id and token with routes associated with this middleware
        if (!$request->id || !$request->token) {
            // Reject request if either is not supplied
            return response()->json(['data' => ['idとtoken(必須)フィールドに入力してください。']], 200);
        }

        // Variables for the id and token
        $userId = null;
        $userToken = null;

        // Variables for the sent data
        $idToCheck = intval($request->id);
        $tokenToCheck = $request->token;

        // If the id/token values are cached, use them
        if (Session::has('id') && Session::has('access_token')) {
            $sessionId = Session::get('id');
            $sessionToken = Session::get('access_token');
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
            // Get the correct id
            $userObject = $this->userService->getUserByUserIDAndToken($idToCheck, $tokenToCheck);

            if (!$userObject['id']) {
                return response()->json(['data' => ['有効idを入力してください。']], 200);
            } else {
                $userId = $userObject['id'];
            }

            if (!$userObject['access_token']) {
                return response()->json(['data' => ['このユーザーのトークンはありません。']], 200);
            } else {
                $userToken = $userObject['access_token'];
            }

            // If there is no error, the id is correct so store it in the session
            Session::put([
                'id' => $userId,
                'access_token' => $userToken
            ]);
        }
        // If no previous JSON response was returned, allow the request
        return $next($request);
    }
}
