@extends('layouts.master')

@section('content')
    <link href="{{url('/css/select2.min.css')}}"  rel="stylesheet">

    <style>
        table th, table td{
            border: 1px solid black;
        }
        #btn-create{
            margin-left: 21rem!important;
        }
        .select2-container{
            width: 10rem!important;
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
                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Tiêu đề:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="tieu_de" id="title" value="">
                </div>
                <hr width="100%">
                {{--<div class="form-group" style="width: 100%;">--}}
                    {{--<label style="vertical-align: top; width: 15%"><b>Đường dẫn câu hỏi:</b></label>--}}
                    {{--<div style="display:inline-block; width:80%"></div>--}}

                    {{--<input class="form-control" type="text" name="duong_dan_hoi">--}}
                {{--</div>--}}
                {{--<hr width="100%">--}}
                {{--<div class="form-group" style="width: 100%;">--}}
                    {{--<label style="vertical-align: top; width: 15%"><b>Đường dẫn câu trả lời:</b></label>--}}
                    {{--<div style="display:inline-block; width:80%"></div>--}}

                    {{--<input class="form-control" type="text" name="duong_dan_tra_loi">--}}
                {{--</div>--}}
                {{--<hr width="100%">--}}
                <div class="form-inline" style="width: 100%;">
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn lớp:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="class_input" name="class">
                            @foreach($classes as $class)
                                <option value="{{$class->name}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn môn:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="subject_input" name="subject">
                            @foreach($subjects as $subject)
                                <option value="{{$subject->name}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn loại sách:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="category_input" name="category">
                            @foreach($categories as $category)
                                <option value="{{$category->name}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chọn tập:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="number" name="tap" value="0" min="0" max="99999999999999999999" step="1">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chương:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="chuong">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chọn bài:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="number" name="bai" value="1" min="0" max="99999999999999999999">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Điểm kiến thức:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="diem_kien_thuc">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Đề bài:</b></label>
                    <div style="display:inline-block; width:80%">

                    <textarea class="form-control" style="width:100%" id="postquestion" rows="7"
                        placeholder="Post's question in HTML"></textarea>
                    <p style="margin-top:20px; width: 100%" id="postquestion-display">
                    </p>
                    </div>
                </div>
                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Đáp án:</b></label>
                    <div style="display:inline-block; width:80%">
                    <textarea class="form-control" style="width:100%" id="postanswer" rows="7"
                        placeholder="Post's answer"></textarea>
                    <p style="margin-top:20px; width: 100%" id="postanswer-display">
                    </p>
                    </div>
                </div>
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
<script src="{{url('/js/select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.class_input').select2();
        $('.subject_input').select2();
        $('.category_input').select2();

        CKEDITOR.replace('postquestion', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});
        CKEDITOR.replace('postanswer', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});
        // CKEDITOR.replace('postquestion', { extraPlugins: 'eqneditor', height: '250px', allowedContent: true});
        // CKEDITOR.replace('postanswer', { extraPlugins: 'eqneditor', height: '250px', allowedContent: true});

        let qeditor = CKEDITOR.instances.postquestion;
        let aeditor = CKEDITOR.instances.postanswer;

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

        $("#postquestion-display")[0].innerHTML = qeditor.getData();
        $("#postanswer-display")[0].innerHTML = aeditor.getData();

        qeditor.on('change', function(){
            $("#postquestion-display")[0].innerHTML = qeditor.getData();
            renderMathJax();
        });

        aeditor.on('change', function(){
            $("#postanswer-display")[0].innerHTML = aeditor.getData();
            renderMathJax();
        });

        $('#postquestion').bind('input propertychange', function() {
            $("#postquestion-display")[0].innerHTML = qeditor.getData();
            // renderMathJax();
        });

        $('#postanswer').bind('input propertychange', function() {
            $("#postanswer-display")[0].innerHTML = aeditor.getData();
            // renderMathJax();
        });

        let trim = function(text){
            text = text.replace('<span class="math-tex">', "");
            text = text.replace('</span>', "");

            text = text.replace('http://dev.data.giaingay.io/TestProject/public/media/', "media/");

            return text;
        }

        $("#btn-create").click(function(){
            let de_bai = trim(qeditor.getData());
            let dap_an = trim(aeditor.getData());
            let tieu_de = $('input[name="tieu_de"]').val();
            let class_name = $('select[name="class"]').val();
            let subject = $('select[name="subject"]').val();
            let category = $('select[name="category"]').val();
            let tap = $('input[name="tap"]').val();
            let chuong = $('input[name="chuong"]').val();
            let bai = $('input[name="bai"]').val();
            let diem_kien_thuc = $('input[name="diem_kien_thuc"]').val();

            let err = false;

            if(tap < 0 || tap > 99999999999999999999){
                toastr.error("Tập phải là 1 số nguyên dương tối đa 99999999999999999999");
                if(!err) $('input[name="tap"]').focus();
                $('input[name="tap"]').css({
                    'color': '#495057',
                    'background-color': '#fff',
                    'border-color': '#80bdff',
                    'outline': '0',
                    'box-shadow': '0 0 0 0.2rem rgba(0,123,255,.25)'
                });
                err = true;
            }

            if(bai < 0 || bai > 99999999999999999999){
                toastr.error("Bài phải là 1 số dương tối đa 99999999999999999999");
                if(!err) $('input[name="bai"]').focus();
                $('input[name="bai"]').css({
                    'color': '#495057',
                    'background-color': '#fff',
                    'border-color': '#80bdff',
                    'outline': '0',
                    'box-shadow': '0 0 0 0.2rem rgba(0,123,255,.25)'
                });
                err = true;
            }

            if(dap_an.trim() == "")
            {
                toastr.error("Thiếu thông tin đáp án");
                if(!err) aeditor.focus();
                err = true;
            }

            if(de_bai.trim() == "")
            {
                toastr.error("Thiếu thông tin đề bài");
                if(!err) qeditor.focus();
                err = true;
            }

            if(tieu_de.trim() == "")
            {
                toastr.error("Thiếu thông tin tiêu đề");
                if(!err) $('input[name="tieu_de"]').focus();
                $('input[name="tieu_de"]').css({
                    'color': '#495057',
                    'background-color': '#fff',
                    'border-color': '#80bdff',
                    'outline': '0',
                    'box-shadow': '0 0 0 0.2rem rgba(0,123,255,.25)'
                });
                err = true;
            }

            if(err) return;


            $("#btn-create").prop('disabled', true);
            let data = {
                de_bai: de_bai,
                dap_an: dap_an,
                tieu_de: tieu_de,
                class_name: class_name,
                subject: subject,
                category: category,
                tap: tap,
                chuong: chuong,
                bai: bai,
                diem_kien_thuc: diem_kien_thuc,
                hoi_dap_id: '{{$guid}}'
            }

            $.ajax({
                method: 'POST',
                url: "{{url('/api/post1')}}",
                data: data,
                success: function(result){
                    toastr.success("Tạo thành công");
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau");
                }
            });
        });

        function rependl(str){
            str = str.replace('\nolimits', '\zolimits');
            str = str.replace('\notin', '\zotin');
            str = str.replace('\nleq', '\zleq');
            str = str.replace('\ngeq', '\zgeq');
            str = str.replace('\neq', '\zeq');
            str = str.replace('\ne', '\ze');
            str = str.replace('\n', '<br/>');
            str = str.replace('\zolimits', '\nolimits');
            str = str.replace('\zotin', '\notin');
            str = str.replace('\zleq', '\nleq');
            str = str.replace('\zgeq', '\ngeq');
            str = str.replace('\zeq', '\neq');
            str = str.replace('\ze', '\ne');
            return str;
        }

        function addSpan(str)
        {
            let out = '';

            for(i=0;i<str.length;++i){
                if(str[i] == '\\' && str[i+1] == '(') {
                    out = out + '<span class="math-tex">\\(';
                    i+=1;
                }
                else {
                    if(str[i] == '\\' && str[i+1] == ')'){
                        out = out + '\\)</span>';
                        i+=1;
                    }
                    else
                        out+=str[i];
                }
            }
            console.log(out);
            return out;
        }
    });
</script>
@endpush
