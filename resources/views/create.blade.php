@extends('layouts.master')

@section('title')
    Tạo câu hỏi đáp
@endsection

@section('content')
    <link href="{{url('/css/select2.min.css')}}"  rel="stylesheet">
    <link href="{{url('/css/kendo.common.min.css')}}"  rel="stylesheet">
    <link href="{{url('/css/kendo.default.min.css')}}"  rel="stylesheet">

    <style>
        table th, table td{
            border: 1px solid black;
        }
        #btn-create{
            margin-left: 21rem!important;
        }
        .select2-container{
            width: 100%!important;
        }
        .tab{
            position: relative;
            left: 3rem;
        }
        .error{
            color: #495057!important;
            background-color: #fff!important;
            border-color: #80bdff!important;
            outline: 0!important;
            box-shadow: 0 0 0 0.1rem rgba(235, 50, 50, 1)!important;
        }
        .k-state-focused{
            box-shadow: none!important;
        }
        .k-state-hover{
            background: none!important;
        }
        @media (min-width: 1200px){
            .container {
                max-width: 1200px!important;
            }
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            padding-right: 0!important;
            padding-left: 0!important;
        }
        .mb-4{
            margin-bottom: .4rem!important;
        }
        label {
            margin-bottom: .5rem!important;
        }
        .form-group {
            margin-bottom: .4rem!important;
        }
        .container img, .cke_editable img {
            max-width: 100%!important;
            height: auto;
        }
        #postquestion-display, #postanswer-display{
            border-right: 1px dashed red;
        }
    </style>

    <?php
    function standardCkeditor($text){
        $text = str_replace("\(", '<span class="math-tex">\(', $text);
        $text = str_replace("\)", '\)</span>', $text);

        return $text;
    }
    ?>

    <div class="container">
        <div class="table-wrapper">
            <div class="card-body">
                <div class="col-md-8"><h3>Tạo câu hỏi đáp</h3></div>
            </div>
            <input type="hidden" id="post-hoi-dap-id" value="{{$guid}}">
            <div class="card-body" style="padding-bottom: 0px">
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px 20px">
                    <div class="form-group" style="width: 100%;">
                        <label style="width: 15%"><b>ItemID:</b></label>
                        <label><b>{{$guid}}</b></label>
                    </div>
                    <hr width="100%">

                    <div class="row col-md-12">
                        <div class="form-group" style="width: 100%;">
                            <label style="vertical-align: top;"><b>Tiêu đề:</b></label>
                            <div style="display:inline-block; width:80%"></div>

                            <input class="form-control" type="text" name="tieu_de" id="title" value="">
                            <div style="height:6px"></div>
                        </div>
                        <hr width="100%">
                        <div class="form-group" style="width: 100%;">
                            <label style="vertical-align: top;"><b>Đường dẫn câu hỏi:</b></label>

                            <input disabled class="form-control" type="text" name="duong_dan_hoi">
                            <div style="height:7px"></div>
                        </div>
                        <hr width="100%">
                        <div class="form-group" style="width: 100%;">
                            <label style="vertical-align: top;"><b>Đường dẫn câu trả lời:</b></label>

                            <input disabled class="form-control" type="text" name="duong_dan_tra_loi">
                        </div>
                    </div>

                    <hr width="100%">

                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đề bài:</b></label>
                        <div style="display:inline-block; width:100%">

                    <textarea class="form-control" style="width:100%" id="postquestion" rows="7"
                              placeholder="Post's question in HTML"></textarea>
                            <p style="margin-top:20px; width: 1445px" id="postquestion-display">
                            </p>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đáp án:</b></label>
                        <div style="display:inline-block; width:100%">
                    <textarea class="form-control" style="width:100%" id="postanswer" rows="7"
                              placeholder="Post's answer"></textarea>
                            <p style="margin-top:20px; width: 1445px" id="postanswer-display">
                            </p>
                        </div>
                    </div>

                    <hr width="100%">

                    <button class="btn btn-success" style="width: 30%; margin: 10px; padding: 15px;" id="btn-create">Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{url('/assets/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
    <script src="{{url('/assets/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{url('/js/jquery.min.js')}}"></script>
    <script src="{{url('/js/select2.min.js')}}"></script>
    <script src="{{url('/js/kendo.all.min.js')}}"></script>

    <script>
        toastr.options = {
            "preventDuplicates": true,
            "preventOpenDuplicates": true
        };

        $(document).ready(function() {
            CKEDITOR.replace('postquestion', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});
            CKEDITOR.replace('postanswer', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});
            // CKEDITOR.replace('postquestion', { extraPlugins: 'eqneditor', height: '250px', allowedContent: true});
            // CKEDITOR.replace('postanswer', { extraPlugins: 'eqneditor', height: '250px', allowedContent: true});

            let qeditor = CKEDITOR.instances.postquestion;
            let aeditor = CKEDITOR.instances.postanswer;
            let question_preview = $("#postquestion-display")[0];
            let answer_preview = $("#postanswer-display")[0];

            let can_save = false;

            qeditor.on( 'fileUploadRequest', function( evt ) {
                let post_id = $("#post-hoi-dap-id").val();

                evt.data.requestData.id = post_id;
                evt.data.requestData.type = 'Problems';

            } );

            aeditor.on( 'fileUploadRequest', function( evt ) {
                let post_id = $("#post-hoi-dap-id").val();

                evt.data.requestData.id = post_id;
                evt.data.requestData.type = 'Solutions';
            } );

            function renderMathJax()
            {
                MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
            }

            (function($) {
                $.fn.inputFilter = function(inputFilter) {
                    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                        if (inputFilter(this.value)) {
                            this.oldValue = this.value;
                            this.oldSelectionStart = this.selectionStart;
                            this.oldSelectionEnd = this.selectionEnd;
                        } else if (this.hasOwnProperty("oldValue")) {
                            this.value = this.oldValue;
                            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                        }
                    });
                };
            }(jQuery));

            question_preview.innerHTML = qeditor.getData();
            answer_preview.innerHTML = aeditor.getData();

            qeditor.on('change', function(){
                question_preview.innerHTML = qeditor.getData();
                renderMathJax();

                if(question_preview.scrollWidth > 1445) {
                    can_save = false;
                    toastr.error("Chiều dài câu hỏi đã vượt quá chiều rộng cho phép! Bạn sửa lại nhé!")
                } else {
                    can_save = true;
                }
            });

            qeditor.on( 'fileUploadResponse', function( evt ) {
                setTimeout(function(){
                    question_preview.innerHTML = qeditor.getData();
                    renderMathJax();
                }, 1000);
            } );

            aeditor.on('change', function(){
                answer_preview.innerHTML = aeditor.getData();
                renderMathJax();

                if(answer_preview.scrollWidth > 1445) {
                    can_save = false;
                    toastr.error("Chiều dài câu trả lời đã vượt quá chiều rộng cho phép! Bạn sửa lại nhé!")
                } else {
                    can_save = true;
                }
            });

            aeditor.on( 'fileUploadResponse', function( evt ) {
                setTimeout(function(){
                    answer_preview.innerHTML = aeditor.getData();
                    renderMathJax();
                }, 1000);
            } );

            $('#postquestion').bind('input propertychange', function() {
                question_preview.innerHTML = qeditor.getData();
                // renderMathJax();
            });

            $('#postanswer').bind('input propertychange', function() {
                answer_preview.innerHTML = aeditor.getData();
                // renderMathJax();
            });

            let trim = function(text){
                text = text.replace('<span class="math-tex">', "");
                text = text.replace('</span>', "");

                text = text.replace('http://dev.data.giaingay.io/TestProject/public/media/', "media/");

                return text;
            };

            $("#btn-create").click(function(){
                if(can_save === false) {
                    toastr.error("Chiều dài câu hỏi hoặc câu trả lời đã vượt quá chiều rộng cho phép! Bạn sửa lại nhé!")
                    return;
                }

                if(question_preview.scrollWidth > 1445) {
                    can_save = false;
                    toastr.error("Chiều dài câu hỏi đã vượt quá chiều rộng cho phép! Bạn sửa lại nhé!")
                    return;
                }

                if(answer_preview.scrollWidth > 1445) {
                    can_save = false;
                    toastr.error("Chiều dài câu trả lời đã vượt quá chiều rộng cho phép! Bạn sửa lại nhé!")
                    return;
                }

                let de_bai = trim(qeditor.getData());
                let dap_an = trim(aeditor.getData());
                let tieu_de = $('input[name="tieu_de"]').val();

                let err = false;

                if(dap_an.trim() === "")
                {

                    toastr.error("Thiếu thông tin đáp án");
                    if(!err) aeditor.focus();
                    err = true;
                }

                if(de_bai.trim() === "")
                {

                    toastr.error("Thiếu thông tin đề bài");
                    if(!err) qeditor.focus();
                    err = true;
                }

                if(tieu_de.trim() === "")
                {

                    toastr.error("Thiếu thông tin tiêu đề");
                    if(!err) $('input[name="tieu_de"]').focus();
                    $('input[name="tieu_de"]').addClass('error');
                    err = true;
                }

                if(err) return;


                $("#btn-create").prop('disabled', true);
                let data = {
                    de_bai: de_bai,
                    dap_an: dap_an,
                    tieu_de: tieu_de,
                    ten_nguon: '{{$src}}',
                    hoi_dap_id: '{{$guid}}'
                };

                let url = '{{route('post.store')}}';

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: data,
                    success: function(result){
                        console.log(result);

                        toastr.success("Tạo thành công");
                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    },
                    error: function (jqXHR, exception) {
                        console.log(jqXHR.responseText);

                        toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau");
                    }
                });
            });

            $('input').keyup(function(){
                $(this).removeClass('error');
            });
        });
    </script>
@endpush
