<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Вход </title>

</head>
<body>
<h1> Вход </h1>
<form action="{{route('login')}}" method="POST">
    @csrf
    <div>
        <label>Почта</label>
        <input type="text" name="email" value="{{old('email')}}">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label>Пароль</label>
        <input type="password" name="password">
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <input type="submit" value="Отправить">
    </div>

</form>
</body>
</html>
