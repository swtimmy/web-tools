@extends("tools/tool_content")

@section('title', 'SWT Schedule')

@section("css")
    <link href="/packages/fullcalendar/core/main.css" rel="stylesheet">
    <link href="/packages/fullcalendar/daygrid/main.css" rel="stylesheet">
    <link href="/packages/fullcalendar/timegrid/main.css" rel="stylesheet">
    <link href="/packages/fullcalendar/list/main.css" rel="stylesheet">
    <link href="/packages/jquery-simplecolorpicker-master/jquery.simplecolorpicker.css" rel="stylesheet">
    <link href="/packages/bootstrap-datetimepicker/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="/packages/bootstrap-toggle-master/css/bootstrap-toggle.min.css?v2" rel="stylesheet">
    <style>
        .fc .fc-toolbar .fc-left h2{
            margin-left:0;
        }
        .fc .fc-toolbar .fc-prevc-button{
            margin-right: .75em;
        }
        .fc-icon{
            font-family: FontAwesome!important;
        }
        .fc-icon.fc-icon-chevron-right:before{
            content:"\f105";
        }
        .fc-icon.fc-icon-chevron-left:before{
            content:"\f104";
        }
        .fc-button-primary {
            color: #fff;
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        .fc-button-primary:disabled {
            color: #fff;
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        .fc-button-primary:not(:disabled):active, .fc-button-primary:not(:disabled).fc-button-active {
            color: #fff;
            background-color: #1a252f;
            border-color: #151e27;
        }
        .fc-timeGrid-view .fc-body{
            background: #ddd;
        }
        .fc-timeGrid-view .fc-day-grid{
            background: #fff;
            display:none; /*todo::all day*/
        }
        .fc-time-grid{
            background: #fff;
            min-height:initial;
        }
        #external-events {
            float: left;
            width: 100%;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #eee;
            text-align: left;
        }
        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
        }
        #external-events .fc-event {
            margin: 10px 0;
            padding:5px;
            cursor: pointer;
        }
        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }
        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }
        #calendar {
            float: right;
            width: 100%;
        }
        .event-red{
            background: #ff887c;
        }
        .event-orange{
            background: #ffb878;
        }
        .event-green{
            background: #51b749;
        }
        .event-blue{
            background: #5484ed;
        }
        .event-brown{
            background: #2e2e2e;
        }
        .event-purple{
            background: #a900ff;
        }
        .fc-content{
            color:#fff;
        }
        .simplecolorpicker.icon, .simplecolorpicker span.color{
            width:30px;
            height:30px;
            border-width: 3px;
        }
        .simplecolorpicker span.color:hover, .simplecolorpicker span.color[data-selected], .simplecolorpicker span.color[data-selected]:hover{
            border-width: 3px;
        }
        .addScheduleEventBtn{
            position: fixed;
            bottom:80px;
            right:10px;
            display:flex;
            justify-content: center;
            align-content: center;
            z-index: 1;
            width: 80px;
            height: 80px;
            background: #ff78008a;
            border-radius: 100px;
            cursor: pointer;
        }
        .addScheduleEventBtn:hover{
            background: #ff7800;
        }
        .addScheduleEventBtn span{
            color: #fff;
            font-size: 50px;
            display: flex;
            align-items: center;
        }
        .weekday_input{
            padding-left:20px;
            padding-right:5px;
        }
        .btn-group.btn-group-toggle{
            display:flex;
        }
        .btn-group-toggle.btn-group>.btn{
            flex:1;
        }
        .btn-group-toggle .btn{
            opacity: 0.6;
            padding: .375rem 0;
        }
        .btn-group-toggle .btn.active{
            opacity: 1;
        }
        .fc-day-header.fc-today{
            background: #75808c;
            color: #fff;
        }
        @media (max-width: 1024px) {
            #external-events{
                display: none;
            }
        }
        body{
            overflow: hidden;
        }
    </style>
@stop

