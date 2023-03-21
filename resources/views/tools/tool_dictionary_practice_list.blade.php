@extends("tools/tool_content")

@section('title', 'SWT Dictionary Practice')

@section("css")
    <link href="/packages/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
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
    <script src="/packages/bootstrap-table/bootstrap-table.min.js"></script>
    <script>
        $(function(){
            window.ajaxOptions = {
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                }
            }
            $('#table').bootstrapTable({
                sidePagination: "server",
                method:'POST',
                dataType:'json',
                contentType: "application/json",
                cache: true,
                striped: true,
                url:'./getDictionaryPracticeList',
                ajaxOptions:{
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                showColumns:true,
                pagination:true,
                theadClasses: "thead-light",
                queryParams : queryParams,
                pageNumber:1,
                pageSize: 10,
                pageList: [10, 25, 50, 100],
                showExport: true,
                search: true,
                exportDataType: 'all',
                // loadingTemplate: function(){
                    // return '<i class="fa fa-spinner fa-spin fa-fw fa-2x"></i>'
                // },
                columns: [
                    {
                        field : 'created_at',
                        title : 'Create Time',
                        align : 'center',
                        valign : 'middle',
                        sortable : true
                    },
                    {
                        field : 'marks',
                        title : 'Marks',
                        align : 'right',
                        valign : 'middle',
                        // sortable : true
                    },
                    {
                        field : 'updated_at',
                        title : 'Last Update Time',
                        align : 'center',
                        valign : 'middle',
                        sortable : true
                    },
                    {
                        field : 'key',
                        title : '',
                        formatter: function (value, row, index) {
                            if(value=="0"){
                                return "<div style='width:95px;' class='btn-sm'>Abandon <i class='fa fa-ban' aria-hidden='true'></i></div>";
                            }else if(value=="1"){
                                return "<a style='width:95px;' class='btn btn-primary btn-sm' href='./dictionaryPractice' target='_blank'>In-Process <i class='fa fa-pencil' aria-hidden='true'></i></a>";
                            }else{
                                return "<a style='width:95px;' class='btn btn-success btn-sm' href='./dictionaryPracticeResult/"+value+"' target='_blank'>View <i class='fa fa-eye' aria-hidden='true'></i></a>";
                            }

                        },
                        width: '100px',
                        align : 'center'
                    }
                ]
            })
            function queryParams(params) {
                var param = {
                    pageindex : this.pageNumber-1,
                    pageSize : this.pageSize,
                    sortName: this.sortName,
                    sortOrder: this.sortOrder,
                    searchText: this.searchText,
                }
                return JSON.stringify(param);
            }
        });
    </script>
@append

@section("content")
    <div class="container-fluid">
        <main role="main" class="container">
            <div class="table-responsive">
                <table id="table" class="table" data-show-toggle="true" data-sort-name="created_at" data-sort-order="desc"> </table>
            </div>
        </main>
    </div>
    @include("tools.tool_loading")
@stop