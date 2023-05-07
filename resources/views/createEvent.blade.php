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
                    <input type="hidden" id="token" name="token" value="{{$token}}">
                </form>
                <ul style="color:white" class="nav navbar-nav navbar-right">
                    <li class="navbar-brand">{{$userName}}</li>&emsp;&emsp;
                    <li class="navbar-brand">
                        <select class="form-select" id="record">
                            <option selected>您的紀錄</option>
                            @foreach ($userEvent as $event)
                            <option value="{{$event->id}}">{{$event->event_name}}</option>
                            @endforeach
                        </select>
                    </li>&emsp;&emsp;
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
                        <form id="eventForm" action="/createEvent" method="POST">
                            @csrf
                            <!-- Date input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="date" name="date" type="date" placeholder="Enter date..." required/>
                                <label for="date">日期：</label>
                            </div>

                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter name..." required/>
                                <label for="name">名稱：</label>
                            </div>

                            <!-- Member input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="member[]" type="text" placeholder="Enter member..." required/>
                                <label for="member">成員：</label>
                            </div>

                            <!-- Member input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="member[]" type="text" placeholder="Enter member..." required/>
                                <label for="member">成員：</label>
                            </div>
                            
                            <div id="newMember"></div>

                            <button id="addMember" type="button" class="btn btn-primary btn-circle btn-lg" style="margin-bottom: 30px">+</button>

                            <!-- Submit Button-->
                            <div><center><input class="btn btn-primary" id="submit" type="submit" value="Send"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        @extends('footer')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $('#addMember').click(function(){
                $('#newMember').prepend(`
                    <div class="form-floating mb-3">
                        <button id="removeMember" type="button" class="btn btn-danger btn-circle btn-lg">-</button>
                        <input class="form-control" name="member[]" type="text" placeholder="Enter member..." required/>
                        <label for="member" style="margin-top: 20px">成員：</label>
                    </div>
                `)
            })

            $('#newMember').on('click', '#removeMember', function() {
                $(this).parent().remove();
            });

            $("#record").change(function(){
                window.location.href = "/trackSpending" + "/" + $(this).val() + "/" + $('#record :selected').text();
            });

            function logout(){
                $("#logout").submit();
            }
        </script>
    </body>
</html>