@section("js")
    <script src="/packages/fullcalendar/core/main.js"></script>
    <script src="/packages/fullcalendar/daygrid/main.js"></script>
    <script src="/packages/fullcalendar/timegrid/main.js"></script>
    <script src="/packages/fullcalendar/list/main.js"></script>
    <script src="/packages/fullcalendar/interaction/main.js"></script>
    <script src="/packages/fullcalendar/moment/main.js"></script>
    <script src="/packages/fullcalendar/moment-timezone/main.js"></script>
    <script src="/packages/fullcalendar/resource-common/main.min.js"></script>
    <script src="/packages/fullcalendar/resource-daygrid/main.min.js"></script>
    <script src="/packages/fullcalendar/resource-timegrid/main.min.js"></script>
    <script src="/packages/jquery-simplecolorpicker-master/jquery.simplecolorpicker.js"></script>
    <script src="/packages/moment/moment.js?v1"></script>
    <script src="/packages/bootstrap-datetimepicker/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/packages/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
    <script src="/js/time.js?{{time()}}"></script>

    <script>
        var pending_event;
        var pending_rule;
        var schedule_rule = [];
        var initialTimeZone = 'local';
        var timeZoneSelectorEl = document.getElementById('time-zone-selector');
        var eventStartAt = 0;
        var eventEndTo = 0;
        var eventOnYear = 0;
        var calendarInited = false;
        var uCHeight = {};

        var pending = "PENDING";
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;
        var containerEl = document.getElementById('external-events');
        new Draggable(containerEl, {
            itemSelector: '.fc-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText.trim(),
                    color: ($(eventEl).attr('data-color')!='')?$(eventEl).attr('data-color'):"#3788d8",
                    id: pending,
                }
            }
        });

        var calendarEl = document.getElementById('calendar');

        var zoom_arr = ["00:15","00:30","01:00","02:00"];
        var zoom_level = 2;
        var now_hhmm = getHHmmWithDate(new Date());
        if(now_hhmm > "01:00" && now_hhmm < "23:00"){
            var earlyAnHour = timestampToDate(getTimestampWithHHmm(now_hhmm)-3600);
            now_hhmm = getHHmmWithDate(earlyAnHour);
        }
        var time_diff = 8*3600;

        function updateEvent(event,data=false){
            if(event){
                var current_event = calendar.getEventById(event.id);
                if(current_event){
                    current_event.remove();
                    var bug_event = calendar.getEventById(event.id);
                    if(bug_event){
                        bug_event.remove();
                    }
                }
            }
            if(data){
                var update_event = {};
                update_event['id']='none';
                update_event['title']='none';
                update_event['resourceID']="1";
                $.each(data,function(i,v){
                    update_event[i] = v;
                });
                calendar.addEventSource([update_event]);
            }
        }
        function getEventList(){
            eventOnYear = calendar.getDate().getFullYear();
            eventStartAt = getTimestampWithDate(parseInt(eventOnYear-1)+"-12-01 00:00:00");
            eventEndTo = getTimestampWithDate(parseInt(eventOnYear+1)+"-01-31 23:59:59");
            var getEvent = new ajaxCall();
            getEvent.send('./getScheduleEvents','post',{
                    'getStart':eventStartAt,
                    'getEnd':eventEndTo
                }, null,
                function(res){
                    calendar.removeAllEventSources()
                    var events = [];
                    $.each(res.message,function(i,v){
                        events.push(v);
                    });
                    calendar.addEventSource(events)
                    $(".fc-right").css({'display':'flex'});
                    loading(false);
                }
            );
        }
        function getRuleList(callback=null){
            var getRule = new ajaxCall();
            schedule_rule = [];
            getRule.send('./getScheduleRule','post',null, null,
                function(res){
                    $.each(calendar.getResources(),function(index,rule){
                        rule.remove();
                    });
                    $.each(res.message,function(i,v){
                        v.title = v.title.charAt(0).toUpperCase() + v.title.slice(1);
                        schedule_rule.push(v);
                        calendar.addResource(v);
                    });
                    if (typeof callback === "function") {
                        callback();
                    }
                }
            );
        }
        function changeTimeDist(){
            zoom_level++;
            if(zoom_level>=zoom_arr.length){
                zoom_level = 0;
            }
            calendar.setOption('slotDuration',zoom_arr[zoom_level]);
            $(".fc-right").css({'display':'flex'});
        }
        function editRule(){
            $("#modalScheduleRuleOption").modal("show");
        }
        var click_start = 0;
        $(document).on("touchstart",".fc-event",function(){
            click_start = new Date()/1000;
        });
        function buttonClick(){
            $("#modalScheduleRuleOption").modal("show");
        }
        var calendar = new Calendar(calendarEl, {
            timeZone: 'local',
            plugins: [ 'momentTimezone', 'interaction', 'dayGrid', 'timeGrid', 'list', 'resourceTimeGrid'],
            // now: '2019-02-07',
            editable: true, // enable draggable events
            droppable: true, // this allows things to be dropped onto the calendar
            firstDay: 1,
            // aspectRatio: 1.8,
            //scrollTime: '08:00', // undo default 6am scrollTime
            scrollTime: now_hhmm,
            weekNumberTitle: "W",
            customButtons: {
                zoomc: {
                    text: 'Zoom',
                    click: function() {
                        changeTimeDist()
                    }
                },
                rulec: {
                    text: 'Rule',
                    click: function(){
                        editRule()
                    }
                }
            },
            selectable: true,
            selectLongPressDelay:1000,
            eventLongPressDelay:1000,
            longPressDelay:1000,
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            header: {
                left: 'title',
                center: 'w',
                right: 'prev,today,next rulec,zoomc resourceTimeGridDay,timeGridWeek,dayGridMonth,listWeek',
            },
            defaultView: 'timeGridWeek',
            slotDuration: zoom_arr[zoom_level], //'00:15:00'
            slotLabelInterval:'01:00',
            resourceLabelText: 'Rooms',
            resources: [],
            events: [],
            views:{
                dayGrid: {
                    eventTimeFormat: {
                        hour: 'numeric',
                        minute: '2-digit',
                        omitZeroMinute: true,
                        meridiem: 'short'
                    },
                },
                resourceTimeGrid: {
                    titleFormat: { year: 'numeric', month: 'short', day: 'numeric' }
                }
            },
            loading: function(bool) {
                // document.getElementById('loading').style.display =
                //     bool ? 'block' : 'none';
            },
            select: function(arg){
                pending_event = false;
                extraEventArg = arg;
                selectEventRule();
            },
            drop: function(arg) {
                console.log('drop date: ' + arg.dateStr)
                if (arg.resource) {
                    console.log('drop resource: ' + arg.resource.id)
                }
            },
            eventReceive: function(arg) { // called when a proper external event is dropped
                pending_event = false;
                var start = getTimestampWithDate(arg.event.start);
                var end = start + 60 * 60;
                if(arg.event.allDay){
                    end = start + (24 * 3600) - 1;
                }
                var data = {
                    'title':arg.event.title,
                    'start':start,
                    'end':end,
                    'color':arg.event.backgroundColor,
                    'allDay':arg.event.allDay,
                    'recursive':false,
                    'rule':(arg.event.getResources()[0])?arg.event.getResources()[0].id:calendar.getResources()[0].id,
                }
                extraEventObject = data;
                pending_event = arg.event;
                selectEventRule();
            },
            eventClick: function(arg){
                pending_event = false;
                var click_end = new Date()/1000;
                if(click_start==0 || click_start+1>click_end){
                    var $_modalScheduleEventOption= $("#modalScheduleEventOption");
                    pending_event = {'id':arg.event.id}
                    $_modalScheduleEventOption.modal("show");
                    $_modalScheduleEventOption.find("span.title").html(arg.event.title);
                    $_modalScheduleEventOption.find("span.day").html("");
                    if(getYYYYMMDDWithDate(arg.event.start)==getYYYYMMDDWithDate(arg.event.end)){
                        $_modalScheduleEventOption.find("span.start").html(getHHmmWithDate(arg.event.start));
                        $_modalScheduleEventOption.find("span.end").html(getHHmmWithDate(arg.event.end));
                    }else{
                        $_modalScheduleEventOption.find("span.start").html(getYYYYMMDDHHmmWithDate(arg.event.start));
                        $_modalScheduleEventOption.find("span.end").html(getYYYYMMDDHHmmWithDate(arg.event.end));
                        $_modalScheduleEventOption.find("span.day").html(" ("+getHowLongDayWithStartEndDate(arg.event.start,arg.event.end)+"Days)");
                    }
                }
            },
            eventDrop: function(arg) { // called when an event (already on the calendar) is moved
                pending_event = false;
                var event = arg.event;
                var current = arg.oldEvent;
                var data = {
                    'id':current.id,
                    'title':current.title,
                    'allDay':event.allDay,
                    'recursive':false,
                    'rule':(arg.event.getResources()[0])?arg.event.getResources()[0].id:calendar.getResources()[0].id,
                }
                if(current.groupId!=''){
                    if(getYYYYMMDDWithDate(new Date(event.end-1))!=getYYYYMMDDWithDate(current.start)){
                        msg_fail("Recursive Event could not change date.")
                        arg.revert();
                        return false;
                    }
                    data.recursive = true;
                    data.start_time = getHHmmWithDate(event.start);
                    data.end_time = (getHHmmWithDate(current.end)=="23:59")?getHHmmWithDate(new Date(event.end.getTime()+(60*1000))):getHHmmWithDate(event.end);
                }else{
                    data.start = getTimestampWithDate(event.start);
                    data.end = getTimestampWithDate(event.end);
                }
                dragEditEventSubmit(data,arg.event,calendar);
            },
            eventResize: function(arg) { // called when an event (already on the calendar) is moved
                var event = arg.event;
                var current = arg.prevEvent;
                var data = {
                    'id':current.id,
                    'title':current.title,
                    'allDay':event.allDay,
                    'recursive':false,
                    'rule':(arg.event.getResources()[0])?arg.event.getResources()[0].id:calendar.getResources()[0].id,
                }
                if(current.groupId!=''){
                    if(getYYYYMMDDWithDate(new Date(event.end-1))!=getYYYYMMDDWithDate(current.start)){
                        msg_fail("Recursive Event could not change date.")
                        arg.revert();
                        return false;
                    }
                    data.recursive = true;
                    data.start_time = getHHmmWithDate(event.start);
                    console.log(getHHmmWithDate(current.end))
                    data.end_time = (getHHmmWithDate(current.end)=="23:59")?getHHmmWithDate(new Date(event.end.getTime()+(60*1000))):getHHmmWithDate(event.end);
                }else{
                    data.start = getTimestampWithDate(event.start);
                    data.end = getTimestampWithDate(event.end);
                }
                dragEditEventSubmit(data,arg.event,calendar);
            },
            datesRender: function(info){
                console.log(info)
                calendarInited = true;
                if(eventOnYear!=0 && eventOnYear!=calendar.getDate().getFullYear()){
                    loading(true);
                    getEventList();
                }
                if(info.view.type=="resourceTimeGridDay"){
                    $(".fc-left h2").append(" ("+getDayWithDate(info.view.activeStart)+")");
                }
            },
        });
        calendar.render();

        $(function() {
            loading(true);
            getRuleList();
            getEventList();
            function updateCalendarH(){
                var container_padding = $(".container-fluid").innerHeight()-$(".container-fluid").height();
                var h = $(window).height() - $(".info").outerHeight(true) - $("nav").outerHeight(true) - container_padding;
                calendar.setOption('height', h);
            }
            $(window).on('resize',function(){
                updateCalendarH();
            });
            function keepUpdateCalendarH(){
                uCHeight = setInterval(function(){
                    if(calendarInited){
                        updateCalendarH();
                        clearInterval(uCHeight);
                    }
                },500);
            }
            keepUpdateCalendarH();
            $(document).on('click','.fc-right',function(e){
                if($(e.target).attr("class").includes("fc-right")===false && $(e.target).attr("class").includes("fc-zoomc-button")===false){
                    return false;
                }
                $(this).toggleClass('hide');
                keepUpdateCalendarH();
            });
            $(document).on('click','.navbar-toggler',function(){
                keepUpdateCalendarH();
            });
            document.ontouchmove = function(e){ e.preventDefault(); }
        });
    </script>
