<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GachaService;
use App\Services\UserService;
// Requests
use App\Http\Requests\CreateGachaRequest;


class GachaController extends Controller
{
    private $userService;

    public function __construct(
        GachaService $gachaService,
        UserService $userService
    ) {
        $this->gachaService = $gachaService;
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('gachagame.index')->with('users', $users);
    }

    public function createGacha(CreateGachaRequest $request)
    {
        $gachaResult = $this->gachaService->createGacha($request);
        return response()->json($gachaResult);
    }

    public function tenConsecutiveGachas(CreateGachaRequest $request)
    {
        $gachaResult = $this->gachaService->tenConsecutiveGachas($request);
        return response()->json($gachaResult);
    }
}
