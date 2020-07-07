<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GachaService;
use App\Http\Requests\CreateGachaRequest;


class GachaController extends Controller
{

    public function __construct(
        GachaService $gachaService
    ) {
        $this->gachaService = $gachaService;
    }

    public function createGacha(CreateGachaRequest $request)
    {
        $gachaResult = $this->gachaService->createGacha($request);
        return response()->json($gachaResult);
    }
}
