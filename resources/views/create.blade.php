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
                        <input type="checkbox" class="" id="hard_label" name="hard_label">
                        <label class="" for="hard_label">Loại khó gán nhãn</label>
                    </div>
                    <hr width="100%">

                    <div class="row col-md-12">
                        <div class="col-md-5">
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
                        <div class="col-md-1" id="vertical-line">

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-inline" style="width: 100%;">
                                    <div class="form-group mb-4">
                                        <label style="vertical-align: top;"><b>Mã sách:</b></label>

                                        <input class="form-control" id="ma_sach" name="ma_sach" style="width: 100%;" value="VNTK000000000107" disabled/>
                                    </div>
                                    <div class="form-group mb-4" style="position: relative;left: 7%;">
                                        <label style="vertical-align: top;"><b>Loại:</b></label>

                                        <input class="form-control" type="text" name="type" style="width: 100%;" value="" disabled>

                                    </div>
                                </div>
                                <hr width="100%">

                                <div class="form-group" style="width: 100%;">
                                    <label style="vertical-align: top;"><b>Chương:</b></label>

                                    <div class="chapter_area">
                                        <input class="form-control" type="text" name="chapter" style="width: 100%;" value="" disabled>

                                    </div>
                                </div>
                                <hr width="100%">

                                <div class="form-group" style="width: 100%;">
                                    <label style="vertical-align: top;"><b>Bài:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <select class="bai_input" name="bai">
                                        <option value=""></option>
                                        <option value="null">Không xác định</option>
                                        @foreach($profiles as $profile)
                                            <option value="{{$profile->lesson}}">{{$profile->lesson}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr width="100%">

                                <div class="form-group" style="width: 100%;">
                                    <label style="vertical-align: top;"><b>Knowledge point tổng:</b></label>
                                    <div style="display:inline-block; width:80%"></div>

                                    <textarea class="form-control" type="text" name="total_knowledge_point" style="width: 100%;" disabled></textarea>
                                </div>
                                <hr width="100%">

                                <div class="form-group" style="width: 100%;">
                                    <label style="vertical-align: top;"><b>Knowledge point:</b></label>

                                    <input id="knowledge_point_tree" name="diem_kien_thuc" style="width: 100%;"/>
                                </div>

                                <hr width="100%">

                                <div class="form-group" style="width: 100%;">
                                    <label style="vertical-align: top;"><b>Knowledge bổ sung:</b></label>

                                    <textarea class="form-control" type="text" id="knowledge_extra" name="knowledge_extra" style="width: 100%;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr width="100%">

                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đề bài:</b></label>
                        <div style="display:inline-block; width:101%">

                    <textarea class="form-control" style="width:100%" id="postquestion" rows="7"
                              placeholder="Post's question in HTML"></textarea>
                            <p style="margin-top:20px; width: 100%" id="postquestion-display">
                            </p>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đáp án:</b></label>
                        <div style="display:inline-block; width:101%">
                    <textarea class="form-control" style="width:100%" id="postanswer" rows="7"
                              placeholder="Post's answer"></textarea>
                            <p style="margin-top:20px; width: 100%" id="postanswer-display">
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
        let chapter_is_input = true;

        $('.bai_input').select2();

        let profiles = {!! $profiles !!};

        let enable_select_chapter = function(){
            let chapter_option_html = '<option value=""></option>';

            let inserted_chapter = [];

            profiles.forEach(function(profile){
                if(inserted_chapter.indexOf(profile.chapter) === -1){
                    chapter_option_html += '<option value="'+profile.chapter+'">'+profile.chapter+'</option>';

                    inserted_chapter.push(profile.chapter);
                }
            });

            $('.chapter_area').html('<select class="chapter_input" name="chapter">'+chapter_option_html+'<select/>')
            $('.chapter_input').select2();

            chapter_is_input = false;

            $('select[name="chapter"]').change(function(){
                let value = $(this).val();

                profiles.forEach(function(profile){
                    if(profile.chapter === value) {
                        $('input[name="type"]').val(profile.type);
                    }
                });
            });
        };

        $('.bai_input').change(function(){
            let value = $(this).val();

            if(value === ''){
                $('input[name="type"]').val('');

                chapter_is_input = true;

                $('.chapter_area').html('<input class="form-control" type="text" name="chapter" style="width: 100%;" value="" disabled>')
                $('input[name="chapter"]').prop('disabled', true);

                $('textarea[name="total_knowledge_point"]').val('');

                reset_knowledge_point_tree([]);

            }else if(value === 'null'){
                $('input[name="type"]').val('');

                // $('input[name="chapter"]').val('');
                enable_select_chapter();

                $('textarea[name="total_knowledge_point"]').val('');

                $('input[name="chapter"]').prop('disabled', false);

                reset_knowledge_point_tree([]);
            }else{
                chapter_is_input = true;

                $('.chapter_area').html('<input class="form-control" type="text" name="chapter" style="width: 100%;" value="" disabled>')
                $('input[name="chapter"]').prop('disabled', true);

                profiles.forEach(function(profile){
                    if(profile.lesson === value) {
                        $('input[name="type"]').val(profile.type);
                        $('input[name="chapter"]').val(profile.chapter);
                        $('textarea[name="total_knowledge_point"]').val(profile.knowledge_point);

                        let knowledge_point = profile.knowledge_point;
                        knowledge_point = knowledge_point.replace(/"/g, '');
                        let knowledge_point_arr = knowledge_point.split("|");
                        let total_knowledge_point_html = [];

                        knowledge_point_arr.forEach(function(knowledge_point_value){
                            total_knowledge_point_html.push({
                                text: knowledge_point_value.trim(),
                            });
                        });

                        reset_knowledge_point_tree(total_knowledge_point_html);

                    }
                });
            }
        });

        let check_count = 0;

        let isCheck = function(ele){
            return ele.is(':checked');
        };

        let uncheck = function(ele){
            return ele.next().click();
        };

        let reset_knowledge_point_tree = function(dataSource){
            $('.k-widget.k-dropdowntree.k-dropdowntree-clearable').replaceWith('<input id="knowledge_point_tree" name="diem_kien_thuc" style="width: 100%;"/>');

            $("#knowledge_point_tree").kendoDropDownTree({
                placeholder: "Chọn tối đa 5 điểm kiến thức",
                checkboxes: true,
                autoClose: false,
                // filter: "contains",
                dataSource: dataSource
            });

            check_count = 0;

            $(".k-checkbox").change(function(){
                let check = isCheck($(this));

                check_count = $(".k-multiselect-wrap > ul > li > span:first-child").length;
                if(check === true){

                    if(check_count >= 5){

                        toastr.error("Bạn chỉ được chọn tối đa 5 điểm kiến thức!");
                        uncheck($(this));
                    }
                }

                check_count = $(".k-multiselect-wrap > ul > li > span:first-child").length;

            });

            $(".k-in").click(function () {
                return false;
            });
        };

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
        };

        $("#btn-create").click(function(){
            let hard_label = $('input[name="hard_label"]:checked').length;

            let de_bai = trim(qeditor.getData());
            let dap_an = trim(aeditor.getData());
            let tieu_de = $('input[name="tieu_de"]').val();

            let ma_sach = $('input[name="ma_sach"]').val();
            let type = $('input[name="type"]').val();
            let chapter = '';
            if(chapter_is_input) chapter = $('input[name="chapter"]').val();
            else chapter = $('select[name="chapter"]').val();
            let bai = $('select[name="bai"]').val();
            let total_knowledge_point = $('textarea[name="total_knowledge_point"]').val();
            let knowledge_extra = $('textarea[name="knowledge_extra"]').val();

            let knowledge_point = [];
            $.each($(".k-multiselect-wrap > ul > li > span:first-child"), function(){
                knowledge_point.push($(this).text().trim());
            });
            knowledge_point = knowledge_point.join("|");

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
                ma_sach: ma_sach,
                type: type,
                chapter: chapter,
                bai: bai,
                total_knowledge_point: total_knowledge_point,
                knowledge_point: knowledge_point,
                hard_label: hard_label,
                knowledge_extra: knowledge_extra,
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
