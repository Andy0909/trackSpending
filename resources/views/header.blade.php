<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="@yield('keywords', '分帳, 分帳平台, 免費分帳, 分帳工具, 分帳服務, 快速分帳, 朋友分帳, 出遊分帳')" />
    <meta name="description" content="@yield('description', 'WeiTech分帳平台，免費提供簡單易用的分帳工具，幫助你快速分攤支出。無論是朋友聚會還是日常生活，我們的分帳平台讓一切更加輕鬆！')">
    <meta name="author" content="" />
    <title>@yield('title', 'WeiTech分帳平台 | 免費、簡單的分帳服務')</title>

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'WeiTech分帳平台 | 免費、簡單的分帳服務')" />
    <meta property="og:description" content="@yield('description', 'WeiTech分帳平台，免費提供簡單易用的分帳工具，幫助你快速分攤支出。無論是朋友聚會還是日常生活，我們的分帳平台讓一切更加輕鬆！')" />
    <meta property="og:image" content="{{ asset('favicon.ico') }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Multi Select-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css?v={{ time() }}">
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js?v={{ time() }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js?v={{ time() }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/trackSpending.js') }}"></script>
</head>
