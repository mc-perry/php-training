<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\GameOverRequest;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        if ($loginResponse === "E10500") {
            return response()->json(['data' => ['存在しないIDです。']], 200);
        } else {
            return $loginResponse;
        }
    }

    public function confirm(ConfirmRequest $request)
    {
        $confirmResponse = $this->userService->confirmUserToken($request->id, $request->token);
        if ($confirmResponse === "E10500") {
            return response()->json(['data' => ['ユーザーは存在しません。']], 200);
        } elseif ($confirmResponse === "E10510") {
            // The token entered is wrong
            return response()->json(['data' => ['不正です。']], 200);
        } else {
            return $confirmResponse;
        }
    }

    public function gameover(GameOverRequest $request)
    {
        // Check if the request is for a non-existent user
        if ($this->userService->getUserByUserID($request->id) === null) {
            return response()->json(['data' => ['ユーザーは存在しません。']], 200);
        }
        DB::beginTransaction();
        try {
            // First increment the user experience
            $newExperienceLevel = $this->userService->incrementUserExp($request->id, $request->exp);
            // Update the level if needed
            $levelSet = $this->userService->updateLevel($request->id, $newExperienceLevel);
            DB::commit();
        } catch (\Throwable $d) {
            Log::info("error:: " . $d->getMessage());
            DB::rollBack();
        }
        return response()->json(['data' => ["Game over!!! Level set was: {$levelSet}"]], 200);
    }
}
