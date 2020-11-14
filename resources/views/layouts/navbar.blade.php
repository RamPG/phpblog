<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Мой блог</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @guest

        @endguest
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('loginForm') }}>
                            Вход
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('registerForm') }}>
                            Регистрация
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('user', ['id' => Auth::user()->id]) }}>
                            Профиль
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('logout') }}>
                            Выход
                        </a>
                    </li>

                @endauth
            </ul>
        </div>
    </div>
</nav>
