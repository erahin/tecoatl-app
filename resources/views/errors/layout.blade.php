<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1934e005fb.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: rgb(251 141 109);
            color: rgb(62 93 88);
            font-family: arboria, sans-serif;
            font-weight: 400;
            font-style: normal;
            height: 100vh;
            margin: 0;
            text-transform: uppercase;
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

        .content {
            text-align: center;
        }

        .title {
            font-size: 36px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title">
                @yield('code') | @yield('message')
            </div>
        </div>
    </div>
</body>

</html>
