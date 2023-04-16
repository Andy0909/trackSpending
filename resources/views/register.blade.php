<!DOCTYPE html>
<html lang="en">
    @extends('header')
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/register">分帳軟體</a>
            </div>
        </nav>

        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">註冊會員</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </header>

        @if ($errors->count())
            @foreach ($errors->all() as $error)
                <script>alert("{{ $error }}");</script>
            @endforeach
        @endif

        <!-- form Section-->
        <section class="page-section" id="form">
            <div class="container">
                <!-- Contact Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <form id="register" action="/register" method="POST">
                            @csrf
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" value="{{old('name')}}" placeholder="Enter name..." required/>
                                <label for="name">姓名：</label>
                            </div>

                            <!-- Email input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" value="{{old('email')}}" placeholder="Enter email..." required/>
                                <label for="email">信箱：</label>
                            </div>

                            <!-- Password input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter password..." required/>
                                <label for="password">密碼：</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter password again..." required/>
                                <label for="password_confirmation">確認密碼：</label>
                            </div>
                            
                            <!-- Submit Button-->
                            <div><center><input class="btn btn-primary" id="submit" type="submit" value="註冊"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        @extends('footer')
    </body>
</html>
