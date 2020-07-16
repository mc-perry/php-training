<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GachaService;
// Requests
use App\Http\Requests\CreateGachaRequest;


class GachaController extends Controller
{
    private $userService;

    public function __construct(
        GachaService $gachaService
    ) {
        $this->gachaService = $gachaService;
    }

    public function index()
    {
    }

    public function createGacha(CreateGachaRequest $request)
    {
        $gachaResult = $this->gachaService->createGacha($request);
        return response()->json($gachaResult);
    }

    public function issueConsecutiveGachas(CreateGachaRequest $request)
    {
        $gachaResult = $this->gachaService->issueConsecutiveGachas($request);
        return response()->json($gachaResult);
    }
}
