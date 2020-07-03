<?php

namespace App\Classes;

class ErrorHandler
{
    public function handleError(string $errorCode)
    {
        switch ($errorCode) {
            case "100010":
                return ["code" => "100010", "data" => "不正アクセス"];
            case "100011":
                return ["code" => "100011", "data" => "ログインエラー"];
            case "100012":
                return ["code" => "100012", "data" => "データベースエラー"];
            default:
                return ["code" => "100000", "data" => "デフォルトのエラー"];
        }
    }
}
