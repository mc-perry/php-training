<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\GameOverRequest;
use App\Facades\Error;

class UserController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function getAll() {
        return $this->userService->getAllUsers();
    }

    /**
     * Create a user
     *
     * @param UserCreateRequest $request
     * @return JsonResponse
     */

    public function create(UserRequest $request)
    {
        return $this->userService->insertUser($request->only(['nickname']));
    }

    public function login(LoginRequest $request)
    {
        $loginResponse = $this->userService->assignTokenToUser($request->id);
        // Login error is handled in service, so return response if returned
        return $loginResponse;
    }

    public function confirm(ConfirmRequest $request)
    {
        $confirmResponse = $this->userService->confirmUserToken($request->id, $request->token);
        // Errors are now handled in the user service via the error Facade
        return $confirmResponse;
    }

    public function gameover(GameOverRequest $request)
    {
        // Check if the request is for a non-existent user
        if ($this->userService->getUserByUserID($request->id) === null) {
            Error::handleError("100011");
        }

        // Handle all of the database operations in a transaction
        $gameoverResponse = $this->userService->incrementExperienceUpdateLevelAndRanking($request->id, $request->exp);
        return response()->json(['data' => $gameoverResponse], 200);
    }
}
