
<div class="modal fade" id="modalRemoveScheduleEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Remove Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-primary btn-lg btn-block cancel-remove-event">Cancel</button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-danger btn-lg btn-block confirm-remove-event">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section("js")
    <script>
        $(".cancel-remove-event").on('click',function(){
            $("#modalRemoveScheduleEvent").modal("hide");
            pending_event = '';
        });
        $(".confirm-remove-event").on('click',function(){
            removeEventSubmit(pending_event.id)
        });
        function removeEventSubmit(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: './removeScheduleEvent' ,
                type: "POST",
                data: {
                    'id':id,
                },
                beforeSend:function(XMLHttpRequest){

                },
                success: function( response ) {
                    if(response.status==200){
                        var current_event = calendar.getEventById(pending_event.id);
                        current_event.remove();
                        $("#modalRemoveScheduleEvent").modal("hide");
                    }else{

                    }
                    pending_event = '';
                },
                error: function (request, status, error) {

                }
            });
        }
    </script>
@append