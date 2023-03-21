<div class="modal fade" id="modalSelectRule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Select Rule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-3">
                    <div class="row modalSelectRule-list">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-primary btn-lg btn-block select-rule-btn">Self</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalScheduleRuleOption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Rule Option</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-3">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-primary btn-lg btn-block option-add-rule">Add</button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-primary btn-lg btn-block option-edit-rule">Edit</button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-danger btn-lg btn-block option-remove-rule">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section("js")
    <script>
        $_modalScheduleRuleOption = $("#modalScheduleRuleOption");
        $_modalSelectRule = $("#modalSelectRule");
        var rule_action = false;
        var EDIT = "edit";
        var REMOVE = "remove";
        var ADD = "add";
        $(".option-add-rule").on('click',function () {
            $_modalScheduleRuleOption.modal("hide");
            $("#modalAddScheduleRule").modal("show");
        });
        $(".option-edit-rule").on('click',function () {
            if(schedule_rule.length<1){
                msg_fail("Error::512");
            }else if(schedule_rule.length == 1){
                var id = schedule_rule[0].id;
                $_modalEditScheduleRule.find('input[name=id]').val(id);
                $_modalScheduleRuleOption.modal("hide");
                $_modalEditScheduleRule.modal("show");
                rule_action = EDIT;
            }else{
                $(".modalSelectRule-list").html('');
                getRuleList(function(){
                    for(var i = 0; i < schedule_rule.length; i++){
                        $(".modalSelectRule-list").append("<div class='col-md-6 mb-2'><button class='btn btn-primary btn-lg btn-block select-rule-btn' data-value='"+schedule_rule[i].id+"'>"+schedule_rule[i].title+"</button></div>")
                    }
                    $_modalScheduleRuleOption.modal("hide");
                    $_modalSelectRule.modal("show");
                });
                rule_action = EDIT;
            }
        });
        $(".option-remove-rule").on('click',function () {
            if(schedule_rule.length<1){
                msg_fail("Error::512");
            }else if(schedule_rule.length == 1){
                msg_fail("Make sure you have more than one rule");
            }else{
                $(".modalSelectRule-list").html('');
                getRuleList(function(){
                    for(var i = 0; i < schedule_rule.length; i++){
                        $(".modalSelectRule-list").append("<div class='col-md-6 mb-2'><button class='btn btn-primary btn-lg btn-block select-rule-btn' data-value='"+schedule_rule[i].id+"'>"+schedule_rule[i].title+"</button></div>")
                    }
                    $_modalScheduleRuleOption.modal("hide");
                    $_modalSelectRule.modal("show");
                });
                rule_action = REMOVE;
            }
        });
        $(document).on('click','.select-rule-btn',function(){
            $_modalSelectRule.modal("hide");
            var id = $(this).attr("data-value");
            pending_rule = calendar.getResourceById(id)
            if(rule_action == EDIT){
                $_modalEditScheduleRule.find('input[name=id]').val(pending_rule.id);
                $_modalEditScheduleRule.find('input[name=name]').val(pending_rule.title);
                $_modalEditScheduleRule.modal("show");
                pending_rule = '';
            }else if(rule_action == REMOVE){
                $_modalRemoveScheduleRule.modal("show");
            }
            rule_action = false;
        });
    </script>
@append