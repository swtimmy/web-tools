<div class="modal fade" id="modalAddText" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-text-form" action="javascript:void(0)">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">ADD DICTIONARY</h4>
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
                    <button class="btn btn-deep-orange send-form">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section("js")
    <script>
        var $_modalAddText = $("#modalAddText");
        $create_text_form = $("#create-text-form");
        $(function(){
            $addText = new ajaxForm($create_text_form);
            $addText.set_validate(
                {
                    text:{
                        required: true
                    },
                    desc:{
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
                },
                {},{}
            );
            $addText.set_form("./addDictionary",{},function(e){
                $('tbody').append("<tr>" +
                    "<td>"+e.message.text+"</td>" +
                    "<td>"+e.message.description.nl2str(";<br>")+"</td>" +
                    "<td>" +
                    "<div class='btn edit' data-value='"+e.message.dictionary+"'>" +
                    "<span class='fc-icon fc-icon-edit'></span>" +
                    "</div>" +
                    "</td>" +
                    "</tr>")
                $_modalAddText.modal('hide');
            },true,false);
            $addText.send();

        });
        $(document).on("click",".mybutton,.addDictionaryBtn",function(){
            $_modalAddText.modal("show");
            setTimeout(function() {
                $create_text_form.find("input[id=text]").focus();
            },500);
        });
    </script>
@append