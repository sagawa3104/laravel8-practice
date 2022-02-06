<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('css/destyle.css')}}" media="all">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}" media="all">
    </head>
    <body>
        <title>ログイン</title>
        <header class="header">
            <nav class="header__nav">
                <ul class="horizontal-list horizontal-list--left">
                    <li class="horizontal-list__item">left_menu1</li>
                    <li class="horizontal-list__item">left_menu2</li>
                </ul>
                <ul class="horizontal-list horizontal-list--right">
                    <li class="horizontal-list__item">
                        <form method="POST" action="{{route('logout')}}">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    <li class="horizontal-list__item">right_menu2</li>
                </ul>
            </nav>
        </header>
        <div class="flex-container">
            <aside class="side-bar">
                <p>サイドメニューエリア</p>
                <br>
                <br>
                <br>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">マスタ管理</label>
                    <ul class="side-bar__category__list">
                        <li class="side-bar__category__list__item">
                            <a href="#">工程管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="#">品目管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="#">部位管理</a>
                        </li>
                        <li class="side-bar__category__list__item">
                            <a href="#">仕様管理</a>
                        </li>
                    </ul>
                </section>
                <section class="side-bar__category">
                    <label class="side-bar__category__label">統計管理</label>
                </section>
            </aside>
            <main class="">
                @yield('content')
            </main>
        </div>
    </body>
</html>
