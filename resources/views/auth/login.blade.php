<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/destyle.css" media="all">
        <link rel="stylesheet" type="text/css" href="./css/app.css" media="all">
    </head>
    <body>
        <h1>Hello, world</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">eメール</label>
            <input type="text" id="email" name="email">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">
            <button type="submit">ログイン</button>
        </form>
    </body>
</html>
