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
        <nav class="navbar navbar-expand-lg bg-secondary text-lowercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand">分帳軟體</a>
                <a id="navbarUsername" class="navbar-brand">{{$userName}}</a>
                <a id="navbarEvent" class="navbar-brand">
                    <form id="postEventId" action="/trackSpending" method="POST">
                        @csrf
                        <select class="form-select" id="event" name="event">
                            <option selected disabled>您的紀錄</option>
                            @foreach ($userEvent as $event)
                                <option value="{{$event->id}}">{{$event->event_name}}</option>
                            @endforeach
                        </select>
                    </form>
                </a>
                <form id="logout" action="/logout" method="POST">
                    @csrf
                    <input type="hidden" id="userId" name="userId" value="{{$userId}}">
                    <input type="hidden" id="token" name="token" value="{{$token}}">
                </form>
                <a id="navbarLogout" class="navbar-brand"><button class="btn btn-light" onclick="logout()">登出</button></a>
            </div>
        </nav>

        <!-- Masthead -->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">新增分帳系統</h2>
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
                        <form id="eventForm" action="/createEvent" method="POST">
                            @csrf
                            <!-- Date input -->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="date" name="date" type="date" placeholder="" required/>
                                <label for="date">日期：</label>
                            </div>

                            <!-- Name input -->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" placeholder="" required/>
                                <label for="name">名稱：</label>
                            </div>

                            <!-- Member inputs -->
                            <div id="memberContainer">
                                <div class="form-floating mb-3 member-entry">
                                    <input class="form-control" name="member[]" type="text" placeholder="" required/>
                                    <label for="member">成員：</label>
                                </div>
                            </div>

                            <button id="addMember" type="button" class="btn btn-primary btn-circle btn-lg" style="margin-bottom: 30px">+</button>

                            <!-- Submit Button -->
                            <div><center><input class="btn btn-primary" id="submit" type="submit" value="Send"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        @extends('footer')
    </body>
</html>
