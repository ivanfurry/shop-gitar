<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="{{ route('home') }}">Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Главная <span class="sr-only">(current)</span></a>
            </li>
            @foreach($categories as $category)
                <li class="nav-item">
                    <a href="{{ route('categories.show', ['slug' => $category->slug]) }}" class="nav-link">{{ $category->title }}</a>
                </li>
            @endforeach
            <li class="nav-item">
                <button onclick="getCart('{{ route('cart.show') }}')" class="btn btn-primary" data-action="{{ route('cart.show') }}" type="button">
                    Корзина <span class="badge badge-light mini-cart-qty">{{ session('cart_qty') ?? 0 }}</span>
                </button>
            </li>
        </ul>

        <!-- Блок авторизации и регистрации -->
        <ul class="navbar-nav mr-3">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login.create') }}">Вход</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register.create') }}">Регистрация</a>
                </li>
            @endguest

            @auth
                <li class="nav-item">
                    <span class="nav-link text-light">{{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Выход</a>
                </li>
            @endauth
        </ul>

        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
