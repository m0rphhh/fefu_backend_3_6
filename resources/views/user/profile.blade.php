<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Профиль </title>

</head>
<body>
<h1> Профиль {{ auth()->user()->name}}</h1>
<h2> Email : {{ auth()->user()->email }}</h2>
<form action="{{route('logout')}}" method="POST">
    @csrf
    <input type="submit" value="Выйти">
</form>
</body>
</html>
