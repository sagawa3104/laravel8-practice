<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/destyle.css" media="all">
        <link rel="stylesheet" type="text/css" href="./css/app.css" media="all">
    </head>
    <body>
        <title>ログイン</title>
        <header class="header">
            <p>ヘッダーエリア</p>
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
                welcome home
            </main>
        </div>
    </body>
</html>
