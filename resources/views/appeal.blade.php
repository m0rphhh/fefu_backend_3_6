<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Обращение </title>

</head>
<body>
    <h1> Новое обращение </h1>
    @if($success)
        <p style="color: green">Обращение успешно отправлено</p>
    @endif
    <form action="{{route('appeal.send')}}" method="POST">
        @csrf

        <div>
            <label>Имя</label>
            <input type="text" name="name" value="{{old('name')}}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Почта</label>
            <input type="text" name="email" value="{{old('email')}}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Телефон</label>
            <input type="text" name="phone" value="{{old('phone')}}">
            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Сообщение</label>
            <textarea name="message" cols="30" rows="10" value="{{old('message')}}"></textarea>
            @error('message')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div>
                <input type="submit" value="Отправить">
            </div>
        </div>

    </form>
</body>
</html>
