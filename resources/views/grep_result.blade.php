<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Grep Result</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="/css/app.css" rel="stylesheet">
        <link href="/packages/native-toast/native-toast.css" rel="stylesheet">
        <meta name="csrf-token" content="{!! csrf_token() !!}">

        <meta name="viewport" content="width=device-width, user-scalable=no" />

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .list{
                display:block;
            }
            .list-item{
                padding:5px;
            }
            .list-item-content{
                margin:10px;
                box-shadow: 0 0 3px 1px #000;
                padding: 10px;
            }
            a{
                color:#636b6f;
                text-decoration: none;
            }
            a:hover{
                text-decoration: none;
            }
            .list-grid:after {
                content: '';
                display: block;
                clear: both;
            }
            .tool{
                padding:0 15px;
            }
            .tool.stick{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: #fff;
                z-index: 1;
                padding: 15px;
                padding-bottom: 0px;
            }
            .tool.stick + .list{
                margin-top: 53px;
            }
            .native-toast-bottom.native-toast-shown{
                display: flex;
                justify-content: center;
                align-items: center;
                align-content: center;
            }
            [class^="native-toast-icon-"]{
                display: flex;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title">
                Grep
            </div>
            <div class="tool">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Search</span>
                    </div>
                    <input type="text" class="form-control quicksearch" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>
            <div class=" list">
                <div class="list-grid">
                    {{--@if ($posts)--}}
                        {{--@foreach ($posts as $key=>$val)--}}
                            {{--<div class="list-item col-md-4">--}}
                                {{--<div class="list-item-content">--}}
                                    {{--<div><a href="{{$val->url}}" target="_blank">{{$val->title}}</a></div>--}}
                                    {{--@if($val->post_time)--}}
                                        {{--<div>{{\Carbon\Carbon::parse($val->post_time)->setTimezone('+8:00')->format('Y-m-d H:i:s')}}</div>--}}
                                    {{--@else--}}
                                        {{--<div>Before 2020-01-02</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--@else--}}
                        {{----}}
                    {{--@endif--}}
                </div>
            </div>
            <div class="get_more" style="padding:10px 20px; text-align: center;cursor: pointer;">
                <h3>Loading...</h3>
            </div>
        </div>
    </body>
    <script src="/js/app.js"></script>
    <script src="/js/number.js"></script>
    <script src="/js/time.js?1"></script>
    <script src="/packages/native-toast/native-toast.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/isotope/isotope.min.js"></script>
    <script>
        // quick search regex
        var qsRegex;
        var str = {
            startAfterCleanKeyword : "Start Load After Clean Keyword",
            clickToMore : "Click To More",
            clickToRetry : "Load Fail, Click to Retry",
            loading : "Loading...",
            retryAfter5s : "Connection Fail, Retry After 5 Seconds",
        };

        // init Isotope
        var $grid = $('.list-grid').isotope({
            // itemSelector: '.list-item',
            layoutMode: 'masonry',
            filter: function() {
                return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup( debounce( function() {
            qsRegex = new RegExp( $quicksearch.val(), 'gi' );
            $grid.isotope();
            if($(this).val()!=""){
                $(".get_more").find("h3").html(str.startAfterCleanKeyword);
            }else{
                $(".get_more").find("h3").html(str.clickToMore);
            }
        }, 200 ) );

        // debounce so filtering doesn't happen every millisecond
        function debounce( fn, threshold ) {
            var timeout;
            threshold = threshold || 100;
            return function debounced() {
                clearTimeout( timeout );
                var args = arguments;
                var _this = this;
                function delayed() {
                    fn.apply( _this, args );
                }
                timeout = setTimeout( delayed, threshold );
            };
        }

        $(function(){
            var newer,older,loading=true;
            var getNewTimer = 60;
            var getOldDis = $(window).height()/2;

            init();

            function init(){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                getInfo();
            }

            $(window).scroll(function(){
                checkOverTitle();
                checkNearTheEnd();
            });

            $('.get_more').on('click',function(){
                getOld();
            });

            function checkOverTitle(){
                var title_end_y = $(".title").position().top + $(".title").outerHeight() - 15;
                if($(window).scrollTop()>title_end_y){
                    $(".tool").addClass("stick");
                }else{
                    $(".tool").removeClass("stick");
                }
            }
            function checkNearTheEnd(){
                if($('.quicksearch').val()!=""){
                    $(".get_more").find("h3").html(str.startAfterCleanKeyword);
                }else{
                    $(".get_more").find("h3").html(str.loading);
                    if($(window).scrollTop() + $(window).height() > $(document).height() - getOldDis) {
                        getOld();
                    }
                }
            }
            function getInfo(){
                $getInfo = new ajaxCall();
                $getInfo.send("/getGrepInfo","POST",{"k":"c}CDpy>;:6{_ghgkLs6["},
                    function(){
                        msg_fail(str.retryAfter5s);
                        setTimeout(function(){
                            getInfo();
                        },5000);
                    },
                    function(res){
                        newer = res.data.newer;
                        older = res.data.older;
                        loading = false;
                        getGrep();
                        setInterval(function(){
                            getNew();
                        },getNewTimer*1000);
                    });
            }
            function getGrep(){
                $getGrep = new ajaxCall();
                $getGrep.send("/getGrep","POST",{'newer':newer},function(){
                        msg_fail(str.retryAfter5s);
                        setTimeout(function(){
                            getGrep();
                        },5000);
                    },
                    function(res) {
                        newer = res.data.newer;
                        older = res.data.older;
                        insertItem(res.data.post,true);
                    });
            }
            function getNew(){
                $getNew = new ajaxCall();
                $getNew.send("/getGrepNewer","POST",{'newer':newer},function(){
                        location.reload();
                    },
                    function(res) {
                        if(res.data!=''){
                            newer = res.data.newer;
                            insertItem(res.data.post,true);
                        }
                    });
            }
            function getOld(){
                if(loading){
                    return false;
                }
                loading = true;
                $(".get_more").find("h3").html(str.loading);
                $getOld = new ajaxCall();
                $getOld.send("/getGrepOlder","POST",{'older':older},function(){
                        loading = false;
                        $(".get_more").find("h3").html(str.clickToRetry);
                    },
                    function(res) {
                        if(res.data!='') {
                            older = res.data.older;
                            insertItem(res.data.post, false);
                        }
                        loading = false;
                        $(".get_more").find("h3").html(str.clickToMore);
                    });
            }
            function insertItem(data,front=true){
                var post_time_str = "公佈時間：";
                var discovery_time_str = "發現時間：";
                $.each(data,function(i,v){
                    var link = $('<a>', {
                        href: v.url,
                        target: '_blank',
                        html: v.title,
                    }).wrap("<div>");
                    var post_date = $('<div>', {
                        html: post_time_str + getYYYYMMDDHHmmssWithDate(timestampToDate(v.post_time)),
                    });
                    var discovery_date = $('<div>', {
                        html: discovery_time_str + getYYYYMMDDHHmmWithDate(timestampToDate(v.created_time)),
                    });
                    var group = $('<div>',{
                        class: 'list-item-content',
                    });
                    var row = $('<div>',{
                        class: 'list-item col-md-4',
                    });
                    group.append(link).append(post_date).append(discovery_date);
                    row.append(group);
                    if(front){
                        $grid.prepend( row ).isotope( 'prepended', row );
                    }else{
                        $grid.isotope( 'insert', row );
                    }
                });
            }
        });
    </script>
</html>
