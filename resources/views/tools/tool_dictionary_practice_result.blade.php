@extends("tools/tool_content")

@section('title', 'SWT Dictionary Practice Review')

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

        });
    </script>
@append

@section("content")
    <div class="container-fluid">
        <main role="main" class="container">
            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-blue rounded shadow-sm">
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">Practice</h6>
                    <small>Create Date: <span class="date">{{$created_time}}</span></small>
                </div>
            </div>
            <form class="ajax" action="javascript:void(0)">
                <div class="questions">
                    @foreach($record as $id=>$val)
                        <div class="my-3 p-3 bg-white rounded shadow-sm question">
                            <h6 class="border-bottom border-gray pb-2 mb-0">Question {{$number++}}</h6>
                            <div class="media text-muted pt-3">
                                <p class="media-body pb-3 mb-0 small lh-125 border-gray">
                                    <strong class="d-block text-gray-dark">{{$val['answer']}}</strong>
                                    <span>{{$val['question']}}</span>
                                </p>
                            </div>
                            @if($val['pass'])
                            <h4 class="form-group text-success">
                                {{$val['submit']}}
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </h4>
                            @else
                            <h4 class="form-group text-danger">
                                {{$val['submit']}}
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </h4>
                            @endif
                        </div>
                    @endforeach
                </div>
            </form>
        </main>
    </div>
@stop