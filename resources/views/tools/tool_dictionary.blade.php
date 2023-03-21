@extends("tools/tool_content")

@section('title', 'SWT Dictionary')

@section("css")
    <link href="/packages/bootstrap-toggle-master/css/bootstrap-toggle.min.css?v2" rel="stylesheet">
    <style>
        .fc-icon{
            font-family: FontAwesome!important;
        }
        .fc-icon.fc-icon-search:before{
            width: auto;
            height: auto;
            position: absolute;
            content: "\f002";
            font-size: 22px;
            top: 7px;
            left: 26px;
        }
        .fc-icon.fc-icon-edit:before{
            width: auto;
            height: auto;
            position: relative;
            content: "\f044";
            font-size: 22px;
        }
        .fc-icon.fc-icon-add:before{
            width: auto;
            height: auto;
            position: relative;
            content: "\f067";
            font-size: 22px;
        }
        .deleted{
            opacity: 0.3;
        }
        #myInput {
            background-position: 10px 12px; /* Position the search icon */
            background-repeat: no-repeat; /* Do not repeat the icon image */
            width: 100%; /* Full-width */
            font-size: 16px; /* Increase font-size */
            padding: 12px 20px 12px 40px; /* Add some padding */
            border: 1px solid #ddd; /* Add a grey border */
        }

        .mybutton{
            height: 50px;
            width: 100%;
        }

        #myTable {
            border-collapse: collapse; /* Collapse borders */
            width: 100%; /* Full-width */
            border: 1px solid #ddd; /* Add a grey border */
            font-size: 18px; /* Increase font-size */
        }

        #myTable th, #myTable td {
            text-align: left; /* Left-align text */
            padding: 12px; /* Add padding */
        }

        #myTable tr {
            /* Add a bottom border to all table rows */
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
            /* Add a grey background color to the table header and on hover */
            background-color: #f1f1f1;
        }

        #myTable.practice tbody tr:hover td:nth-last-child(2)::after{
            /* Add a grey background color to the table header and on hover */
            background: #f1f1f1;
        }

        #myTable.practice tbody tr td:nth-last-child(2){
            position:relative;
        }
        #myTable.practice tbody tr td:nth-last-child(2)::after{
            position: absolute;
            content: "Close Me To See Answer";
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background: #f9fafc;
            align-items: center;
            display: flex;
            padding: 12px;
        }
        #myTable.practice tbody tr td:nth-last-child(2):hover::after{
            display: none;
        }

        .addDictionaryBtn {
            position: fixed;
            bottom: 80px;
            right: 10px;
            justify-content: center;
            align-content: center;
            z-index: 1;
            width: 80px;
            height: 80px;
            background: #6c757c;
            border-radius: 100px;
            opacity: 0.7;
            cursor: pointer;
            display:none;
        }
        .addDictionaryBtn:hover{
            opacity: 1;
        }
        .addDictionaryBtn.show{
            display: flex;
        }
        .addDictionaryBtn span {
            color: #fff;
            font-size: 50px;
            display: flex;
            align-items: center;
        }
        @media (max-width: 767px){
            .order-12{
                order: initial;
            }
        }
    </style>
@stop

@section("js")
    <script src="/packages/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
    <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("td")[0];
                td2 = tr[i].getElementsByTagName("td")[1];
                if (td1 || td2) {
                    txt1Value = td1.textContent || td1.innerText;
                    txt2Value = td2.textContent || td2.innerText;
                    if (txt1Value.toUpperCase().indexOf(filter) > -1 || txt2Value.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        $(function(){
            loading(true);
            $getDictionary = new ajaxCall();
            $getDictionary.send("./getDictionary","post",{},function(){
                loading(false);
                msg_fail("Lost connection.")
            },function(e){
                if(e.message.length>0){
                    $('tbody').html('');
                }
                $.each(e.message,function(i,v){
                    $('tbody').append("<tr>" +
                        "<td>"+v.text+"</td>" +
                        "<td>"+v.description.nl2str(";<br>")+"</td>" +
                        "<td>" +
                        "<div class='btn edit' data-value='"+v.dictionary+"'>" +
                        "<span class='fc-icon fc-icon-edit'></span>" +
                        "</div>" +
                        "</td>" +
                        "</tr>")
                });
                loading(false);
            });
            $(document).on("change","input[name=practice]",function(){
                if($('input[name="practice"]:checked').length>0){
                    $("#myTable").addClass('practice');
                }else{
                    $("#myTable").removeClass('practice');
                }
            });
            $(window).scroll(function(e){
                var headH = $("nav").innerHeight();
                if($(this).scrollTop()>headH){
                    $(".addDictionaryBtn").addClass("show");
                }else{
                    $(".addDictionaryBtn").removeClass("show");
                }
            });
            $("nav").addClass("sticky");
        })
    </script>
@append

@section("content")
    <div class="container-fluid">
        <div class="info col-md-12">
            <div class="row tool">
                <div class="col-md-2 order-12">
                    <div class="btn mybutton btn-secondary">
                        <span class="fc-icon fc-icon-add"></span>
                    </div>
                </div>
                <div class="col-md-10">
                    <span class="fc-icon fc-icon-search"></span>
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
                </div>
            </div>
            <div class="mt-2 mb-2 text-right">
                <label for="practice" class="mb-0" style="vertical-align:middle;">Practice Mode</label>
                <input name="practice" id="practice" type="checkbox" data-toggle="toggle" data-size="small" data-width="60px" data-on="Yes" data-off="No">
            </div>
            <table id="myTable">
                <thead>
                    <tr class="header">
                        <th style="width:45%;">Word</th>
                        <th style="width:50%;">Description</th>
                        <th style="width:5%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <div class="text-center">No Record.</div>
                        </td>
                        {{--ajax--}}
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="addDictionaryBtn">
            <span>+</span>
        </div>
    </div>
    @include("tools.tool_dictionary.add_text")
    @include("tools.tool_dictionary.edit_text")
    @include("tools.tool_loading")
@stop