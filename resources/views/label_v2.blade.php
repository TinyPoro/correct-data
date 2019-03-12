@extends('layouts.master')

@section('title')
    Gán nhãn câu hỏi đáp
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
            width: 100%!important;
        }
        .select2-selection{
            min-height: 2.3rem!important;
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
        #cke_postquestion, #cke_postanswer{
            display: none;
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
                        <input class="form-control" style="display: inline-block; width:35%" id="post-id" min="0" type="text"
                               placeholder="Post's id" value="{{$post->id}}" maxlength="10"/>
                        &nbsp;
                        <button class="btn btn-success" style="display: inline-block;" id="btn-change-id">Tìm kiếm</button>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label style="width: 15%"><b>ItemID:</b></label>
                        <input class="form-control" style="display: inline-block; width:35%" id="post-itemid" type="text"
                               placeholder="Post's itemID" value="{{$post->hoi_dap_id}}" maxlength="32"/>
                        &nbsp;
                        <button class="btn btn-success" style="display: inline-block;" id="btn-change-itemid">Tìm kiếm</button>
                    </div>
                    <hr width="100%">
                    <div class="form-group" style="width: 100%;">
                        @if($post->hard_label === 1)
                            <input type="checkbox" class="" id="hard_label" name="hard_label" checked>
                        @else
                            <input type="checkbox" class="" id="hard_label" name="hard_label">
                        @endif
                        <label class="" for="hard_label">Loại khó gán nhãn</label>
                    </div>
                    <hr width="100%">
                    <div class="row col-md-12" style="margin-left: 15px;">
                        <div class="row">
                            <div class="form-inline" style="width: 100%;">
                                <div class="form-group mb-4">
                                    <label style="vertical-align: top;"><b>Mã sách:</b></label>

                                    @if($post_profile)
                                        <input class="form-control" id="ma_sach" name="ma_sach" style="width: 100%;" value="{{$post_profile->book_id}}"/>
                                    @else
                                        <input class="form-control" id="ma_sach" name="ma_sach" style="width: 100%;" value=""/>
                                    @endif
                                </div>
                                <div class="form-group mb-4" style="position: relative;left: 7%;">
                                    <label style="vertical-align: top;"><b>Loại:</b></label>

                                    <select class="type_input" name="type">
                                        @foreach($loais as $loai)
                                            @if($post_profile)
                                                @if($loai === $post_profile->loai)
                                                    <option value="{{$loai}}" selected>{{$loai}}</option>
                                                @else
                                                    <option value="{{$loai}}">{{$loai}}</option>
                                                @endif
                                            @else
                                                <option value="{{$loai}}">{{$loai}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Khu vực kiến thức:</b></label>

                                <div>
                                    <select class="khu_vuc_input" name="khu_vuc">
                                    </select>
                                </div>
                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Dạng bài:</b></label>

                                <div>
                                    <select class="dang_bai_input" name="dang_bai">
                                    </select>
                                </div>
                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Knowledge point tổng:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                @if($post_profile)
                                    <textarea class="form-control" type="text" name="total_knowledge_point" style="width: 100%;" disabled>{{$post_profile->knowledge_point}}</textarea>
                                @else
                                    <textarea class="form-control" type="text" name="total_knowledge_point" style="width: 100%;" disabled></textarea>
                                @endif

                            </div>
                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Knowledge point:</b></label>

                                <input id="knowledge_point_tree" name="diem_kien_thuc" style="width: 100%;"/>
                            </div>

                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Knowledge bổ sung:</b></label>

                                <textarea maxlength="200" class="form-control" type="text" id="knowledge_extra" name="knowledge_extra" style="width: 100%;">{{$post->knowledge_extra}}</textarea>
                            </div>

                            <hr width="100%">


                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Độ khó:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <?php
                                $do_khos = [
                                    'Dễ',
                                    'Trung bình',
                                    'Khó',
                                ];
                                ?>

                                <select class="do_kho_input" name="do_kho">
                                    <option value="">Chưa xác định</option>
                                    @foreach($do_khos as $do_kho)
                                        @if($post)
                                            @if($do_kho === $post->do_kho)
                                                <option value="{{$do_kho}}" selected>{{$do_kho}}</option>
                                            @else
                                                <option value="{{$do_kho}}">{{$do_kho}}</option>
                                            @endif
                                        @else
                                            <option value="{{$do_kho}}">{{$do_kho}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Giao ở đâu:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <?php
                                    $giaos = [
                                        'Giao trên lớp',
                                        'Lớp học thêm',
                                        'Bài về nhà',
                                    ];
                                ?>

                                <select class="giao_input" name="giao">
                                    <option value="">Chưa xác định</option>
                                    @foreach($giaos as $giao)
                                        @if($post)
                                            @if($giao === $post->giao)
                                                <option value="{{$giao}}" selected>{{$giao}}</option>
                                            @else
                                                <option value="{{$giao}}">{{$giao}}</option>
                                            @endif
                                        @else
                                            <option value="{{$giao}}">{{$giao}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Kiểm tra:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <?php
                                $kiem_tras = [
                                    'Kiểm tra 15p',
                                    'Kiểm tra 45p',
                                    'Không kiểm tra',
                                ];
                                ?>

                                <select class="kiem_tra_input" name="kiem_tra">
                                    <option value="">Chưa xác định</option>
                                    @foreach($kiem_tras as $kiem_tra)
                                        @if($post)
                                            @if($kiem_tra === $post->kiem_tra)
                                                <option value="{{$kiem_tra}}" selected>{{$kiem_tra}}</option>
                                            @else
                                                <option value="{{$kiem_tra}}">{{$kiem_tra}}</option>
                                            @endif
                                        @else
                                            <option value="{{$kiem_tra}}">{{$kiem_tra}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <hr width="100%">

                            <div class="form-group" style="width: 100%;">
                                <label style="vertical-align: top;"><b>Mục tiêu:</b></label>
                                <div style="display:inline-block; width:80%"></div>

                                <?php
                                $muc_tieus = [
                                    'Bài tập luyện tập',
                                    'Bài tập ví dụ',
                                ];
                                ?>

                                <select class="muc_tieu_input" name="muc_tieu">
                                    <option value="">Chưa xác định</option>
                                    @foreach($muc_tieus as $muc_tieu)
                                        @if($post)
                                            @if($muc_tieu === $post->muc_tieu)
                                                <option value="{{$muc_tieu}}" selected>{{$muc_tieu}}</option>
                                            @else
                                                <option value="{{$muc_tieu}}">{{$muc_tieu}}</option>
                                            @endif
                                        @else
                                            <option value="{{$muc_tieu}}">{{$muc_tieu}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr width="100%">
                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đề bài:</b></label>
                        <div style="display:inline-block; width:101%">

                    <textarea class="form-control" style="width:100%" id="postquestion" rows="7"
                              placeholder="Post's question in HTML"><?php echo standardCkeditor($post->de_bai); ?></textarea>
                            <p style="margin-top:20px; width: 100%" id="postquestion-display">
                            </p>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label style="vertical-align: top; width: 15%"><b>Đáp án:</b></label>
                        <div style="display:inline-block; width:101%">
                    <textarea class="form-control" style="width:100%" id="postanswer" rows="7"
                              placeholder="Post's answer"><?php echo standardCkeditor($post->dap_an); ?></textarea>
                            <p style="margin-top:20px; width: 100%" id="postanswer-display">
                            </p>
                        </div>
                    </div>
                    <hr width="100%">

                    <button class="btn btn-success" style="width: 30%; margin: 10px; padding: 15px;" id="btn-edit">Cập nhật
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

        let ma_sach_input = $('input[name="ma_sach"]');
        let type_input = $('.type_input');
        let khu_vuc_input = $('.khu_vuc_input');
        let dang_bai_input = $('.dang_bai_input');
        let total_knowledge_point_input = $('textarea[name="total_knowledge_point"]');
        let knowledge_extra_input = $('textarea[name="knowledge_extra"]');
        let do_kho_input = $('.do_kho_input');
        let giao_input = $('.giao_input');
        let kiem_tra_input = $('.kiem_tra_input');
        let muc_tieu_input = $('.muc_tieu_input');

        type_input.select2();
        khu_vuc_input.select2();
        dang_bai_input.select2();
        do_kho_input.select2();
        giao_input.select2();
        kiem_tra_input.select2();
        muc_tieu_input.select2();

        let prev_id = "{{$post->id}}";
        let prev_itemid = "{{$post->hoi_dap_id}}";

        let profiles = {!! $profiles  !!};
        let post_profile = '<?php echo json_encode($post_profile); ?>';
        post_profile = JSON.parse(post_profile);

        let isCheck = function(ele){
            return ele.is(':checked');
        };

        let uncheck = function(ele){
            return ele.next().click();
        };

        let findText = function(ele){
            return ele.parent().next().text();
        };

        let check_count = 0;

        let reset_knowledge_point_tree = function(dataSource){
            $('.k-widget.k-dropdowntree.k-dropdowntree-clearable').replaceWith('<input id="knowledge_point_tree" name="diem_kien_thuc" style="width: 100%;"/>');

            $("#knowledge_point_tree").kendoDropDownTree({
                placeholder: "Chọn tối đa 5 điểm kiến thức",
                checkboxes: true,
                autoClose: false,
                dataSource: dataSource
            });

            check_count = 0;

            $(".k-checkbox").change(function(){
                let check = isCheck($(this));

                let selected_span = $(".k-multiselect-wrap > ul > li > span:first-child");

                check_count = selected_span.length;

                if(check === true){

                    if(check_count >= 5){

                        toastr.error("Bạn chỉ được chọn tối đa 5 điểm kiến thức!");
                        uncheck($(this));
                    }
                }

                check_count = selected_span.length;

            });

            $(".k-in").click(function () {
                return false;
            });
        };

        let update_khu_vuc_input = function(){
            khu_vuc_input.html('');

            let type = type_input.val();

            let datas = profiles.filter(function(profile){
                return profile.loai === type;
            });

            datas = datas.map(function(profile){
               return profile.khu_vuc;
            });

            datas = datas.filter((v, i, a) => a.indexOf(v) === i);


            datas.forEach(function(data){
                if(post_profile && post_profile.khu_vuc === data) khu_vuc_input.append("<option value='"+data+"' selected>"+data+"</option>");
                else khu_vuc_input.append("<option value='"+data+"'>"+data+"</option>");
            });
        };

        let update_dang_bai_input = function(){
            dang_bai_input.html('');

            let type = type_input.val();
            let khu_vuc = khu_vuc_input.val();

            let datas = profiles.filter(function(profile){
                return profile.khu_vuc === khu_vuc && profile.loai === type;
            });

            datas = datas.map(function(profile){
                return profile.dang_bai;
            });

            datas = datas.filter((v, i, a) => a.indexOf(v) === i);


            datas.forEach(function(data){
                if(post_profile && post_profile.dang_bai === data) dang_bai_input.append("<option value='"+data+"' selected>"+data+"</option>");
                else dang_bai_input.append("<option value='"+data+"'>"+data+"</option>");
            });
        };

        let update_knowledpoint_input = function(){
            total_knowledge_point_input.val('');

            let new_total_knowledge_point = '';

            let type = type_input.val();
            let khu_vuc = khu_vuc_input.val();
            let dang_bai = dang_bai_input.val();

            let datas = profiles.filter(function(profile){
                return profile.dang_bai === dang_bai && profile.khu_vuc === khu_vuc && profile.loai === type;
            });

            datas = datas.map(function(profile){
                return profile.knowledge_point;
            });

            datas = datas.filter((v, i, a) => a.indexOf(v) === i);


            datas.forEach(function(data){
                new_total_knowledge_point += data;
            });

            total_knowledge_point_input.val(new_total_knowledge_point);

            new_total_knowledge_point = new_total_knowledge_point.replace(/"/g, '');
            let knowledge_point_arr = new_total_knowledge_point.split("|");
            let total_knowledge_point_html = [];

            knowledge_point_arr.forEach(function(knowledge_point_value){
                total_knowledge_point_html.push({
                    text: knowledge_point_value.trim(),
                });
            });

            reset_knowledge_point_tree(total_knowledge_point_html);
        };

        type_input.change(function(){
            update_khu_vuc_input();
            update_dang_bai_input();
            update_knowledpoint_input();
        });

        khu_vuc_input.change(function(){
            update_dang_bai_input();
            update_knowledpoint_input();
        });

        dang_bai_input.change(function(){
            update_knowledpoint_input();
        });

        update_khu_vuc_input();
        update_dang_bai_input();
        update_knowledpoint_input();

        if(post_profile){
            let old_knowledge_point = '{!! $post->knowledge_question !!}';
            old_knowledge_point = old_knowledge_point.split('|');

            check_count = old_knowledge_point.length;

            $.each($(".k-checkbox"), function(){
                if(old_knowledge_point.indexOf(findText($(this))) !== -1) {
                    $(this).next().click();
                }
            });
        }


        CKEDITOR.replace('postquestion', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});
        CKEDITOR.replace('postanswer', { extraPlugins: 'mathjax, eqneditor', height: '250px', allowedContent: true});

        let qeditor = CKEDITOR.instances.postquestion;
        let aeditor = CKEDITOR.instances.postanswer;

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
            if(post_id === "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) === false){

                toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                return;
            }

            if(post_id.length > 10){

                toastr.error("Trường ID chỉ được phép tối đa 10 kí tự!");
                return;
            }

            let url = '{{route('post.edit_label_v2', ['postId' => ':postId'])}}';
            url = url.replace(':postId', post_id);
            window.location = url;
        });

        $("#post-id").bind("keypress", function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                let post_id = $("#post-id").val();
                if(post_id === "" || isNaN(post_id) || Number(post_id) <= 0 || Number.isInteger(Number(post_id)) === false){

                    toastr.error("Tìm kiếm bằng ID: ID không được để trống và phải là số nguyên dương");
                    return;
                }

                if(post_id.length > 10){

                    toastr.error("Trường ID chỉ được phép tối đa 10 kí tự!");
                    return;
                }

                let url = '{{route('post.edit_label_v2', ['postId' => ':postId'])}}';
                url = url.replace(':postId', post_id);
                window.location = url;
            }
        });

        $("#post-id").inputFilter(function(value) {
            return /^\d*$/.test(value); });

        $("#post-itemid").inputFilter(function(value) {
            return /^[0-9a-zA-Z.]*$/i.test(value); });

        $("#btn-change-itemid").click(function(){
            let post_id = $("#post-itemid").val();
            if(prev_itemid !== post_id){
                if(post_id === ""){

                    toastr.error("Tìm kiếm bằng ItemId: ItemID không được để trống");
                    return;
                }

                if(post_id.length > 32){

                    toastr.error("Trường ItemID chỉ được phép tối đa 32 kí tự!");
                    return;
                }

                let url = '{{route('post.edit_label_v2', ['postId' => ':postId'])}}';
                url = url.replace(':postId', post_id);
                window.location = url;
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
        });

        $('#postanswer').bind('input propertychange', function() {
            $("#postanswer-display")[0].innerHTML = aeditor.getData();
        });

        let trim = function(text){
            text = text.replace('<span class="math-tex">', "");
            text = text.replace('</span>', "");

            text = text.replace('http://dev.data.giaingay.io/TestProject/public/media/', "media/");

            return text;
        };

        $("#btn-edit").click(function(){
            let hard_label = $('input[name="hard_label"]:checked').length;

            let ma_sach = ma_sach_input.val();
            let loai = type_input.val();
            let khu_vuc = khu_vuc_input.val();
            let dang_bai = dang_bai_input.val();
            let do_kho = do_kho_input.val();
            let giao = giao_input.val();
            let kiem_tra = kiem_tra_input.val();
            let muc_tieu = muc_tieu_input.val();

            let total_knowledge_point = total_knowledge_point_input.val();
            let knowledge_extra = knowledge_extra_input.val();

            let knowledge_point = [];
            $.each($(".k-multiselect-wrap > ul > li > span:first-child"), function(){
                knowledge_point.push($(this).text().trim());
            });
            knowledge_point = knowledge_point.join("|");

            let err = false;

            if($("#post-id").val() !== prev_id)
            {

                toastr.error("Bạn phải giữ nguyên trường ID để thay đổi!");
                if(!err) $("#post-id").focus();
                $("#post-id").addClass('error');
                err = true;
            }

            if($("#post-itemid").val() !== prev_itemid)
            {

                toastr.error("Bạn phải giữ nguyên trường Item ID để thay đổi!");
                if(!err) $("#post-itemid").focus();
                $("#post-itemid").addClass('error');
                err = true;
            }

            if(trim(ma_sach) === "")
            {
                toastr.error("Mã sách không được để trống!");
                if(!err) ma_sach_input.focus();
                ma_sach_input.addClass('error');
                err = true;
            }

            if(trim(dang_bai) === "")
            {
                toastr.error("Bạn phải chọn dạng bài!!");
                if(!err) dang_bai_input.focus();
                dang_bai_input.addClass('error');
                err = true;
            }

            if(trim(do_kho) === "")
            {
                toastr.error("Bạn phải chọn độ khó!!");
                if(!err) do_kho_input.focus();
                do_kho_input.addClass('error');
                err = true;
            }

            if(trim(giao) === "")
            {
                toastr.error("Bạn phải chọn giao ở đâu!!");
                if(!err) giao.focus();
                giao_input.addClass('error');
                err = true;
            }

            if(trim(kiem_tra) === "")
            {
                toastr.error("Bạn phải chọn kiểm tra!!");
                if(!err) kiem_tra_input.focus();
                kiem_tra_input.addClass('error');
                err = true;
            }

            if(trim(muc_tieu) === "")
            {
                toastr.error("Bạn phải chọn mục tiêu!!");
                if(!err) muc_tieu_input.focus();
                muc_tieu_input.addClass('error');
                err = true;
            }

            if(knowledge_extra.length > 200)
            {
                toastr.error("Trường Knowledge bổ sung chỉ được tối đa 200 kí tự!");
                if(!err) knowledge_extra_input.focus();
                knowledge_extra_input.addClass('error');
                err = true;
            }

            if(err) return;

            $("#btn-edit").prop('disabled', true);
            let data = {
                ma_sach: ma_sach,
                loai: loai,
                khu_vuc: khu_vuc,
                dang_bai: dang_bai,
                do_kho: do_kho,
                giao: giao,
                kiem_tra: kiem_tra,
                muc_tieu: muc_tieu,
                total_knowledge_point: total_knowledge_point,
                knowledge_point: knowledge_point,
                knowledge_extra: knowledge_extra,
                hard_label: hard_label,
            };

            let post_id = $("#post-id").val();

            let url = '{{route('post.update_label_v2', ['postId' => ':postId'])}}';
            url = url.replace(':postId', post_id);

            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                success: function(result){
                    console.log(result);

                    toastr.success("Sửa Thành công");
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                },
                error: function (jqXHR) {
                    console.log(jqXHR.responseText);

                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau");
                }
            });
        });

        $('input').keyup(function(){
            $(this).removeClass('error');
        });

    </script>
@endpush
