<!DOCTYPE html>
<style>
    .btn-circle.btn-lg {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
    .form_style{
        width: 800px;
        height: 30px;
        margin: 0 auto;
    }
</style>
<html lang="en">
    @extends('header')
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-lowercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand">分帳軟體</a>
                <form id="logout" action="/logout" method="POST">
                    @csrf
                    <input type="hidden" id="userId" name="userId" value="{{$userId}}">
                </form>
                <ul style="color:white" class="nav navbar-nav navbar-right">
                    <li class="navbar-brand">{{$userName}}</li>&emsp;&emsp;
                    <li class="navbar-brand"><button class="btn btn-light" type="button" onclick="logout()">登出</button></li>
                </ul>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">新增分帳系統</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </header>

        <!-- form Section-->
        <section class="page-section" id="form">
            <div class="container">
                <!-- Contact Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <form id="newForm" action="/getEvent" method="POST">
                            @csrf
                            <!-- Date input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="date" name="date" type="date" placeholder="Enter date..." data-sb-validations="required" />
                                <label for="date">日期：</label>
                                <div class="invalid-feedback" data-sb-feedback="date:required">A date is required.</div>
                            </div>
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter name..." data-sb-validations="required" />
                                <label for="name">名稱：</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <!-- Member input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="member" name="member[]" type="text" placeholder="Enter member..." data-sb-validations="required" />
                                <label for="member">成員：</label>
                                <div class="invalid-feedback" data-sb-feedback="member:required">A member is required.</div>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input class="form-control" name="member[]" type="text" placeholder="Enter member..." data-sb-validations="required" />
                                <label for="member">成員：</label>
                                <div class="invalid-feedback" data-sb-feedback="member:required">A member is required.</div>
                            </div>
                            
                            <div id="newMember">
                                <button id="addMember" type="button" class="btn btn-primary btn-circle btn-lg">+</button>
                            </div><br><br>

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
                            <div><input class="btn btn-primary" id="submit" type="submit" value="Send"></div>
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
        <script>
            $('#addMember').click(function(){
                $('#newMember').prepend(`
                    <div class="form-floating mb-3">
                        <input class="form-control" name="member[]" type="text" placeholder="Enter member..." data-sb-validations="required" />
                        <label for="member">成員：</label>
                        <div class="invalid-feedback" data-sb-feedback="member:required">A member is required.</div>
                    </div>
                `)
            })
        </script>
        <script>
            function logout(){
                $("#logout").submit();
            }
        </script>
    </body>
</html>
