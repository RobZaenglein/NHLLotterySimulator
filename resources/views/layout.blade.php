<!doctype html>
<html lang="en">
<head>
    <title>NHL Lottery Simulator - @yield('title')</title>
    <link rel="stylesheet" href="/css/app.css?x={{rand(0,1000)}}"/>
</head>
<body>
<header class="header">
    <div class="container">
        <h3>
            <a href="/">NHL LOTTERY SIMULATOR</a>
            <span class="pull-right">
                <a href="https://twitter.com/nhllotterysim" target="_blank"><img src="/images/twitter.png"></a>
            </span>
        </h3>
    </div>
</header>

<div class="container">
    @yield('content')
</div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-38961825-4"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-38961825-4');
</script>
</body>
</html>