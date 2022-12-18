<!DOCTYPE html>
<html lang="en">
    @extends('header')
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="/login">分帳軟體</a>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">登入會員</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </header>

        <!-- register success message -->
        <center><h4>{{$registerSuccessMessage}}</h4></center>

        <!-- error message -->
        @if ($errors->count())
            @foreach ($errors->all() as $error)
                <center><h4 style="color: red">{{$error}}</h4></center>
            @endforeach
        @endif

        <!-- form Section-->
        <section class="page-section" id="form">
            <div class="container">
                <!-- Contact Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <form id="login" action="/login" method="POST">
                            @csrf
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
                            
                            <!-- Submit Button-->
                            <div><center><input class="btn btn-primary" id="submit" type="submit" value="登入"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        @extends('footer')
    </body>
</html>
