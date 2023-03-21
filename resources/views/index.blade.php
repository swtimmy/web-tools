@extends("frontend/content")

<!-- 
Background Class:
bg-primary
bg-secondary
bg-success
bg-danger
bg-warning
bg-info
bg-light
bg-dark 
-->

@section("css")
*{
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    user-select: none;
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
}
i.fa{
    font-size:4rem;
}
.card{
    border:0;
    user-select: none;
}
.main{
    display:flex;
    min-height:100vh;
}
.container{
    align-self:center;
}
a{
    text-decoration:none!important;
}
@media (min-width: 1024px) {
    .card{
        transition: all linear .1s;
    }
    .card:hover{
        transform: scale(1.1);
    }
}
@stop

@section("content")
<div class="main">
    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-dark text-center">SWTimmy Tools</h1>
            </div>
            <div class="col-12 col-sm-6 pt-4">
                <a href="{{url('/grep')}}" target="_blank">
                    <div class="card text-white bg-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-list-alt mb-2" aria-hidden="true"></i>
                            <h1 class="card-title text-center">Grep News</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 pt-4">
                <a href="https://neverj.com" target="_blank">
                    <div class="card text-white bg-secondary">
                        <div class="card-body text-center">
                            <i class="fa fa-safari mb-2" aria-hidden="true"></i>
                            <h1 class="card-title text-center">NeverJ</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 pt-4">
                <a href="{{url('/dictionary')}}" target="_blank">
                    <div class="card text-white bg-success">
                        <div class="card-body text-center">
                            <i class="fa fa-book mb-2" aria-hidden="true"></i>
                            <h1 class="card-title text-center">Dictionary</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 pt-4">
                <a href="{{url('/schedule')}}" target="_blank">
                    <div class="card text-white bg-info">
                        <div class="card-body text-center">
                            <i class="fa fa-table mb-2" aria-hidden="true"></i>
                            <h1 class="card-title text-center">Schedule</h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@append

