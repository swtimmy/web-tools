<div class="modal fade" id="modalEditText" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-text-form" action="javascript:void(0)">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Edit DICTIONARY</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <label for="text">Text</label>
                        <input type="text" id="text" name="text" class="form-control validate">
                    </div>
                    <div class="md-form mb-3">
                        <label for="text">Description</label>
                        <textarea id="desc" name="desc" class="form-control validate"></textarea>
                    </div>
                    <div class="alert alert-success d-none" id="msg_div">
                        <span id="res_message"></span>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <input type="hidden" name="dictionary" id="dictionary" value=""/>
                    <button class="btn btn-deep-orange send-form">Change</button>
                    <div class="btn btn-deep-orange remove-form">Remove</div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalRemoveText" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Remove Dictionary</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-primary btn-lg btn-block cancel-remove-dictionary">Cancel</button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-danger btn-lg btn-block confirm-remove-dictionary">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section("css")
    <style>
        .remove-form{
            color:#e43330;
        }
    </style>
@append

@section("js")
    <script>
        var $_modalEditText = $("#modalEditText");
        var $_modalRemoveText = $("#modalRemoveText");
        $edit_text_form = $("#edit-text-form");
        $(function(){
            $editText = new ajaxForm($edit_text_form);
            $editText.set_validate(
                {
                    text:{
                        required: true
                    },
                    desc:{
                        required: true
                    },
                    dictionary:{
                        required: true
                    }
                },
                {
                    text: {
                        required: "Please enter Text",
                    },
                    desc: {
                        required: "Please enter Description",
                    },
                    dictionary:{
                        required: "Please Reload this Page",
                    }
                },
                {},{}
            );
            $editText.set_form("./editDictionary",{},function(e){
                var dictionary = $edit_text_form.find("input#dictionary").val();
                var text = $edit_text_form.find("input#text").val();
                var desc = $edit_text_form.find("textarea#desc").val();
                $("div.btn.edit[data-value="+dictionary+"]").parents("tr").find("td").eq(0).html(text);
                $("div.btn.edit[data-value="+dictionary+"]").parents("tr").find("td").eq(1).html(desc.nl2str(";<br>"));
                $_modalEditText.modal('hide');
            },true,false);
            $editText.send();

        });
        $(".remove-form").on("click",function(){
            $_modalRemoveText.modal("show");
        });
        $(".cancel-remove-dictionary").on('click',function(){
            $_modalRemoveText.modal("hide");
        });
        $(".confirm-remove-dictionary").on('click',function(){
            $_modalRemoveText.modal("hide");
            var dictionary = $edit_text_form.find("input#dictionary").val();
            $removeText = new ajaxCall();
            $removeText.send('./removeDictionary','POST',{'dictionary':dictionary},function(e){
                msg_fail(e.message);
            },function(e){
                $("div.btn.edit[data-value="+dictionary+"]").parents("tr").addClass("deleted");
                $("div.btn.edit[data-value="+dictionary+"]").remove();
                $_modalEditText.modal('hide');
                msg_ok(e.message);
            });
        });
        $(document).on("click",".edit",function(){
            loading(true);
            var dictionary = $(this).attr('data-value');
            $getEditText = new ajaxCall();
            $getEditText.send('./getDictionary','POST',{'dictionary':dictionary},function(e){
                msg_fail(e.message);
            },function(e){
                $edit_text_form.find("input#text").val(e.message.text);
                $edit_text_form.find("textarea#desc").val(e.message.description);
                $edit_text_form.find("input#dictionary").val(e.message.dictionary);
                loading(false);
                $_modalEditText.modal("show");
                setTimeout(function() {
                    $edit_text_form.find("input[id=text]").focus();
                },500);
            });
        });
        $_modalEditText.on('hide.bs.modal', function(){
            resetForm($_modalEditText);
        });

    </script>
@append