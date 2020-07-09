<!DOCTYPE html>
<html lang="ja" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Gacha Game</title>
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: "Nunito", sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 32px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="title m-b-md">
            Gacha Game
        </div>
    </div>
    User ID:
    <select name="user_id" id="user_id" size="1">
        @foreach ($users as $user)
        <option value="{!! $user['id'] !!}"></option>
        @endforeach
    </select>
</body>

</html>