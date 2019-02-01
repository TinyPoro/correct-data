@extends('layouts.master')

@section('content')
    <style>
        table th, table td{
            border: 1px solid black;
        }
        #btn-edit{
            margin-left: 21rem!important;
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
                <div class="col-md-8"><h3>Sửa câu hỏi đáp</h3></div>
        </div>
        <input type="hidden" id="post-hoi-dap-id" value="{{$post->hoi_dap_id}}">
        <div class="card-body" style="padding-bottom: 0px">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px 20px">
                <div class="form-group" style="width: 100%;">
                    <label style="width: 15%"><b>ID:</b></label>
                    <input class="form-control" style="display: inline-block; width:35%" id="post-id" min="0" type="html"
                        placeholder="Post's id" value="{{$post->id}}" maxlength="8">
                    &nbsp;
                    <button class="btn btn-success" style="display: inline-block;" id="btn-change-id">Tìm kiếm</button>
                </div>
                <div class="form-group" style="width: 100%;">
                    <label style="width: 15%"><b>ItemID:</b></label>
                    <input class="form-control" style="display: inline-block; width:35%" id="post-itemid" type="text"
                        placeholder="Post's itemID" value="{{$post->hoi_dap_id}}" maxlength="50"/>
                    &nbsp;
                    <button class="btn btn-success" style="display: inline-block;" id="btn-change-itemid">Tìm kiếm</button>
                </div>
                <hr width="100%">
                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Tiêu đề:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="tieu_de" value="{{$post->tieu_de}}">
                </div>
                <hr width="100%">
                <div class="form-group" style="width: 100%;">
                    <label><b>Đường dẫn câu hỏi:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="duong_dan_hoi" value="{{$post->duong_dan_hoi}}">
                </div>
                <hr width="100%">
                <div class="form-group" style="width: 100%;">
                    <label><b>Đường dẫn câu trả lời:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="duong_dan_tra_loi" value="{{$post->duong_dan_tra_loi}}">
                </div>
                <hr width="100%">
                <div class="form-inline" style="width: 100%;">
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn lớp:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="class_input" name="class">
                            @foreach($classes as $class)
                                @if($class->name === $profiles['class'])
                                    <option value="{{$class->name}}" selected>{{$class->name}}</option>
                                @else
                                    <option value="{{$class->name}}">{{$class->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn môn:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="subject_input" name="subject">
                            @foreach($subjects as $subject)
                                @if($subject->name === $profiles['subject'])
                                    <option value="{{$subject->name}}" selected>{{$subject->name}}</option>
                                @else
                                    <option value="{{$subject->name}}">{{$subject->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label style="vertical-align: top;"><b>Chọn loại sách:</b></label>
                        <div style="display:inline-block; width:80%"></div>

                        <select class="category_input" name="category">
                            @foreach($categories as $category)
                                @if($category->name === $profiles['category'])
                                    <option value="{{$category->name}}" selected>{{$category->name}}</option>
                                @else
                                    <option value="{{$category->name}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chọn tập:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="number" name="tap" value="{{$profiles['tap']}}" min="0" max="50" step="1">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chương:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="chuong" value="{{$profiles['chuong']}}">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chọn bài:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="number" name="bai" value="{{$profiles['bai']}}" min="0" max="50">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Điểm kiến thức:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="diem_kien_thuc" value="{{$profiles['diem_kien_thuc']}}">

                </div>
                <hr width="100%">
                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Đề bài:</b></label>
                    <div style="display:inline-block; width:80%">

                    <textarea class="form-control" style="width:100%" id="postquestion" rows="7"
                        placeholder="Post's question in HTML"><?php echo standardCkeditor($post->de_bai); ?></textarea>
                    <p style="margin-top:20px; width: 100%" id="postquestion-display">
                    </p>
                    </div>
                </div>
                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Đáp án:</b></label>
                    <div style="display:inline-block; width:80%">
                    <textarea class="form-control" style="width:100%" id="postanswer" rows="7"
                        placeholder="Post's answer"><?php echo standardCkeditor($post->dap_an); ?></textarea>
                    <p style="margin-top:20px; width: 100%" id="postanswer-display">
                    </p>
                    </div>
                </div>
                <button class="btn btn-success" style="width: 30%; margin: 10px; padding: 15px;" id="btn-edit">Lưu
                </button>
            </div>
        </div>  
    </div>
</div>

@if(sizeof($histories) > 0 )
<div class="container">
    <hr>
    <h3>
        Lịch sử chỉnh sửa 
    </h3>
    <div class="row">
        @foreach($histories as $history)
            <div class="col-md-4" style="margin-top:25px">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="text-align: center">
                            {{$history->created}}
                        </h4>
                        <!-- <p class="card-text">Some example text. Some example text.</p> -->
                        <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-info" onclick="rollback({{$history->id}})">Sử dụng lịch sử</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
@push('scripts')
<script src="{{url('/assets/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
<script src="{{url('/assets/ckeditor/adapters/jquery.js')}}"></script>

<script>
    let histories = {!! $histories !!};
    let prev_id = "{{$post->id}}";
    let prev_itemid = "{{$post->hoi_dap_id}}";

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

    $("#btn-change-id").click(function(){
        let post_id = $("#post-id").val();
        if(prev_id != post_id) {
            if(post_id == "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) == false){
                toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                return;
            }
            window.location = "{{url('/post1')}}/" + post_id + "/edit";
        }
    });

    $("#post-id").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            let post_id = $("#post-id").val();
            if(prev_id != post_id) {
                if(post_id == "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) == false){
                    toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                    return;
                }
                window.location = "{{url('/post1')}}/" + post_id + "/edit";
            }
        }
    });

    $("#post-id").inputFilter(function(value) {
        return /^\d*$/.test(value); });
    
    $("#post-itemid").inputFilter(function(value) {
        return /^[0-9a-zA-Z.]*$/i.test(value); });
    
    $("#btn-change-itemid").click(function(){
        let post_id = $("#post-itemid").val();
        if(prev_itemid != post_id){
            if(post_id == ""){
                toastr.error("Tìm kiếm bằng ItemId: ItemID không được để trống");
                return;
            }
            window.location = "{{url('/post1')}}/" + post_id + "/edit";
        }
    });

    $(document).ready(function(){
        $("#postquestion-display")[0].innerHTML = qeditor.getData();
        $("#postanswer-display")[0].innerHTML = aeditor.getData();
    });

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

    $("#btn-edit").click(function(){
        let de_bai = trim(qeditor.getData());
        let dap_an = trim(aeditor.getData());
        let tieu_de = $('input[name="tieu_de"]').val();
        let duong_dan_hoi = $('input[name="duong_dan_hoi"]').val();
        let duong_dan_tra_loi = $('input[name="duong_dan_tra_loi"]').val();
        let class_name = $('select[name="class"]').val();
        let subject = $('select[name="category"]').val();
        let category = $('select[name="subject"]').val();
        let tap = $('input[name="tap"]').val();
        let chuong = $('input[name="chuong"]').val();
        let bai = $('input[name="bai"]').val();
        let diem_kien_thuc = $('input[name="diem_kien_thuc"]').val();

        let err = false;

        if($("#post-id").val() != prev_id || $("#post-itemid").val() != prev_itemid)
        {
            toastr.error("Giữ nguyên ID và ItemID để thay đổi");
            if(!err) $("#post-id").focus();
            $("#post-id").css({
                'color': '#495057',
                'background-color': '#fff',
                'border-color': '#80bdff',
                'outline': '0',
                'box-shadow': '0 0 0 0.2rem rgba(0,123,255,.25)'
            });
            err = true;

        }

        if(tap < 0){
            toastr.error("Tập phải là 1 số nguyên dương");
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

        if(bai < 0){
            toastr.error("Bài phải là 1 số dương");
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

        if(de_bai.trim() == "")
        {
            toastr.error("Thiếu thông tin đề bài");
            if(!err) qeditor.focus();
            err = true;
        }

        if(dap_an.trim() == "")
        {
            toastr.error("Thiếu thông tin đáp án");
            if(!err) aeditor.focus();
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

        $("#btn-edit").prop('disabled', true);
        let data = {
            de_bai: de_bai,
            dap_an: dap_an,
            tieu_de: tieu_de,
            duong_dan_hoi: duong_dan_hoi,
            duong_dan_tra_loi: duong_dan_tra_loi,
            class_name: class_name,
            subject: subject,
            category: category,
            tap: tap,
            chuong: chuong,
            bai: bai,
            diem_kien_thuc: diem_kien_thuc,
        }

        let post_id = $("#post-id").val();

        $.ajax({
            method: 'PUT',
            url: "{{url('api/post1')}}/"+post_id,
            data: data,
            success: function(result){
                toastr.success("Sửa Thành công");
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            },
            error: function (jqXHR, exception) {
                console.log(error);
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

    var x;
    var y;
    function rollback(historyId){
        let history = histories.find(x => x.id == historyId);
        de_bai = history.de_bai;
        dap_an = history.dap_an;
        // de_bai = rependl(de_bai);
        de_bai = addSpan(de_bai);
        // dap_an = rependl(dap_an);
        dap_an = addSpan(dap_an);
        qeditor.setData(de_bai);
        aeditor.setData(dap_an);
    }
</script>
@endpush
