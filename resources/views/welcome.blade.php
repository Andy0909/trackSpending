<!DOCTYPE html>
<html lang="en">
    @extends('header')
    <body id="page-top">

        <!-- 有錯誤訊息就用 alert 提醒 -->
        @if (session('errorMessage'))
            <script>
                alert("{{ session('errorMessage') }}");
            </script>
        @endif

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/">分帳軟體</a>
            </div>
        </nav>

        <!-- Masthead -->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">歡迎使用分帳軟體</h2>
                <!-- Icon Divider -->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </header>

        <!-- form Section -->
        <section class="page-section" id="form">
            <div class="container">
                <!-- Contact Section Form -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <!-- Button -->
                        <center>
                        <div style="margin-bottom:30px;">
                            <button class="btn btn-primary" id="register" type="button" onclick="window.location.href='/register';">註冊</button>
                            <button class="btn btn-primary" id="login" type="button" onclick="window.location.href='/login';">登入</button>
                        </div>
                        <div style="margin-bottom:10px; color:#888888">或快速登入</div>
                        <div>  
                            <a href="{{ route('login.google') }}"><img src="{{ asset('assets/img/google.jpg') }}" style="width:50px;" alt="google"></a>
                            <a href="{{ route('login.github') }}"><img src="{{ asset('assets/img/github.png') }}" style="width:50px;" alt="github"></a>
                        </div>
                        </center>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        @extends('footer')
    </body>
</html>