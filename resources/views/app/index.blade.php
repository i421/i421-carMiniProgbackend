<!--
========================================================
--------------------------------------------------------
                     _   _  __  __ 
         _ __ ___   __ _ ___| |_(_)/ _|/ _|
        | '_ ` _ \ / _` / __| __| | |_| |_ 
        | | | | | | (_| \__ \ |_| |  _|  _|
        |_| |_| |_|\__,_|___/\__|_|_| |_|  
--------------------------------------------------------
========================================================
-->
<!DOCTYPE>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('title')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="keywords" content="mastiff" />
        <meta name="description" content="mastiff" />
        <link rel="stylesheet" href="/css/app.css" media="screen">
        @yield('css')
    </head>
    <body style="overflow-y: hidden;">
        <div id="app"> </div>
        <script src="/js/app.js" defer="defer"></script>
        @yield('js')
    </body>
</html>
