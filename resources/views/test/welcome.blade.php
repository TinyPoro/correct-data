@extends('layouts.master')

@section('title')
    Sửa câu hỏi đáp
@endsection

@section('content')
    <link href="{{url('/css/select2.min.css')}}"  rel="stylesheet">
    <link href="{{url('/css/kendo.common.min.css')}}"  rel="stylesheet">
    <link href="{{url('/css/kendo.default.min.css')}}"  rel="stylesheet">
    
    <style>
        table th, table td{
            border: 1px solid black;
        }
        #btn-edit{
            margin-left: 21rem!important;
        }
        .select2-container{
            width: 10rem!important;
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
                <div class="row col-md-12">
                    <div class="col-md-5">
                        <div class="form-group" style="width: 100%;">
                            <label style="vertical-align: top;"><b>Tiêu đề:</b></label>
                            <div style="display:inline-block; width:80%"></div>

                            <input class="form-control" type="text" name="tieu_de" value="{{$post->tieu_de}}">
                            <div style="height:6px"></div>
                        </div>
                        <hr width="100%">
                        <div class="form-group" style="width: 100%;">
                            <label><b>Đường dẫn câu hỏi:</b></label>

                            <input class="form-control" type="text" name="duong_dan_hoi" value="{{$post->duong_dan_hoi}}">
                            <div style="height:7px"></div>
                        </div>
                        <hr width="100%">
                        <div class="form-group" style="width: 100%;">
                            <label><b>Đường dẫn câu trả lời:</b></label>

                            <input class="form-control" type="text" name="duong_dan_tra_loi" value="{{$post->duong_dan_tra_loi}}">
                        </div>
                    </div>
                    <div class="col-md-1" id="vertical-line">

                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-inline" style="width: 100%;">
                                <div class="form-group mb-4">
                                    <label style="vertical-align: top;"><b>Lớp:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <select class="class_input" name="class" disabled>
                                        @foreach($classes as $class)
                                            @if($class->name === $profiles['class'])
                                                <option value="{{$class->name}}" selected>{{$class->name}}</option>
                                            @else
                                                <option value="{{$class->name}}">{{$class->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-4" style="position: relative;left: 10%;">
                                    <label style="vertical-align: top;"><b>Môn:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <select class="subject_input" name="subject" disabled>
                                        @foreach($subjects as $subject)
                                            @if($subject->name === $profiles['subject'])
                                                <option value="{{$subject->name}}" selected>{{$subject->name}}</option>
                                            @else
                                                <option value="{{$subject->name}}">{{$subject->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr width="100%">

                            <div class="form-inline" style="width: 100%;">
                                <div class="form-group mb-4">
                                    <label style="vertical-align: top;"><b>Loại sách:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <select class="category_input" name="category">
                                        <option value=""> </option>
                                        @foreach($categories as $category)
                                            @if($category->name === $profiles['category'])
                                                <option value="{{$category->name}}" selected>{{$category->name}}</option>
                                            @else
                                                <option value="{{$category->name}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label style="vertical-align: top;"><b>Tập:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <select class="tap_input" name="tap">
                                        <?php
                                        $taps = [
                                            '1',
                                            '2',
                                            '3',
                                            '4',
                                            '5',
                                        ]
                                        ?>
                                        @foreach($taps as $tap)
                                            @if($tap == $profiles['tap'])
                                                <option value="{{$tap}}" selected>{{$tap}}</option>
                                            @else
                                                <option value="{{$tap}}">{{$tap}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Chương:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <input class="form-control" type="text" name="chuong" value="{{$profiles['chuong']}}">

                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Bài:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <input class="form-control" type="number" name="bai" value="{{$profiles['bai']}}" min="0" max="99999999999999999999">

                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Điểm kiến thức:</b></label>

                                <input id="diem_kien_thuc_tree" name="diem_kien_thuc" style="width: 100%;" />
                            </div>
                        </div>
                    </div>
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
                <hr width="100%">

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
<script src="{{url('/js/jquery.min.js')}}"></script>
<script src="{{url('/js/select2.min.js')}}"></script>
<script src="{{url('/js/kendo.all.min.js')}}"></script>

<script>
        $('.class_input').select2();
        $('.subject_input').select2();
        $('.category_input').select2();
        $('.tap_input').select2();
        let histories = {!! $histories !!};
        let prev_id = "{{$post->id}}";
        let prev_itemid = "{{$post->hoi_dap_id}}";

        $("#diem_kien_thuc_tree").kendoDropDownTree({
            placeholder: "Chọn tối đa 5 điểm kiến thức",
            checkboxes: true,
            autoClose: false,
            filter: "contains",
            dataSource: [
                {
                    text: "Không xác định",
                },
                {
                    text: "Hình học - Hình trụ, hình nón, hình cầu", expanded: true, items: [
                        { text: "hình trụ" },
                        { text: "hình nón" },
                        { text: "hình nón cụt" },
                        { text: "hình cầu" },
                        { text: "diện tích xung quanh" },
                        { text: "thể tích" }
                    ]
                },
                {
                    text: "Hình học - Hệ thức lượng tam giác vuông", items: [
                        { text: "đường trung tuyến" },
                        { text: "đường cao" },
                        { text: "đường phân giác" },
                        { text: "cạnh góc vuông" },
                        { text: "hình chiếu" },
                        { text: "tam giác đồng dạng" },
                        { text: "tam giác đều" },
                        { text: "tam giác cân" },
                        { text: "tam giác vuông" },
                        { text: "tam giác" },
                        { text: "lượng giác, sin, cos, tg, cotg." }
                    ]
                },
                {
                    text: "Hình học - đường tròn", items: [
                        { text: "bán kính" },
                        { text: "đường kính" },
                        { text: "dây của đường tròn" },
                        { text: "cung của đường tròn" },
                        { text: "chu vi" },
                        { text: "khoảng cách từ tâm đến dây và cung" },
                        { text: "độ dài đường tròn" },
                        { text: "cung tròn" },
                        { text: "hình quạt" },
                        { text: "diện tích" },
                        { text: "đường tròn nội tiếp" },
                        { text: "đường tròn ngoại tiếp" },
                        { text: "tam giác nội tiếp" },
                        { text: "tam giác ngoại tiếp" },
                        { text: "đa gia giác nội tiếp (tứ giác, lục giác)" },
                        { text: "đa giác ngoại tiếp" },
                        { text: "tâm đối xứng" },
                        { text: "trục đối xứng" },
                        { text: "tiếp tuyến đường tròn" },
                        { text: "vị trí tương đối của hai đường tròn" },
                        { text: "góc tâm" },
                        { text: "góc nội tiếp." },
                    ]
                },
                {
                    text: "Đại số - Căn thức", items: [
                        { text: "căn bậc hai" },
                        { text: "khai phương" },
                        { text: "bài toán rút gọn và tính biểu thức (chứa căn thức)" },
                        { text: "căn bậc ba" },
                        { text: "lập phương." },
                    ]
                },
                {
                    text: "Đại số - Hàm số bậc nhất", items: [
                        { text: "hàm đồng biến" },
                        { text: "hàm nghịch biến" },
                        { text: "đường thẳng." },
                    ]
                },
                {
                    text: "Đại số - Hàm số bậc hai một ẩn", items: [
                        { text: "vẽ đồ thị - parabol" },
                        { text: "phương trình bậc hai" },
                        { text: "phương trình trùng phương" },
                        { text: "phương trình chứa ẩn mẫu thức" },
                    ]
                },
                {
                    text: "Đại số - Hệ hai phương trình bậc nhất hai ẩn", items: [
                        { text: "tìm tọa độ mặt phẳng" },
                        { text: "tìm đường thẳng" },
                    ]
                },
            ]
        });

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
            // if(prev_id != post_id) {
                if(post_id == "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) == false){
                    toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                    return;
                }
                window.location = "{{url('/post1')}}/" + post_id + "/edit";
            // }
        });

        $("#post-id").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let post_id = $("#post-id").val();
                // if(prev_id != post_id) {
                    if(post_id == "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) == false){
                        toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                        return;
                    }
                    window.location = "{{url('/post1')}}/" + post_id + "/edit";
                // }
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
        };

        let findText = function(ele){
            return ele.parent().next().text();
        };

        let isCheck = function(ele){
            return ele.is(':checked');
        };

        let uncheck = function(ele){
            return ele.next().click();
        };

        let old_dkt = '{{$profiles['diem_kien_thuc']}}';
        old_dkt = old_dkt.split(';');

        $.each($(".k-checkbox"), function(){
            if(old_dkt.indexOf(findText($(this))) !== -1) {
                $(this).next().click();
            }
        });

        let disable_value = ['Hình học - Hình trụ, hình nón, hình cầu','Hình học - Hệ thức lượng tam giác vuông','Hình học - đường tròn','Đại số - Căn thức','Đại số - Hàm số bậc nhất','Đại số - Hàm số bậc hai một ẩn','Đại số - Hệ hai phương trình bậc nhất hai ẩn'];

        $.each($(".k-checkbox"), function(){
            if(disable_value.indexOf(findText($(this))) !== -1) {
                $(this).prop('disabled', true);
            }
        });

        let check_count = {{$dkt_count}};

        $(".k-checkbox").change(function(){
            let check = isCheck($(this));
            let value = findText($(this));

            check_count = $(".k-multiselect-wrap > ul > li > span:first-child").length;

            if(value === 'Không xác định'){
                if(check === true){
                    $.each($(".k-checkbox"), function(){
                        if(findText($(this)) !== 'Không xác định' && isCheck($(this))) {
                            uncheck($(this));
                        }
                    });

                    if(!isCheck($(this))) $(this).click();

                }
            }else{
                $.each($(".k-checkbox"), function(){
                    if(findText($(this)) === 'Không xác định') {
                        if(isCheck($(this)) === true) {
                            uncheck($(this));
                        }
                    }
                });

                if(check === true){

                    if(check_count >= 5){
                        toastr.error("Bạn chỉ được chọn tối đa 5 điểm kiến thức!");
                        uncheck($(this));
                    }
                }
            }

            check_count = $(".k-multiselect-wrap > ul > li > span:first-child").length;
        });

        $(".k-in").click(function () {
            return false;
        });

        $('input[name="bai"]').keydown(function(e){
            if(!((e.keyCode > 95 && e.keyCode < 106)
                || (e.keyCode > 47 && e.keyCode < 58)
                || e.keyCode === 8)) {
                return false;
            }
        });

        $("#btn-edit").click(function(){
            toastr.clear();

            let de_bai = trim(qeditor.getData());
            let dap_an = trim(aeditor.getData());
            let tieu_de = $('input[name="tieu_de"]').val();
            let duong_dan_hoi = $('input[name="duong_dan_hoi"]').val();
            let duong_dan_tra_loi = $('input[name="duong_dan_tra_loi"]').val();
            let class_name = $('select[name="class"]').val();
            let subject = $('select[name="subject"]').val();
            let category = $('select[name="category"]').val();
            let tap = $('select[name="tap"]').val();
            let chuong = $('input[name="chuong"]').val();
            let bai = $('input[name="bai"]').val();
            let diem_kien_thuc = [];
            $.each($(".k-multiselect-wrap > ul > li > span:first-child"), function(){
                diem_kien_thuc.push($(this).text());
            });
            diem_kien_thuc = diem_kien_thuc.join(";");

            let err = false;

            if($("#post-id").val() != prev_id)
            {
                toastr.error("Bạn phải giữ nguyên trường ID để thay đổi!");
                if(!err) $("#post-id").focus();
                $("#post-id").addClass('error');
                err = true;
            }

            if($("#post-itemid").val() != prev_itemid)
            {
                toastr.error("Bạn phải giữ nguyên trường Item ID để thay đổi!");
                if(!err) $("#post-itemid").focus();
                $("#post-itemid").addClass('error');
                err = true;
            }

            if(tap < 0){
                toastr.error("Tập không thể là 1 số âm!");
                if(!err) $('input[name="tap"]').focus();
                $('input[name="tap"]').addClass('error');
                err = true;
            }

            if(tap > 99999999999999999999){
                toastr.error("Tập không được vượt quá 20 kí tự");
                if(!err) $('input[name="tap"]').focus();
                $('input[name="tap"]').addClass('error');
                err = true;
            }

            if(bai < 0){
                toastr.error("Bài không thể là 1 số âm!");
                if(!err) $('input[name="bai"]').focus();
                $('input[name="bai"]').addClass('error');
                err = true;
            }

            if(bai > 99999999999999999999){
                toastr.error("Bài không được vượt quá 20 kí tự");
                if(!err) $('input[name="bai"]').focus();
                $('input[name="bai"]').addClass('error');
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
                $('input[name="tieu_de"]').addClass('error');
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
                    console.log(jqXHR.responseText);
                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau");
                }
            });
        });

        $('input').keyup(function(){
            $(this).removeClass('error');
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
