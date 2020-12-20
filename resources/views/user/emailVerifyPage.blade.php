<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Registration Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="hold-transition register-page">
@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="register-box">
    <div class="register-logo">
        <b>Активация профиля</b>
    </div>
    <p>
        На ваш почтовый ящик должно прийти сообщение, перейдите по ссылке, чтобы подтвердить почту.
    </p>
    <a href="{{ route('changeEmailForm') }}">
        Сменить почту
    </a>
</div>
<!-- /.register-box -->

<script src="{{ asset('js/index.js') }}"></script>
</body>
</html>