@append

@section("content")
    <div class="container-fluid">
        <div class="info col-md-12">
            {{--<div class="tool">--}}
                {{--<a href="" class="btn btn-primary addResource" data-toggle="modal" data-target="#modalAddScheduleRule">Add Rule</a>--}}
                {{--<button type="button" class="btn btn-primary removeResource">Remove Rule</button>--}}
            {{--</div>--}}
        </div>
        <div id="external-events" class="col-md-2">
            <h4>Select the schedule cells to add event</h4> Or <h4>Drag drop events to schedule</h4>
            <div class="external-event-list">
                <div class="fc-event ui-draggable ui-draggable-handle" data-color="">Relax</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-red" data-color="#ff887c">Work</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-orange" data-color="#ffb878">Study</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-green" data-color="#51b749">Eat</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-blue" data-color="#5484ed">Sleep</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-purple" data-color="#a900ff">Use Phone</div>
                <div class="fc-event ui-draggable ui-draggable-handle event-brown" data-color="#2e2e2e">Other</div>
            </div>
        </div>
        <div id="calendar" class="col-md-10"></div>


        </div>
    </div>
    @include("tools.tool_schedule.add_event")
    @include("tools.tool_schedule.edit_event")
    @include("tools.tool_schedule.remove_event")
    @include("tools.tool_schedule.event_option")
    @include("tools.tool_schedule.add_rule")
    @include("tools.tool_schedule.edit_rule")
    @include("tools.tool_schedule.remove_rule")
    @include("tools.tool_schedule.rule_option")
    @include("tools.tool_loading")
@stop