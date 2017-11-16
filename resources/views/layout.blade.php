<!doctype html>
<html lang="en">
<head>
    <title>NHL Lottery Simulator - @yield('title')</title>
    <link rel="stylesheet" href="/css/app.css?x={{rand(0,1000)}}"/>
</head>
<body>
<header class="header">
    <h3><a href="/">NHL LOTTERY SIMULATOR</a></h3>
</header>

<div class="container">
    @yield('content')
</div>
</body>
</html>