<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Профиль </title>

</head>
<body>
<div>
    <h3>OAuth info:</h3>
    <h4>GitHub:</h4>
    <label>
        <b>
            Last login date: {{ $user['github_logged_in_at'] ?? 'Never' }} <br/>
        </b>
        <b>
            Registration date: {{ $user['github_registered_at'] ?? 'Never' }}
        </b>
    </label>
    <h4>GitLab:</h4>
    <label>
        <b>
            Last login date: {{ $user['gitlab_logged_in_at'] ?? 'Never' }} <br/>
        </b>
        <b>
            Registration date: {{ $user['gitlab_registered_at'] ?? 'Never' }}
        </b>
    </label>
</div>
<form action="{{route('logout')}}" method="POST">
    @csrf
    <input type="submit" value="Выйти">
</form>
</body>
</html>
