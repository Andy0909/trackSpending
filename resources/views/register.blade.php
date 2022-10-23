<!DOCTYPE html>
<html lang="en">
    @extends('header')
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top">分帳軟體</a>
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

        @if($errors->any())
            <center>
                <h4>
                {{ implode('', $errors->all(':key')) }}
                {{ implode('', $errors->all(':message')) }}
                </h4>
            </center>
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
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter name..." required/>
                                <label for="name">姓名：</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>

                            <!-- Email input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" placeholder="Enter email..." required/>
                                <label for="email">信箱：</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">A email is required.</div>
                            </div>

                            <!-- Password input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter password..." required/>
                                <label for="password">密碼：</label>
                                <div class="invalid-feedback" data-sb-feedback="password:required">A password is required.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter password again..." required/>
                                <label for="password_confirmation">確認密碼：</label>
                                <div class="invalid-feedback" data-sb-feedback="password_confirmation:required">A password is required.</div>
                            </div>

                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                </div>
                            </div>

                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            
                            <!-- Submit Button-->
                            <!-- <button class="btn btn-primary btn-xl disabled" id="submitButton" type="submit">Send</button>-->
                            <div><center><input class="btn btn-primary" id="submit" type="submit" value="註冊"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        @extends('footer')
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
