<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\PostHistory;
use Carbon\Carbon;
use App\ManualPost;

class ToolController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function editPost($postId)
    {
        $post = DB::table('all_posts')->where('id', 'LIKE BINARY', $postId)->first();
        if (!$post) {
            $post = DB::table('all_posts')->where('hoi_dap_id', $postId)->first();

            if (!$post) return view('404');
        }

        if($post->level == 'L8') return view('404');

        $post->de_bai = $this->endlToBr($post->de_bai);
        $post->dap_an = $this->endlToBr($post->dap_an);

        $data['post'] = $post;
        $data['histories'] = PostHistory::where('post_id', $post->id)->orderBy('created_at', 'desc')->get()->map(function ($history) {
            $history->de_bai = $this->endlToBr(json_decode($history->content)->de_bai);
            $history->dap_an = $this->endlToBr(json_decode($history->content)->dap_an);
            $history->created = date('H:i d-m-Y', strtotime($history->created_at));
            return $history;
        });

        $images = [];

//        if($post->ten_nguon == 'TimKiem') {
//            $tutorLink = $post->url;
//
//            if(preg_match('/\d+$/', $tutorLink, $matches)) {
//                $tutorId = $matches[0];
//
//                $tutorGetImageApiUrl = "http://apis.giaingay.io/giaingay/api/v2/sources/$tutorId/image";
//
//                $client = new Client();
//                try{
//                    $response = $client->request('GET', $tutorGetImageApiUrl);
//                    $res = json_decode($response->getBody()->getContents());
//
//                    $tutorImage = $res->data->url;
//
//                    $images[] = $tutorImage;
//                } catch (GuzzleException $e) {
//                    \Log::error($e->getMessage());
//                } catch (\Exception $e){
//                    \Log::error($e->getMessage());
//                }
//            }
//        }

//        if($post->ten_nguon == 'SachThuong' or $post->ten_nguon == 'pdf') {
//            $extra_info = $post->tieu_de;
//
//            if(preg_match('/([A-Z]{4})([0-9]{12})/', $extra_info, $book_code_matches)) {
//                $book_code = $book_code_matches[0];
//
//                if(preg_match_all('/(?<=trang)[\s\d-,_]+/ui', $extra_info, $matches)){
//                    $page_numbers = $matches[0];
//
//                    $page_numbers = array_map(function($page_number){
//                        $del = ['-', ',', '_'];
//
//                        $page_number = preg_replace('/\s/', '', $page_number);
//                        $page_number = explode( $del[0], str_replace($del, $del[0], $page_number) );
//                        $page_number = array_filter($page_number);
//
//                        return $page_number;
//                    }, $page_numbers);
//
//                    $numbers = [];
//                    foreach ($page_numbers as $page_number){
//                        $numbers = array_merge($numbers, $page_number);
//                    }
//                    $page_numbers = $numbers;
//
//                    $page_numbers = array_unique($page_numbers);
//
//                    foreach ($page_numbers as $page_number){
//                        $page_number = str_pad($page_number,4,"0",STR_PAD_LEFT);
//                        $images[] = "http://dev.data.giaingay.io/anh-pdf/$book_code/$book_code%20-%20$page_number.jpg";
//                    }
//                }
//            }
//        }

        $images = explode(',', $post->url);

        return view('edit', [
            'post' => $post,
            'histories' => $data['histories'],
            'images' => $images
        ]);
    }

    public function updatePost($postId, Request $request)
    {
        $post = Post::find($postId);

        if(!$post) return ['message' => 'Invalid post id!'];

        $request->de_bai = $this->reverse($request->de_bai, $post->ten_nguon);
        $request->dap_an = $this->reverse($request->dap_an, $post->ten_nguon);

        $count = PostHistory::where('post_id', $postId)->count();
        if ($count == 6) {
            $h = PostHistory::where('post_id', $postId)->orderBy('created_at', 'asc')->first();
            $h->delete();
        }
        $history = new PostHistory();
        $history->post_id = $post->id;
        $history->de_bai = $post->de_bai;
        $history->dap_an = $post->dap_an;
        $history->content = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $history->save();

        $post->de_bai = $request->de_bai;
        $post->dap_an = $request->dap_an;
        $post->tieu_de = $request->tieu_de;
        $post->duong_dan_hoi = $request->duong_dan_hoi;
        $post->duong_dan_tra_loi = $request->duong_dan_tra_loi;
        $post->updated_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        $post->save();

        return ['message' => 'success'];
    }

    public function editLabelPost($postId)
    {
        $post = DB::table('all_posts')->where('id', 'LIKE BINARY', $postId)->first();
        if (!$post) {
            $post = DB::table('all_posts')->where('hoi_dap_id', $postId)->first();

            if (!$post) return view('404');
        }

        if($post->level != 'L8' && $post->level != 'L7') return view('404');

        if($post->profile_v2_id) return view('404', [
            'msg' => 'Item đã được gán profile loại 2!'
        ]);

        $post->de_bai = $this->endlToBr($post->de_bai);
        $post->dap_an = $this->endlToBr($post->dap_an);

        $profiles = \DB::table('profiles')->where('book_id', 'VNTK000000000107')->where('lesson', '<>', '')->get();
        $post_profile = \DB::table('profiles')->where('id', $post->profile_id)->first();

        return view('label', [
            'post' => $post,
            'post_profile' => $post_profile,
            'profiles' => $profiles
        ]);
    }

    public function editLabelPostV2($postId)
    {
        $post = DB::table('all_posts')->where('id', 'LIKE BINARY', $postId)->first();
        if (!$post) {
            $post = DB::table('all_posts')->where('hoi_dap_id', $postId)->first();

            if (!$post) return view('404');
        }

        if($post->level != 'L8' && $post->level != 'L7') return view('404');

        if($post->profile_id) return view('404', [
            'msg' => 'Item đã được gán profile loại 1!'
        ]);

        $post->de_bai = $this->endlToBr($post->de_bai);
        $post->dap_an = $this->endlToBr($post->dap_an);

        $profiles = \DB::table('profiles_v2')->where('book_id', 'VNTK000000000107')->get();
        $post_profile = \DB::table('profiles_v2')->where('id', $post->profile_v2_id)->first();

        $loais = [];
        foreach($profiles as $profile){
            $loais[] = $profile->loai;
        }
        $loais = array_unique($loais);

        return view('label_v2', [
            'post' => $post,
            'post_profile' => $post_profile,
            'profiles' => $profiles,
            'loais' => $loais
        ]);
    }

    public function updateLabelPost($postId, Request $request)
    {
        $post = Post::find($postId);

        if(!$post) return ['message' => 'Invalid post id!'];

        $post->updated_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        if($request->chapter && $request->ma_sach) {
            if($request->bai === 'null') $request->bai = '';

            $profile = \DB::table('profiles')
                ->where('book_id', $request->ma_sach)
                ->where('chapter', $request->chapter)
                ->where('lesson', $request->bai)->first();

            if(!$profile) {
                $book = \DB::table('pdf_book')->where('book_code', $request->ma_sach)->first();

                if(!$book){
                    $book_class = null;
                    $book_category = null;
                    $book_tap = null;
                    $book_inserted_by = null;
                    $book_inserted_date = null;
                    $book_modified_by = null;
                    $book_modified_date = null;
                }else{
                    $user = \DB::table('users')->where('id', $book->created_by)->first();
                    $book_name = $book->book_name;

                    if(preg_match('/(?<=tập)[\s\d]+/', $book_name, $matches)){
                        $book_tap = array_get($matches, 0, null);
                    }else{
                        $book_tap = null;
                    }

                    $book_class = 'lop_9';
                    $book_category = 'SBT';
                    $book_inserted_by = $user->name;
                    $book_inserted_date = $book->created_at;
                    $book_modified_by = $user->name;
                    $book_modified_date = $book->updated_at;
                }

                \DB::table('profiles')->insert([
                    'book_id' => $request->ma_sach,
                    'book_class' => $book_class,
                    'book_category' => $book_category,
                    'book_tap' => $book_tap,
                    'book_inserted_by' => $book_inserted_by,
                    'book_inserted_date' => $book_inserted_date,
                    'book_modified_by' => $book_modified_by,
                    'book_modified_date' => $book_modified_date,
                    'type' => $request->type,
                    'chapter' => $request->chapter,
                    'lesson' => $request->bai,
                    'knowledge_point' => $request->total_knowledge_point,
                ]);

                $profile = \DB::table('profiles')
                    ->where('lesson', $request->bai)
                    ->where('chapter', $request->chapter)
                    ->where('book_id', $request->ma_sach)
                    ->first();

            }

            $post->profile_id = $profile->id;

        }

        $post->knowledge_question = $request->knowledge_point;

        $post->hard_label = $request->hard_label;
        $post->knowledge_extra = $request->knowledge_extra;

        $post->save();

        return ['message' => 'success'];
    }

    public function updateLabelPostV2($postId, Request $request)
    {
        $post = Post::find($postId);

        if(!$post) return ['message' => 'Invalid post id!'];

        $post->updated_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        if($request->dang_bai) {
            $profile = \DB::table('profiles_v2')
                ->where('book_id', $request->ma_sach)
                ->where('dang_bai', $request->dang_bai)
                ->where('khu_vuc', $request->khu_vuc)
                ->where('loai', $request->loai)
                ->first();

            if(!$profile) {
                $book = \DB::table('pdf_book')->where('book_code', $request->ma_sach)->first();

                if(!$book){
                    $book_class = null;
                    $book_category = null;
                    $book_tap = null;
                    $book_inserted_by = null;
                    $book_inserted_date = null;
                    $book_modified_by = null;
                    $book_modified_date = null;
                }else{
                    $user = \DB::table('users')->where('id', $book->created_by)->first();
                    $book_name = $book->book_name;

                    if(preg_match('/(?<=tập)[\s\d]+/', $book_name, $matches)){
                        $book_tap = array_get($matches, 0, null);
                    }else{
                        $book_tap = null;
                    }

                    $book_class = 'lop_9';
                    $book_category = 'SBT';
                    $book_inserted_by = $user->name;
                    $book_inserted_date = $book->created_at;
                    $book_modified_by = $user->name;
                    $book_modified_date = $book->updated_at;
                }

                \DB::table('profiles_v2')->insert([
                    'book_id' => $request->ma_sach,
                    'book_class' => $book_class,
                    'book_category' => $book_category,
                    'book_tap' => $book_tap,
                    'book_inserted_by' => $book_inserted_by,
                    'book_inserted_date' => $book_inserted_date,
                    'book_modified_by' => $book_modified_by,
                    'book_modified_date' => $book_modified_date,
                    'loai' => $request->loai,
                    'khu_vuc' => $request->khu_vuc,
                    'dang_bai' => $request->dang_bai,
                    'knowledge_point' => $request->total_knowledge_point,
                ]);

                $profile = \DB::table('profiles_v2')
                    ->where('dang_bai', $request->dang_bai)
                    ->where('khu_vuc', $request->khu_vuc)
                    ->where('loai', $request->loai)
                    ->where('book_id', $request->ma_sach)
                    ->first();

            }

            $post->profile_v2_id = $profile->id;

        }

        $post->knowledge_question = $request->knowledge_point;

        $post->hard_label = $request->hard_label;
        $post->knowledge_extra = $request->knowledge_extra;
        $post->do_kho = $request->do_kho;
        $post->giao = $request->giao;
        $post->kiem_tra = $request->kiem_tra;
        $post->muc_tieu = $request->muc_tieu;

        $post->save();

        return ['message' => 'success'];
    }

    private $white_lists = ['DeThi', 'SachThuong', 'Chuyen', 'VoBaiTap', 'TimKiem'];

    public function createPost(Request $request)
    {
        $next_guid = str_random(9).uniqid('', true);

        $profiles = \DB::table('profiles')->where('lesson', '<>', '')->get();

        $src = $request->has('src') ? $request->get('src') : 'manual';

        if(!in_array($src, $this->white_lists)){
            return view('404', [
                'msg' => 'Tên nguồn không hợp lệ!'
            ]);
        }

        return view('create', [
            "guid" => str_pad($next_guid,32,"0",STR_PAD_LEFT),
            'profiles' => $profiles,
            'src' => $src
        ]);
    }

    public function storePost(Request $request) {
        if(!in_array($request->ten_nguon, $this->white_lists)){
            return view('404', [
                'msg' => 'Tên nguồn không hợp lệ!'
            ]);
        }

        $request->de_bai = $this->reverse($request->de_bai);
        $request->dap_an = $this->reverse($request->dap_an);
        $manualPost = new ManualPost();
        $manualPost->title = $request->tieu_de;
        $manualPost->url = $request->hoi_dap_id;
        $manualPost->subject_html = $request->de_bai;
        $manualPost->content_html = $request->dap_an;
        $manualPost->hoi_dap_id = $request->hoi_dap_id;
        $manualPost->crawler = $request->ten_nguon;
        $manualPost->data = '';
        $manualPost->save();

        \DB::table('all_posts')->insert([
            'hoi_dap_id' => $request->hoi_dap_id,
            'tieu_de' => $request->tieu_de,
            'url' => '',
            'de_bai' => $request->de_bai,
            'dap_an' => $request->dap_an,
            'ten_nguon' => $request->ten_nguon,
            'type' => 'D-',
            'duong_dan_hoi' => 'media/'.$request->hoi_dap_id.'-CH-01.jpg',
            'duong_dan_tra_loi' => 'media/'.$request->hoi_dap_id.'-DA-01-D.jpg',
        ]);

        return ['message' => 'success'];

    }

    public function rawHistory($postId, Request $request)
    {
        $post = DB::table('all_posts')->where('id', $postId)->first();
        if ($post == null) {
            $post = DB::table('all_posts')->where('hoi_dap_id', $postId)->first();
            if ($post == null)
                return view('404');
        }

        $post->de_bai = $this->endlToBr($post->de_bai);
        $post->dap_an = $this->endlToBr($post->dap_an);

        $data['post'] = $post;
        $data['histories'] = PostHistory::where('post_id', $postId)->orderBy('created_at', 'desc')->get()->map(function ($history) {
            $history->de_bai = json_decode($history->content)->de_bai;
            $history->dap_an = json_decode($history->content)->dap_an;
            $history->created = date('H:i d-m-Y', strtotime($history->created_at));
            return $history;
        });
        $data['histories_json'] = json_encode($data['histories']);
        return view('test.raw', $data);
    }

    public function reverse($text)
    {
        $text = str_replace("\r", ' ', $text);
        $text = str_replace("\t", ' ', $text);
        $text = str_replace(' ', ' ', $text);

        $text = str_replace("\xc2\xa0", ' ', $text);
        $text = str_replace("&#13;", ' ', $text);

        $text = str_replace('<br />', '\n', $text);
        $text = str_replace('<br />', '\n', $text);

        if (preg_match_all('/<table(.*)>(.|\||\s)*?<\/table>/', $text, $matches)) {
            foreach ($matches[0] as $table_html) {
                $table_markdown = $this->htmlTableToMarkdown($table_html);
                $text = str_replace($table_html, $table_markdown, $text);
            }
        }

        //loại javascript
        $text = preg_replace('/<script[^>]*>.*?<\/script>/', '', $text);

        //chuyển số mũ thành dạng latext

        if (preg_match_all('/(?<=\s)([^\s>]+)\s*<sup\>([^<]+)<\/sup>/', $text, $matches)) {
            foreach ($matches[0] as $k => $value) {
                $co_so = $matches[1][$k];
                $he_so = $matches[2][$k];

                if ($this->isValidSomu($co_so) && $this->isValidSomu($he_so)) {
                    $latex = "\($co_so^$he_so\)";
                    $text = str_replace($value, $latex, $text);
                }
            }
        }

        if (preg_match_all('/(?<=\s)([^\s>]+)\s*<sub\>([^<]+)<\/sub>/', $text, $matches)) {
            foreach ($matches[0] as $k => $value) {
                $co_so = $matches[1][$k];
                $he_so = $matches[2][$k];

                if ($this->isValidSomu($co_so) && $this->isValidSomu($he_so)) {
                    $latex = "\($co_so" . "_$he_so\)";
                    $text = str_replace($value, $latex, $text);
                }
            }
        }

        $end_block_tags = [
            '</p>',
            '</h1>',
            '</h2>',
            '</h3>',
            '</h4>',
            '</h5>',
            '</h6>',
            '</ol>',
            '</ul>',
            '</pre>',
            '</address>',
            '</blockquote>',
            '</dl>',
            '</div>',
            '</fieldset>',
            '</form>',
            '</hr>',
            '</noscript>',
            '</table>',
            '<br>',
            '<br/>',
        ];

        //loại tag text
        if (preg_match_all('/<[^<>]*>/', $text, $matches)) {

            foreach ($matches[0] as $tag_html) {
                if (!preg_match('/<\s*img/', $tag_html)
                    && !preg_match('/<\s*table/', $tag_html)
                    && !preg_match('/<\/\s*table/', $tag_html)) {

                    if (in_array($tag_html, $end_block_tags)) $text = str_replace($tag_html, '\n', $text);
                    else $text = str_replace($tag_html, ' ', $text);
                }
            }
        }

        //loại text thừa đầu câu
        $remove_texts2 = [
            'Lời giải chi tiết',
            'Lời giải',
            'Hướng dẫn giải',
            'GỢI Ý LÀM BÀI',
            'Trả lời',
            'Phương pháp giải - Xem chi tiết',
            'Hướng dẫn giải',
            'Hướng dẫn',
            'Đáp án chi tiết',
            'Đáp án',
            'BÀI THAM KHẢO',
            'Bài Tham Khảo',
            'Hướng dẫn trả lời'
        ];

        foreach ($remove_texts2 as $remove_text) {
            $text = preg_replace('/^\s*' . $remove_text . '\s*:?\s*/ui', '', $text);
        }

        $text = preg_replace('/^\s*giải\s*:?\s*\\\n\s*/ui', '', $text);

        $text = htmlspecialchars_decode($text);
        $text = preg_replace('/(\s*\\\n\s*){2,}/', ' \n ', $text);
        $text = preg_replace("/\s{2,}/", ' ', $text);
        $text = str_ireplace("&nbsp;", ' ', $text);

        //Xử lý link ảnh
        $bucket = config('filesystems.disks.s3.bucket');
        $region = config('filesystems.disks.s3.region');

        $text = str_replace('https://s3-' . $region . '.amazonaws.com/' . $bucket . '/data/format2/media/', 'media/', $text);
        $text = str_replace('Problems/problem_id_', 'Problems/', $text);
        $text = str_replace('Solutions/solution_id_', 'Solutions/', $text);

        $text = str_replace('http://dev.data.giaingay.io/TestProject/public/media/', 'media/', $text);

        //loại \n đầu câu
        while (true) {
            $text = trim($text);

            if (mb_strpos($text, '\n') === 0) $text = mb_substr($text, 2);
            else break;
        }

        //loại \n cuối câu
        while (true) {
            $text = trim($text);

            if (mb_strrpos($text, '\n') === mb_strlen($text) - 2) $text = mb_substr($text, 0, mb_strlen($text) - 2);
            else break;
        }

        $text = trim($text);

        return $text;
    }
    public function brToEndlLatex($text)
    {
        $ok = 0;
        $ntext = '';
        for ($i = 0; $i < mb_strlen($text); $i++) {
            if ($ok == 1 && mb_substr($text,$i,1) == '<' && mb_substr($text,$i+1,1) == 'b' && mb_substr($text,$i+2,1) == 'r' && mb_substr($text,$i+3,1) == '/' && mb_substr($text,$i+4,1) == '>') {
                $ntext = $ntext . '\\\\';
                $i += 4;
                continue;
            }
            if (mb_substr($text,$i,1) == '\\' && mb_substr($text,$i+1,1) == '(')
                $ok = 1;
            if (mb_substr($text,$i,1) == '\\' && mb_substr($text,$i+1,1) == ')')
                $ok = 0;
            $ntext .= mb_substr($text,$i,1);
        }
        return $ntext;
    }
    public function endlToBr($text)
    {
        $text = str_replace('\nolimits', '\zolimits', $text);
        $text = str_replace('\notin', '\zotin', $text);
        $text = str_replace('\nleq', '\zleq', $text);
        $text = str_replace('\ngeq', '\zgeq', $text);
        $text = str_replace('\neq', '\zeq', $text);
        $text = str_replace('\ne', '\ze', $text);
        $text = str_replace('\n', '<br/>', $text);
        $text = str_replace('\zolimits', '\nolimits', $text);
        $text = str_replace('\zotin', '\notin', $text);
        $text = str_replace('\zleq', '\nleq', $text);
        $text = str_replace('\zgeq', '\ngeq', $text);
        $text = str_replace('\zeq', '\neq', $text);
        $text = str_replace('\ze', '\ne', $text);

        // Xử lý ảnh
        if(preg_match_all('/<img[^>]*>/', $text, $matches)){

            foreach ($matches[0] as $img_html){
                if(preg_match('/src="[^"]+"/', $img_html, $matches)){
                    $src_html = $matches[0];

                    if(strpos($src_html, '.css') !== false
                        or strpos($src_html, '.js') !== false ){
                    }else{
                        if(preg_match('/(?<=src=").*(?=")/', $src_html, $matches)){
                            $src = $matches[0];

                            $bucket = config('filesystems.disks.s3.bucket');
                            $region = config('filesystems.disks.s3.region');

                            $new_src = str_replace('media/', 'https://s3-' . $region . '.amazonaws.com/' . $bucket . '/data/format2/media/', $src);
                            $new_src = str_replace('Problems/', 'Problems/problem_id_', $new_src);
                            $new_src = str_replace('Solutions/', 'Solutions/solution_id_', $new_src);

                            $handle = curl_init($new_src);
                            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

                            /* Get the HTML or whatever is linked in $url. */
                            curl_exec($handle);

                            /* Check for 404 (file not found). */
                            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                            if($httpCode == 404) {
                                $new_src = str_replace('media/', 'http://dev.data.giaingay.io/TestProject/public/media/', $src);
                            }

                            curl_close($handle);

                            $text = str_replace($src, $new_src, $text);

                        }
                    }

                }
            }
        }

        // parse markdown table to html
        $parser = new \cebe\markdown\MarkdownExtra();
        if (preg_match_all('/<table>(.|\||\s)*?<\/table>/', $text, $matches)) {
            foreach ($matches[0] as $table_html) {
                $html = $table_html;
                $html = str_replace(['<table>', '</table>'], '', $html);
                // preserve latex form after parse
                $html = $this->escapeSlash($html);
                $html = $parser->parse($html);

                if (preg_match_all('/(\[\d+\]):\s*([^\[\<]+)/', $html, $matches)) {
                    foreach ($matches[0] as $j => $markdown_link) {
                        $number = '![]' . $matches[1][$j];
                        $image_html = '<img src="' . $matches[2][$j] . '"/>';

                        $html = str_replace($markdown_link, '', $html);
                        $html = str_replace($number, $image_html, $html);
                    }
                }
                $html = str_replace("&lt;br/&gt;", "<br/>", $html);
                $text = str_replace($table_html, $html, $text);
            }
        }

        $text = $this->brToEndlLatex($text);
        if (preg_match_all('/\s{2,}/', $text, $matches)) {
            foreach ($matches[0] as $space_text) {
                $replace = str_repeat('&nbsp;', mb_strlen($space_text));

                $text = str_ireplace($space_text, $replace, $text);
            }
        }
        return $text;
    }
    public function escapeSlash($text)
    {
        $next = '';
        for ($i = 0; $i < mb_strlen($text); ++$i) {
            if (mb_substr($text,$i,1) == '\\' && (mb_substr($text,$i+1,1) == '(' || mb_substr($text,$i+1,1) == ')')) {
                $next .= '\\\\' . mb_substr($text,$i+1,1);
                $i += 1;
            } else $next .= mb_substr($text,$i,1);
        }
        return $next;
    }
    public function htmlTableToMarkdown($text)
    {
        if (preg_match_all('/<tr>(.|\||\s)*?<\/tr>/', $text, $matches)) {
            $array = [];
            foreach ($matches[0] as $trtag) {
                if (preg_match_all('/(<th>|<td>)(.|\||\s)*?(<\/th>|<\/td>)/', $trtag, $item_matches)) {
                    $item_matches[0] = array_map(function ($item) {
                        $item = str_replace('<th>', '', $item);
                        $item = str_replace('</th>', '', $item);
                        $item = str_replace('<td>', '', $item);
                        $item = str_replace('</td>', '', $item);
                        $item .= '\n';
                        return $item;
                    }, $item_matches[0]);
                    array_push($array, $item_matches[0]);
                }
            }
            $th = true;
            $col_width = [];
            for ($i = 0; $i < count($array[0]); ++$i) {
                $max = 1;
                for ($j = 0; $j < count($array); ++$j)
                    $max = max($max, mb_strlen($array[$j][$i]));
                array_push($col_width, $max);
            }
            $table = '<table>';
            for ($i = 0; $i < count($array); ++$i) {
                $table .= '| ';
                $separator = '| ';
                for ($j = 0; $j < count($array[0]); ++$j) {
                    $table .= $array[$i][$j];
                    $separator .= str_repeat('-', $col_width[$j]);
                    if ($j == count($array[0]) - 1) {
                        $table .= ' |';
                        $separator .= ' |';
                    } else {
                        $table .= ' | ';
                        $separator .= ' | ';
                    }
                }
                if ($i == 0) {
                    $table .= PHP_EOL;
                    $table .= $separator . PHP_EOL;
                } else if ($i != count($array) - 1) {
                    $table .= PHP_EOL;
                }
            }
            $table .= '</table>';
            return $table;
        }
        return '';
    }

    public function uploadFileItem(Request $request)
    {
        $data = $request->all();

        // Item id and item type
        $item_id = $data['id'];
        $typeItem = $data['type'];

        // Get image input
        $image = $request->file('upload');

        $image_dir = storage_path();
        $input_path = $this->newTmp(file_get_contents($image), $image_dir);
        $input_path = $this->renameImage($input_path);
        $input_path = $this->convertImage($input_path);

        try {
            // Config S3 to upload image
            $bucket = config('filesystems.disks.s3.bucket');
            $region = config('filesystems.disks.s3.region');
            $url = 'https://s3-' . $region . '.amazonaws.com/' . $bucket;

            // Image file name
            $imageFileName = basename($input_path);

            // Config disk
            $s3 = \Storage::disk('s3');

            $subTypeItemFolder = $typeItem == 'Solutions' ? 'solution_id_' : 'problem_id_';

            // File path store
            $filePath = '/data/format2/media/' . $typeItem . '/' . $subTypeItemFolder . $item_id . '/' . $imageFileName;

            $s3->put($filePath, file_get_contents($input_path), 'public');
            $url .= $filePath;
            return response()->json([
                "uploaded" => 1,
                "fileName" => $imageFileName,
                "url" => $url,
                "item_id" => $item_id,
                "type_item" => $typeItem
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "uploaded" => 0,
                "error" => [
                    "message" => $e->getMessage()
                ]
            ]);
        } finally {
//            unlink($input_path);
        }
    }

    function renameImage($originalImage)
    {
        $image_type = getimagesize($originalImage)['mime'];

        if ($image_type === 'image/jpeg')
            $new_name = "$originalImage.jpg";
        else if ($image_type === 'image/png')
            $new_name = "$originalImage.png";
        else if ($image_type === 'image/gif')
            $new_name = "$originalImage.gif";
        else if ($image_type === 'image/bmp')
            $new_name = "$originalImage.bmp";
        else
            $new_name = $originalImage;

        rename($originalImage, $new_name);

        return $new_name;
    }


    protected function newTmp($input = null, $dir, $is_content = true, $wm = 'w+'){

        $filename = tempnam($dir, 'Saven');

        if($input != null){
            if(is_resource($input)){
                $ft = fopen($filename, $wm);
                while($block = fread($input, 4096)){
                    fwrite($ft, $block);
                }
                fclose($ft);
            }elseif($is_content){
                file_put_contents($filename, $input);
            }else{
                $fi = fopen($input, 'rb');
                $ft = fopen($filename, 'wb');
                while($block = fread($fi, 4096)){
                    fwrite($ft, $block);
                }
                fclose($fi);
                fclose($ft);
            }
        }
        return $filename;
    }

    function convertImage($originalImage, $quality = 100)
    {
        $ext = exif_imagetype($originalImage);

        if ($ext === IMAGETYPE_JPEG) {
            $imageTmp=imagecreatefromjpeg($originalImage);
            $outputImage = str_replace('.jpeg', '.jpg', $originalImage);
        }
        else if ($ext === IMAGETYPE_PNG) {
            $imageTmp=imagecreatefrompng($originalImage);
            $outputImage = str_replace('.png', '.jpg', $originalImage);

        }
        else if ($ext === IMAGETYPE_GIF) {
            $imageTmp=imagecreatefromgif($originalImage);
            $outputImage = str_replace('.gif', '.jpg', $originalImage);

        }
        else if ($ext === IMAGETYPE_BMP) {
            $imageTmp=imagecreatefrombmp($originalImage);
            $outputImage = str_replace('.bmp', '.jpg', $originalImage);

        }
        else
            return $originalImage;

        // quality is a value from 0 (worst) to 100 (best)
        imagejpeg($imageTmp, $outputImage, $quality);
        imagedestroy($imageTmp);

        if($originalImage != $outputImage) unlink($originalImage);

        return $outputImage;
    }
}
