<!DOCTYPE html>
<html lang="en">
    @extends('header')
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand">分帳軟體</a>
                <form id="logout" action="/logout" method="POST">
                    @csrf
                    <input type="hidden" id="userId" name="userId" value="{{$userId}}">
                    <input type="hidden" id="token" name="token" value="{{$token}}">
                </form>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="navbar-brand">{{$userName}}</li>&emsp;
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/createEvent">首頁</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#member">成員</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#list">金額明細</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#spend">分帳結果</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#createRecord">新增項目</a></li>&emsp;
                        <li class="navbar-brand"><button class="btn btn-light" type="button" onclick="logout()">登出</button></li>
                    </ul>
                </div>
            </div>
        </nav><br><br>

        @if ($errors->count())
            @foreach ($errors->all() as $error)
                <script>alert("{{ $error }}");</script>
            @endforeach
        @endif

        <!-- Masthead-->
        <header class="page-section bg-light mb-0">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Heading-->
                <h1 class="masthead-heading text-uppercase mb-0">{{$eventName}}</h1>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
            </div>
        </header>

        <!-- member Section-->
        <section class="page-section bg-primary text-white mb-0" id="member">
            <div class="container">
                <!-- member Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">成員</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <br><br>
                <!-- member Item -->
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#memberModal">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                                    <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                    <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- list Section-->
        <section class="page-section bg-light mb-0" id="list">
            <div class="container">
                <!-- member Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">金額明細</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <br><br>
                <!-- list Item -->
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#listModal">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- spend Section-->
        <section class="page-section bg-primary text-white mb-0" id="spend">
            <div class="container">
                <!-- spend Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">分帳結果</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <br><br>
                <!-- spend Item -->
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#spendModal">
                            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- createRecord Section-->
        <section class="page-section" id="createRecord">
            <div class="container">
                <!-- createRecord Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">新增項目</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- createRecord Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <form id="newItemForm" action="/createItem" method="POST">
                            @csrf

                            <input class="form-control" id="eventId" name="eventId" type="hidden" value="{{$eventId}}" required/>

                            <!-- Date-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="date" name="date" type="date" placeholder="Enter date..." required/>
                                <label for="date">日期：</label>
                            </div>

                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="item" name="item" type="text" placeholder="Enter item..." required/>
                                <label for="item">名稱：</label>
                            </div>

                            <!-- price input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="price" name="price" type="number" min="1" placeholder="Enter price..." required/>
                                <label for="price">金額：</label>
                            </div>
                            
                            <!-- payer input-->
                            <div class="form-floating mb-3" style="padding-bottom: 8%">
                                <label for="payer">付錢者：</label>
                            </div>
                            <select class="form-select" id="payer" name="payer" required>
                                @foreach ($eventMember as $member)
                                    <option value={{$member['id']}}>{{$member['name']}}</option>
                                @endforeach
                            </select>

                            <!-- average input-->
                            <div class="form-floating mb-3" style="padding-bottom: 8%">
                                <label for="average">分攤者：</label>
                            </div>
                            <select name="average[]" id="average" class="selectpicker" multiple>
                                @foreach ($eventMember as $member)
                                    <option value={{$member['id']}}>{{$member['name']}}</option>
                                @endforeach
                            </select>

                            <!-- Submit Button-->
                            <div><center><input class="btn btn-primary" style="margin-top: 5%" id="submit" type="submit" value="Send"></center></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- member Modal -->
        @extends('viewModal/memberModal')
        <!-- list Modal -->
        @extends('viewModal/listModal')
        <!-- spend Modal -->
        @extends('viewModal/spendModal')

        <!-- Footer-->
        @extends('footer')

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Multi Select-->
        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
        <script>
            function logout(){
                $("#logout").submit();
            }

            new MultiSelectTag('average')  //id
        </script>
    </body>
</html>
