@extends('layouts.master')

@section('content')
    <link href="{{url('/css/select2.min.css')}}"  rel="stylesheet">

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
                    <div class="form-group mb-4">
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
                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Tập:</b></label>
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
                            @if($tap === $profiles['tap'])
                                <option value="{{$tap}}" selected>{{$tap}}</option>
                            @else
                                <option value="{{$tap}}">{{$tap}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Chương:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="text" name="chuong" value="{{$profiles['chuong']}}">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Bài:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <input class="form-control" type="number" name="bai" value="{{$profiles['bai']}}" min="0" max="99999999999999999999">

                </div>
                <hr width="100%">

                <div class="form-group" style="width: 100%;">
                    <label style="vertical-align: top; width: 15%"><b>Điểm kiến thức:</b></label>
                    <div style="display:inline-block; width:80%"></div>

                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Không xác định">Không xác định</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Hình học - Hình trụ, hình nón, hình cầ">Hình học - Hình trụ, hình nón, hình cầu</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình trụ">Hình trụ</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình nón">Hình nón</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình nón cụt">Hình nón cụt</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình cầu">Hình cầu</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Diện tích xung quanh">Diện tích xung quanh</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Thể tích">Thể tích</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Hình học - Hệ thức lượng trong tam giác vuông">Hình học - Hệ thức lượng trong tam giác vuông</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường trung tuyến">Đường trung tuyến</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường cao">Đường cao</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường phân giác">Đường phân giác</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Cạnh góc vuông">Cạnh góc vuông</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình chiếu">Hình chiếu</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác đồng dạng">Tam giác đồng dạng</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác đều">Tam giác đều</label>
                    </div>
                    <div class="radio tab1">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác cân">Tam giác cân</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác vuông">Tam giác vuông</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác">Tam giác</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Lượng giác, sin, cos, tg, cotg">Lượng giác, sin, cos, tg, cotg</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Hình học - Đường tròn">Hình học - Đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Bán kính">Bán kính</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường kính">Đường kính</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Dây của đường tròn">Dây của đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Cung của đường tròn">Cung của đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Chu vi">Chu vi</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Khoảng cách từ tâm đến dây và cung">Khoảng cách từ tâm đến dây và cung</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Độ dài đường tròn">Độ dài đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Cung tròn">Cung tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hình quạt">Hình quạt</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Diện tích">Diện tích</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường tròn nội tiếp">Đường tròn nội tiếp</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường tròn ngoại tiếp">Đường tròn ngoại tiếp</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác nội tiếp">Tam giác nội tiếp</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tam giác ngoại tiếp">Tam giác ngoại tiếp</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đa giác nội tiếp(tứ giác, lục giác)">Đa giác nội tiếp(tứ giác, lục giác)</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đa giác ngoại tiếp">Đa giác ngoại tiếp</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tâm đối xứng">Tâm đối xứng</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Trục đối xứng">Trục đối xứng</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tiếp tuyến đường tròn">Tiếp tuyến đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Vị trí tương đối của hai đường tròn">Vị trí tương đối của hai đường tròn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Góc tâm">Góc tâm</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Góc nội tiếp">Góc nội tiếp</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Đại số - Căn thức">Đại số - Căn thức</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Căn bậc 2">Căn bậc 2</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Khai phương">Khai phương</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Bài toán rút gọn và tính biểu thức (chứa căn thức)">Bài toán rút gọn và tính biểu thức (chứa căn thức)</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Căn bậc 3">Căn bậc 3</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Lập phương">Lập phương</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Đại số - Hàm số bậc nhất">Đại số - Hàm số bậc nhất</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hàm đồng biến">Hàm đồng biến</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Hàm nghịch biến">Hàm nghịch biến</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Đường thẳng">Đường thẳng</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Đại số - Hàm số bậc hai một ẩn">Đại số - Hàm số bậc hai một ẩn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Vẽ đồ thị - Parabol">Vẽ đồ thị - Parabol</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Phương trình bậc hai">Phương trình bậc hai</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Phương trình trùng phương">Phương trình trùng phương</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Phương trình chủa ẩn mẫu thức">Phương trình chủa ẩn mẫu thức</label>
                    </div>
                    <div class="radio">
                        <label><input type="checkbox" name="diem_kien_thuc" disabled value="Đại số - Hệ hai phương trình bậc nhất hai ẩn">Đại số - Hệ hai phương trình bậc nhất hai ẩn</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tìm tọa độ mặt phẳng">Tìm tọa độ mặt phẳng</label>
                    </div>
                    <div class="radio tab">
                        <label><input type="checkbox" name="diem_kien_thuc" value="Tìm đường thẳng">Tìm đường thẳng</label>
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
<script src="{{url('/js/select2.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.class_input').select2();
        $('.subject_input').select2();
        $('.category_input').select2();
        $('.tap_input').select2();
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

        let old_dkt = '{{$profiles['diem_kien_thuc']}}';
        old_dkt = old_dkt.split(';');

        $.each($("input[name='diem_kien_thuc']"), function(){
            if(old_dkt.indexOf($(this).val()) !== -1) {
                $(this).prop("checked", true);
            }
        });

        let check_count = 0;

        $("input[name='diem_kien_thuc']").click(function(){
            let value = $(this).val();

            if(value === 'Không xác định'){
                $.each($("input[name='diem_kien_thuc']:checked"), function(){
                    if($(this).val() !== 'Không xác định') $(this).prop("checked", false);
                });

                check_count = 1;
            }else{
                $.each($("input[name='diem_kien_thuc']:checked"), function(){
                    if($(this).val() === 'Không xác định') {
                        if($(this).is(':checked') === true) check_count--;

                        $(this).prop("checked", false);
                    }
                });

                if($(this).is(':checked') === true){
                    if(check_count >= 5){
                        toastr.error("Bạn chỉ được chọn tối đa 5 điểm kiến thức!");
                        $(this).prop("checked", false);
                    }else{
                        check_count++;
                    }
                }else{
                    check_count--;
                }
            }

        });

        $("#btn-edit").click(function(){
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
            $.each($("input[name='diem_kien_thuc']:checked"), function(){
                diem_kien_thuc.push($(this).val());
            });
            diem_kien_thuc = diem_kien_thuc.join(";");

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
    });
</script>
@endpush
