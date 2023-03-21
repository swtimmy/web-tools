<div class="modal fade" id="modalEditScheduleRule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-rule-form" action="javascript:void(0)">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Rule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <label for="title">Title</label>
                        <input type="name" id="name" name="name" class="form-control validate">
                    </div>
                    <div class="alert alert-success d-none" id="msg_div">
                        <span id="res_message"></span>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" id="id" name="id">
                    <button class="btn btn-deep-orange send-form">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section("js")
    <script>
        $_modalEditScheduleRule = $("#modalEditScheduleRule");
        $edit_rule_form = $("#edit-rule-form");
        if ($edit_rule_form.length > 0) {
            $edit_rule_form.validate({
                onfocusout: false,
                onkeyup: false,
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your name maxlength should be 50 characters long."
                    },
                },
                showErrors: function(errorMap, errorList) {
                    if(Object.keys(errorMap).length > 0){
                        var err_arr = [];
                        $.each(errorMap,function(i,v){
                            err_arr.push(v);
                        });
                        $edit_rule_form.find(".alert").addClass("alert-danger").removeClass("d-none");
                        $edit_rule_form.find("#res_message").html(err_arr.join("</br>"));
                        return false;
                    }
                },
                submitHandler: function(form) {
                    $edit_rule_form.find(".alert").removeClass("alert-danger").addClass("d-none");
                    editRuleSubmit(form);
                }
            });

            function editRuleSubmit(form){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: './editScheduleRule' ,
                    type: "POST",
                    data: $edit_rule_form.serialize(),
                    beforeSend:function(XMLHttpRequest){
                        $edit_rule_form.find('.send-form').html('Sending..').addClass("disabled").prop('disabled', true);
                    },
                    success: function( response ) {
                        if(response.status==200){
                            $edit_rule_form.find('.alert').addClass("alert-success").removeClass("d-none");
                            $edit_rule_form.find('#res_message').html("Success");
                            // form.reset();
                            getRuleList();
                            $_modalEditScheduleRule.modal('hide');
                        }else{
                            var err_html = "Fail";
                            if(Object.keys(response.message).length > 0){
                                err_arr = [];
                                $.each(response.message,function(i,v){
                                    err_arr.push(v[0]);
                                });
                                err_html = err_arr.join("</br>");
                            }
                            $edit_rule_form.find(".alert").addClass("alert-danger").removeClass("d-none");
                            $edit_rule_form.find('#res_message').html(err_html);
                        }
                        $edit_rule_form.find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
                    },
                    error: function (request, status, error) {
                        $edit_rule_form.find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
                        $edit_rule_form.find('#res_message').html("Ajax Error:101");
                    }
                });
            }
        }
    </script>
@append