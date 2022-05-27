<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>OAuth login failed</h1>
    <p> {{ $provider }} auth failed. Try another way to log in</p>
    <p> Error: {{ $error }}</p>
</body>
</html>
