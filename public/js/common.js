function msg_ok(txt="Success"){
    nativeToast({
        message: txt,
        type: 'success',
    })
}
function msg_fail(txt="Error"){
    nativeToast({
        message: txt,
        type: 'error',
    })
}
function loading(bool=true){
    if(bool){
        $(".loading").addClass("active");
    }else{
        $(".loading").removeClass("active");
    }
}
function goBack(){
    if(1 < history.length) {
        history.back();
    }else{
        window.location = "./";
    }
}
function refresh(){
    window.location.reload();
    scrollTop();
}
function scrollTop(){
    $("html, body").animate({ scrollTop: 0 }, "fast");
}
function ajaxCall(){
    this.send = function(url=this.url,type=this.type,data=this.data,onerror={},onsuccess={}){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url ,
            type: type,
            data: data,
            beforeSend:function(XMLHttpRequest){
                //
            },
            success: function( response ) {
                if(response.status==200){
                    if (typeof onsuccess === "function") {
                        onsuccess(response);
                    }
                }else{
                    if (typeof onerror === "function") {
                        onerror(response);
                    }
                }
            },
            error: function (request, status, error) {
                if (typeof onerror === "function") {
                    onerror();
                }
            }
        });
    }
}
function ajaxForm($form){
    this.form_id = $form;
    this.form_ele = null;
    this.validate_rule = {};
    this.validate_message = {};
    this.validate_onerror = {};
    this.validate_onsuccess = {};
    this.form_url = './';
    this.form_onerror = {};
    this.form_onsuccess = {};
    this.form_reset = false;
    this.form_redirect = false;
    this.set_validate = function(rule={},message={},onerror={},onsuccess={}){
        this.validate_rule = rule;
        this.validate_message = message;
        this.validate_onerror = onerror;
        this.validate_onsuccess = onsuccess;
        this.validate();
    };
    this.send = function(){
        this.validate();
    },
    this.set_form = function(url=this.form_url,onerror={},onsuccess={},resetForm=this.form_reset,redirect=this.form_redirect){
        this.form_url = url;
        this.form_onerror = onerror;
        this.form_onsuccess = onsuccess;
        this.form_reset = resetForm;
        this.form_redirect = redirect;
    };
    this.validate = function(rule=this.validate_rule,message=this.validate_message,onerror=this.validate_onerror,onsuccess=this.validate_onsuccess){
        var self = this;
        $(this.form_id).validate({
            onfocusout: false,
            onkeyup: false,
            rules: rule,
            messages: message,
            showErrors: function(errorMap, errorList) {
                if(Object.keys(errorMap).length > 0){
                    var err_arr = [];
                    $.each(errorMap,function(i,v){
                        err_arr.push(v);
                    });
                    $(self.form_id).find(".alert").addClass("alert-danger").removeClass("d-none");
                    $(self.form_id).find("#res_message").html(err_arr.join("</br>"));
                    if (typeof onerror === "function") {
                        onerror()
                    }
                    return false;
                }
            },
            submitHandler: function(form) {
                $(self.form_id).find(".alert").removeClass("alert-danger").addClass("d-none");
                if (typeof onsuccess === "function") {
                    onsuccess()
                }
                self.form_ele = form;
                self.submit()
            }
        });
    };
    this.submit = function(url=this.form_url,onerror=this.form_onerror,onsuccess=this.form_onsuccess,reset=this.form_reset,redirect=this.form_redirect){
        var self = this;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: $(self.form_id).serialize(),
            beforeSend:function(XMLHttpRequest){
                $(self.form_id).find('.send-form').html('Sending..').addClass("disabled").prop('disabled', true);
            },
            success: function( response ) {
                if(response.status==200){
                    $(self.form_id).find('.alert').addClass("alert-success").removeClass("d-none");
                    if (typeof onsuccess === "function") {
                        onsuccess(response);
                    }
                    if(reset){
                        self.form_ele.reset();
                    }
                    $(self.form_id).find('#res_message').html(response.message);
                    if(redirect){
                        window.location = response.url;
                    }
                }else{
                    var err_html = "Fail";
                    if(typeof response.message === 'object'){
                        console.log(response.message)
                        err_arr = [];
                        $.each(response.message,function(i,v){
                            err_arr.push(v);
                        });
                        err_html = err_arr.join("</br>");
                    }else if(typeof response.message === 'string'){
                        err_html = response.message;
                    }
                    $(self.form_id).find('.alert').addClass("alert-danger").removeClass("d-none");
                    $(self.form_id).find('#res_message').html(err_html);
                    if (typeof onerror === "function") {
                        onerror(response);
                    }
                    msg_fail("Status::400");
                }
                $(self.form_id).find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
            },
            error: function (request, status, error) {
                var self = this;
                $(self.form_id).find('.send-form').html('Submit').removeClass("disabled").prop('disabled', false);
                $(self.form_id).find('#res_message').html("Ajax Error::101");
                msg_fail("Ajax Error::0001:")
            }
        });
    }

}
function resetForm($form){
    $form.find("input, select, textarea").val("");
    $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
    $form.find("select").trigger("change");
    $form.find(".alert").addClass('d-none');
}