@if (isset($user_email))
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <h3 style="margin:0;">
                @yield("title")
            </h3>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsMobile" aria-controls="navbarsMobile" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{--desktop--}}
        <div class="navbar-collapse collapse desktop" id="navbarsDesktop" style="">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="nav-link">Hi {{$user_email}}</span></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown03">
                        <a class="dropdown-item" href="./schedule">
                            <i class="fa fa-calendar-alt" aria-hidden="true"></i> Schedule
                        </a>
                        <a class="dropdown-item" href="./dictionary">
                            <i class="fa fa-book" aria-hidden="true"></i> Dictionary
                        </a>
                        <a class="dropdown-item" href="./dictionaryPractice">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Dictionary Practice
                        </a>
                        <a class="dropdown-item" href="./dictionaryPracticeList">
                            <i class="fa fa-folder-open" aria-hidden="true"></i> Dictionary Practice Result
                        </a>
                        <a class="dropdown-item" href="./grep" target="_blank">
                            <i class="fa fa-newspaper" aria-hidden="true"></i> Grep News
                        </a>
                        <a class="dropdown-item" href="./login">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Sign-Out
                        </a>
                    </div>
                </li>
                {{--<li class="nav-item">--}}
                {{--<span class="nav-link">Hi {{$user_email}}</span>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="./login" class="nav-link">--}}
                        {{--<i class="fa fa-sign-out" aria-hidden="true"></i>Sign-Out--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item dropdown">--}}
                    {{--<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>--}}
                    {{--<div class="dropdown-menu" aria-labelledby="dropdown03">--}}
                        {{--<a class="dropdown-item" href="#">Action</a>--}}
                        {{--<a class="dropdown-item" href="#">Another action</a>--}}
                        {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
            </ul>
        </div>
        {{--mobile--}}
        <div class="navbar-collapse collapse mobile" id="navbarsMobile" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <span class="nav-link">Hi {{$user_email}}</span>
                </li>
                <li class="nav-item">
                    <a href="./schedule" class="nav-link">
                        <i class="fa fa-calendar-alt" aria-hidden="true"></i> Schedule
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./dictionary" class="nav-link">
                        <i class="fa fa-book" aria-hidden="true"></i> Dictionary
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./dictionaryPractice" class="nav-link">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Dictionary Practice
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./dictionaryPracticeList" class="nav-link">
                        <i class="fa fa-folder-open" aria-hidden="true"></i> Dictionary Practice Result
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./grep" target="_blank" class="nav-link">
                        <i class="fa fa-newspaper" aria-hidden="true"></i> Grep News
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./login" class="nav-link">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>Sign-Out
                    </a>
                </li>
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="dropdown03">--}}
                {{--<a class="dropdown-item" href="#">Action</a>--}}
                {{--<a class="dropdown-item" href="#">Another action</a>--}}
                {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                {{--</div>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
@else
    {{--no thing--}}
@endif