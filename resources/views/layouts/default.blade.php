<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 5.7 - @yield('title','Junge App')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts._head')
    <div class="container content">
        @include('shared._messages')
        @yield('content')
        @include('layouts._foot')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>