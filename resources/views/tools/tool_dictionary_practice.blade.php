@extends("tools/tool_content")

@section('title', 'SWT Dictionary Practice')

@section("css")
    <style>
        .bg-blue{
            background-color: #007bff;
        }
        .score{
            font-size: 5rem;
        }
        .modal-title{
            padding-left: 28px;
        }
        .detail_link{
            color:#636b6f;
        }
    </style>
@stop

@section("js")
    <script>
        var $_modalResult = $("#modalResult");
        $(function(){
            loading(true);
            $(".goback").on('click',function(){
                goBack();
            });
            $(".refresh").on('click',function(){
                refresh();
            });
            $getPractice = new ajaxCall();
            $getPractice.send('./getPractice','POST',{},
            function(){
               msg_fail("Fail to get practice. Please try again.");
            },
            function(res){
                if(res.status!=200){
                    msg_fail("Fail to get practice. Please try again.");
                    return;
                }
                var count = 0;
                var $questions = $(".questions");
                $.each(res.message,function(i,v){
                    var $question = $questions.find('.question').eq(count++);
                    $question.find("strong").html(v['hint'].nl2str(";<br>"));
                    $question.find("span").html(v['text'].nl2str(";<br>"));
                    $question.find("input").attr("name", v['index']);
                });
                var max = 20;
                if(count<max){
                    for(var i= max; i>count-1; i--){
                        $questions.find('.question').eq(i).remove();
                    }
                }
                if(count==0){
                    msg_fail("Sorry, No Dictionary Word Found.");
                    return;
                }else{
                    $(".date").html(res.start);
                }
                loading(false);
            });
            $(".send").on('click',function(){
                loading(true);
                var data = $("input").serialize();
                $submitPractice = new ajaxCall();
                $submitPractice.send("./submitPractice","POST",data,function(res){
                    if(res){
                        msg_fail(res.message);
                        setTimeout(function(){
                            location.reload();
                        },3000);
                    }else{
                        msg_fail("Fail Submit");
                    }
                    loading(false);
                },function(res){
                    $(".score").html(res.message.marks+"/"+res.message.total);
                    $(".detail_link").attr("href","./dictionaryPracticeResult/"+res.message.source);
                    $_modalResult.modal('show');
                    $(".submitbefore").remove();
                    $(".submitafter").removeClass("hide");
                    loading(false);
                });
            });
        });
    </script>
@append

@section("content")
    <div class="container-fluid">
        <main role="main" class="container">
            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-blue rounded shadow-sm">
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">Practice</h6>
                    <small>Create Date: <span class="date">--</span></small>
                </div>
            </div>
            <form class="ajax" action="javascript:void(0)">
                <div class="questions">
                    @for ($i=1;$i<=20;$i++)
                        <div class="my-3 p-3 bg-white rounded shadow-sm question">
                            <h6 class="border-bottom border-gray pb-2 mb-0">Question {{$i}}</h6>
                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 small lh-125 border-gray">
                                    <strong class="d-block text-gray-dark">******</strong>
                                    <span>Loading...</span>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" class="answer" name="q1" placeholder="Answer Here" autocomplete="off">
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="text-center mb-3 submitbefore">
                    <button class="btn btn-primary btn-lg btn-block send">Submit</button>
                </div>
                <div class="row mb-5 submitafter hide">
                    <div class="col-md-6 mb-3 order-sm-1 order-md-0">
                        <button class="btn btn-secondary btn-lg btn-block goback">Back</button>
                    </div>
                    <div class="col-md-6 mb-3 order-sm-0 order-md-1">
                        <button class="btn btn-success btn-lg btn-block refresh">New Practice</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <div class="modal fade" id="modalResult" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="create-text-form" action="javascript:void(0)">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Result</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3 text-center">
                        <h1 class="score">?/?</h1>
                        <a class="detail_link" href="#" target="_blank">Detail</a>
                    </div>
                    {{--<div class="modal-footer d-flex justify-content-center">--}}

                    {{--</div>--}}
                </form>
            </div>
        </div>
    </div>
    @include("tools.tool_loading")
@stop