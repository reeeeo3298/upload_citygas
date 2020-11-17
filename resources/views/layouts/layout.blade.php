<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <link type="text/css" href="public/css/common.css" rel="stylesheet">
        <!--<link type="text/css" href="public/css/plugin/style.css" rel="stylesheet">-->
        @yield('pageCss')
    </head>

    <body>
        <header>
            <div class="header-block">
                @if(session()->has('name'))
                   <h1><a href="/Lpio_upload/list"><img src="public/images/logo.png"></a></h1>
                @else
                    <h1><a href="/Lpio_upload"><img src="public/images/logo.png"></a></h1>
                @endif
                
                @if(session()->has('name'))
                <ul class="header-list">
                    <li><a href="/Lpio_upload/list">お客様一覧</a></li>
                </ul>
                <div class="login_info">   
                    <p>ログイン：{{session('name')}}</p>
                </div>
                @endif
            </div>
        </header>
        <div class="container">
            @yield('content')
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script type="text/javascript" src="public/js/common.js"></script>
        <script type="text/javascript" src="public/js/plugin/jquery.autoKana.js"></script>
        <script type="text/javascript" src="public/js/plugin/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="public/js/plugin/daterangepicker.js"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <script type="text/javascript" src="public/js/plugin/jquery.elevateZoom-3.0.8.min.js"></script>
        <script type="text/javascript" src="public/js/plugin/jquery.elevatezoom.js"></script>
        @yield('pageJs')
    </body>
</html>
