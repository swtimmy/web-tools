
<div class="modal fade" id="modalRemoveScheduleRule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Remove Rule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-primary btn-lg btn-block cancel-remove-rule">Cancel</button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-danger btn-lg btn-block confirm-remove-rule">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section("js")
    <script>
        $_modalRemoveScheduleRule = $("#modalRemoveScheduleRule");
        $(".cancel-remove-rule").on('click',function(){
            $_modalRemoveScheduleRule.modal("hide");
            pending_event = '';
        });
        $(".confirm-remove-rule").on('click',function(){
            removeRuleSubmit(pending_rule.id)
        });
        function removeRuleSubmit(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: './removeScheduleRule' ,
                type: "POST",
                data: {
                    'id':id,
                },
                beforeSend:function(XMLHttpRequest){

                },
                success: function( response ) {
                    $_modalRemoveScheduleRule.modal("hide");
                    getRuleList();
                    getEventList();
                    pending_event = '';
                },
                error: function (request, status, error) {

                }
            });
        }
    </script>
@append