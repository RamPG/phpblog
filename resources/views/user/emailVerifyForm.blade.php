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
<div class="register-box">
    <div class="register-logo">
        <b>Активация профиля</b>
    </div>

    <div class="card">
        <div class="card-body register-card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('verifyEmail') }}">
                <p>
                    На ваш почтовый ящик {{ $email }} должно прийти сообщение с кодом активации<br>

                </p>
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="verify-code" class="form-control" placeholder="Введите код активации">
                    <div class="input-group-append">
                        <div class="input-group-text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <button type="submit" class="btn btn-primary btn-block">Активировать</button>
                    <!-- /.col -->
                </div>
            </form>
            <a href="{{ route('changeEmailForm') }}" class="text-center">Изменить почту</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
