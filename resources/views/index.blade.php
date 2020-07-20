<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Yummi Pizza</title>
        <link href="css/app.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <div class="content">
            <div id="main">
            </div>
        </div>
    </body>
    <script>
        window.Auth = {!! json_encode([
            'user' => Auth::user(),
            'token' => csrf_token()
        ]) !!}
    </script>
    <script type="text/javascript" src="js/main.js"></script>
</html>