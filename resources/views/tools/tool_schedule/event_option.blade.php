
<div class="modal fade" id="modalScheduleEventOption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Event Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="pb-2 pt-2">
                    <div class="row">
                        <div class="col-2">
                            <h5>Title:</h5>
                        </div>
                        <div class="col-10">
                            <span class="title"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <h5>Time:</h5>
                        </div>
                        <div class="col-10">
                            <label class="mb-0"><span class="start"></span></label>
                            to
                            <label class="mb-0"><span class="end"></span></label>
                            <label class="mb-0"><span class="day"></span></label>
                        </div>
                    </div>
                </div>
                <div class="md-form mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-primary btn-lg btn-block option-edit-event">Edit</button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-danger btn-lg btn-block option-remove-event">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section("js")
    <script>
        $(function(){
            $("#modalScheduleEventOption button.close").on('click', function(){
                pending_event = null;
            });
        });
        $(".option-edit-event").on('click',function () {
            if(typeof pending_event === "undefined" || typeof pending_event.id === "undefined"){
                msg_fail("Please Select Valid Event");
                return false;
            }
            $("#modalScheduleEventOption").modal("hide");
            var $obj = $("#modalEditScheduleEvent");
            loading(true);
            var getEvent = new ajaxCall();
            var data = pending_event;
            data['offset'] = getTimezoneOffset();
            getEvent.send('./getScheduleEvent','post',data,null,
                function(res){
                    var data = res.message[0];
                    $edit_event_form.find('select[name="color"]').val(data.color);
                    $edit_event_form.find('input[name=title]').val(data.title);
                    $edit_event_form.find('input[name=rule]').val(data.resourceId);
                    $edit_event_form.find('input[name=id]').val(data.id);
                    $.each($edit_event_form.find('input[name="weekday[]"]'),function(i,v){
                        $(v).prop('checked',false).parent("label").removeClass("active");
                    });
                    var recursive = false;
                    if(data.recursive==2){
                        recursive = true;
                        $edit_event_form.find('input[name=start_time]').val(data.startTime)
                        $edit_event_form.find('input[name=end_time]').val(data.endTime)
                        $edit_event_form.find('input[name=begin]').val(data.startRecur.substring(0, 16))
                        $edit_event_form.find('input[name=expire]').val(data.endRecur.substring(0, 16))
                        data['daysOfWeek'] = data['daysOfWeek'].replace('0','7')
                        var weekday = data['daysOfWeek'].split(",");
                        $.each($edit_event_form.find('input[name="weekday[]"]'),function(i,v){
                            if(weekday.includes($(v).val())){
                                $(v).prop("checked",true).parent("label").addClass("active");
                            }
                        });
                    }else{
                        $edit_event_form.find('input[name=start]').val(data.start.substring(0, 16))
                        $edit_event_form.find('input[name=end]').val(data.end.substring(0, 16))
                    }
                    $edit_event_form.find('input[name=recursive]').prop('checked',recursive);
                    $edit_event_form.find('input[name=recursive]').trigger('change');
                    $.each($edit_event_form.find('.simplecolorpicker span'),function(i,v){$(v).removeAttr('data-selected')});
                    $edit_event_form.find('span[data-color="'+data.color+'"]').attr('data-selected',true);
                    updateEditEventTimeField();
                    $obj.modal("show");
                    loading(false);
                }
            )
        });
        $(".option-remove-event").on('click',function () {
            if(typeof pending_event === "undefined" || typeof pending_event.id === "undefined"){
                msg_fail("Please Select Valid Event");
                return false;
            }
            $("#modalScheduleEventOption").modal("hide");
            $("#modalRemoveScheduleEvent").modal("show");
        })
    </script>
@append