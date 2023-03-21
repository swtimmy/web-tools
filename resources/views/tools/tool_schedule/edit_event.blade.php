<div class="modal fade" id="modalEditScheduleEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-event-form" action="javascript:void(0)">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <label for="title">Title</label>
                        <input type="name" id="title" name="title" class="form-control validate">
                    </div>
                    <div class="md-form mb-3 recursiveField">
                        <label for="recursive">Repeat</label>
                        <input name="recursive" id="recursive" type="checkbox" data-toggle="toggle" data-width="100%" data-on="Yes" data-off="No">
                    </div>
                    <div class="md-form mb-3 weekdayField">
                        <label for="start_week">Week</label>
                        <div>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='1'autocomplete="off" checked> Mon
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='2' autocomplete="off" checked> Tues
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='3' autocomplete="off" checked> Wed
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='4' autocomplete="off" checked> Thur
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='5' autocomplete="off" checked> Fri
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='6' autocomplete="off" checked> Sat
                                </label>
                                <label class="btn btn-light active">
                                    <input type="checkbox" name="weekday[]" value='7' autocomplete="off" checked> Sun
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="md-form mb-3">
                        <label for="start">Start Time</label>
                        <input type="datetime-local" id="start" name="start" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#start">
                        <input type="time" id="start_time" name="start_time" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#start_time">
                    </div>
                    <div class="md-form mb-3">
                        <label for="end">End Time</label>
                        <input type="datetime-local" id="end" name="end" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#end">
                        <input type="time" id="end_time" name="end_time" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#end_time">
                    </div>
                    <div class="md-form mb-3 beginField">
                        <label for="begin">Begin Date</label>
                        <input type="datetime-local" id="begin" name="begin" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#begin">
                    </div>
                    <div class="md-form mb-3 expireField">
                        <label for="expire">Expire Date</label>
                        <input type="datetime-local" id="expire" name="expire" class="form-control validate datetimepicker-input" data-toggle="datetimepicker" data-target="#expire">
                    </div>
                    <div class="md-form mb-3">
                        <select name="color">
                            <option value="#3a87ad">Default</option>
                            <option value="#7bd148">Green</option>
                            <option value="#5484ed">Bold blue</option>
                            <option value="#a4bdfc">Blue</option>
                            <option value="#46d6db">Turquoise</option>
                            <option value="#51b749">Bold green</option>
                            <option value="#fbd75b">Yellow</option>
                            <option value="#ffb878">Orange</option>
                            <option value="#ff887c">Red</option>
                            <option value="#dc2127">Bold red</option>
                            <option value="#dbadff">Purple</option>
                            <option value="#2e2e2e">Gray</option>
                        </select>
                    </div>
                    <div class="alert alert-success d-none" id="msg_div">
                        <span id="res_message"></span>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" id="start_datetime" name="start_datetime">
                    <input type="hidden" id="end_datetime" name="end_datetime">
                    <input type="hidden" id="rule" name="rule">
                    <input type="hidden" id="id" name="id">
                    <button class="btn btn-deep-orange send-form">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section("js")
    <script>
        $edit_event_form = $("#edit-event-form");
        $edit_event_form.find('select[name="color"]').simplecolorpicker();
        if(!Modernizr.inputtypes['datetime-local']){
            datetime_option = {
                'widgetPositioning':{
                    'vertical':'bottom'
                },
                'useCurrent':true,
                'calendarWeeks':true,
                'allowInputToggle':true,
                'focusOnShow':false,
                'format':'YYYY-MM-DDTHH:mm',
            };
            $edit_event_form.find("input#start").datetimepicker(datetime_option);
            $edit_event_form.find("input#end").datetimepicker(datetime_option);
            $edit_event_form.find("input#expire").datetimepicker(datetime_option);
            $edit_event_form.find("input#begin").datetimepicker(datetime_option);
        }else{
            $edit_event_form.find("input#start").attr("data-toggle",'').removeClass("datetimepicker-input");
            $edit_event_form.find("input#end").attr("data-toggle",'').removeClass("datetimepicker-input");
            $edit_event_form.find("input#expire").attr("data-toggle",'').removeClass("datetimepicker-input");
            $edit_event_form.find("input#begin").attr("data-toggle",'').removeClass("datetimepicker-input");
        }
        if(!Modernizr.inputtypes['time']){
            time_option = {
                'widgetPositioning':{
                    'vertical':'bottom'
                },
                'useCurrent':true,
                'allowInputToggle':true,
                'focusOnShow':false,
                'format': 'LT',
            };
            $edit_event_form.find("input#start_time").datetimepicker(time_option);
            $edit_event_form.find("input#end_time").datetimepicker(time_option);
        }else{
            $edit_event_form.find("input#start_time").attr("data-toggle",'').removeClass("datetimepicker-input");
            $edit_event_form.find("input#end_time").attr("data-toggle",'').removeClass("datetimepicker-input");
        }
        if ($edit_event_form.length > 0) {
            $edit_event_form.validate({
                onfocusout: false,
                onkeyup: false,
                rules: {
                    title: {
                        required: true,
                        maxlength: 50
                    },
                },
                messages: {
                    title: {
                        required: "Please enter Title",
                        maxlength: "Title maxlength should be 50 characters long."
                    },
                },
                showErrors: function(errorMap, errorList) {
                    if(Object.keys(errorMap).length > 0){
                        var err_arr = [];
                        $.each(errorMap,function(i,v){
                            err_arr.push(v);
                        });
                        $edit_event_form.find(".alert").addClass("alert-danger").removeClass("d-none");
                        $edit_event_form.find("#res_message").html(err_arr.join("</br>"));
                        return false;
                    }
                },
                submitHandler: function(form) {
                    $edit_event_form.find(".alert").removeClass("alert-danger").addClass("d-none");
                    editEventSubmit(form);
                }
            });

            function editEventSubmit(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var weekday = $edit_event_form.find('input[name="weekday[]"]:checked').map(function(_, el) {
                    return $(el).val();
                }).get();
                var id = $edit_event_form.find('input[name=id]').val();
                var recursive = ($edit_event_form.find('input[name="recursive"]:checked').length>0)?true:false;
                var start = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=start]').val()))/1000;
                var end = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=end]').val()))/1000;
                var begin = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=begin]').val()))/1000;
                var expire = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=expire]').val()))/1000;
                var start_time = convertTime12hTo24h($edit_event_form.find('input[name=start_time]').val());
                var end_time = convertTime12hTo24h($edit_event_form.find('input[name=end_time]').val());
                var start_time_int = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=start_time]').val()))/1000;
                var end_time_int = new Date(getFullTimeFormatWithYYYYMMDDhhmm($edit_event_form.find('input[name=end_time]').val()))/1000;
                var title = $edit_event_form.find('input[name=title]').val();
                var color = $edit_event_form.find('select[name=color]').val();
                var rule = $edit_event_form.find('input[name=rule]').val();
                if(recursive){
                    if(isNaN(begin)||isNaN(expire)||start_time==''||end_time==''){
                        msg_fail('Input valid time');
                        return;
                    }
                    if(begin>=expire||start_time_int>=end_time_int){
                        msg_fail('Begin Date/Start Time cannot behind the Expire Date/End Time');
                        return;
                    }
                    if(end_time == "00:00"){
                        end_time = "23:59";
                    }
                }else{
                    if(isNaN(start)||isNaN(end)){
                        msg_fail('Input valid time');
                        return;
                    }
                    if(start>=end){
                        msg_fail('Start Time cannot behind the End Time');
                        return;
                    }
                }
                $.ajax({
                    url: './editScheduleEvent' ,
                    type: "POST",
                    dataType: 'json',
                    data: {
                        "id":id,
                        "title":title,
                        "weekday":weekday,
                        "start":start,
                        "end":end,
                        "start_time":start_time,
                        "end_time":end_time,
                        "begin":begin,
                        "expire":expire,
                        "color":color,
                        "recursive":recursive,
                        "rule":rule,
                    },
                    beforeSend:function(XMLHttpRequest){
                        $edit_event_form.find('.send-form').html('Sending..').addClass("disabled").prop('disabled', true);
                    },
                    success: function( response ) {
                        if(response.status==200){
                            $edit_event_form.find('.alert').addClass("alert-success").addClass("d-none");
                            // form.reset();
                            updateEvent(pending_event,response.data);
                            $("#modalEditScheduleEvent").modal('hide');
                        }else{
                            var err_html = "Fail";
                            if(Object.keys(response.message).length > 0){
                                err_arr = [];
                                $.each(response.message,function(i,v){
                                    err_arr.push(v[0]);
                                });
                                err_html = err_arr.join("</br>");
                            }
                            $edit_event_form.find('.alert').addClass("alert-danger").removeClass("d-none");
                            $edit_event_form.find('#res_message').html(err_html);
                        }
                        $edit_event_form.find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
                    },
                    error: function (request, status, error) {
                        $edit_event_form.find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
                        $edit_event_form.find('#res_message').html("Ajax Error:101");
                    }
                });
            }
            function dragEditEventSubmit(data,event,calendar){
                var addEvent = new ajaxCall();
                addEvent.send('./editScheduleEvent','post',data,null,
                    function(res){
                        updateEvent(event,res.data);
                    }
                )
            }
        }
        $(function(){
            $(document).on('change',$edit_event_form.find('input[name=recursive]'),function(){
                updateEditEventTimeField();
            });
        });
        function resetEditEventForm(){
            pending_event = { id: '', resourceId: id, start: '', end: '', title: '' };
            $edit_event_form.find("input[name=title]").val('');
            $edit_event_form.find("input[name=recursive]").prop('checked',false);
            updateEditEventTimeField()
            $edit_event_form.find(".recursiveField .toggle").addClass("btn-default off").removeClass("btn-primary");
        }
        function updateEditEventTimeField(){
            if($edit_event_form.find("input[name=recursive]").prop('checked')){
                $edit_event_form.find("input[name=start]").hide();
                $edit_event_form.find("input[name=end]").hide();
                $edit_event_form.find("input[name=start_time]").show();
                $edit_event_form.find("input[name=end_time]").show();
                $edit_event_form.find(".weekdayField").show();
                $edit_event_form.find(".expireField").show();
                $edit_event_form.find(".beginField").show();
            }else{
                $edit_event_form.find("input[name=start]").show();
                $edit_event_form.find("input[name=end]").show();
                $edit_event_form.find("input[name=start_time]").hide();
                $edit_event_form.find("input[name=end_time]").hide();
                $edit_event_form.find(".weekdayField").hide();
                $edit_event_form.find(".expireField").hide();
                $edit_event_form.find(".beginField").hide();
            }
        }
    </script>
@append