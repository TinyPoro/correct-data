<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\PostHistory;
use Carbon\Carbon;

class WebController extends Controller
{
    public function reverse($text)
    {
        $text = str_replace("\r", ' ', $text);
        $text = str_replace("\t", ' ', $text);
        $text = str_replace(' ', ' ', $text);
//        $text = str_replace('
//', ' ', $text);
        $text = str_replace("\xc2\xa0", ' ', $text);
        $text = str_replace("&#13;", ' ', $text);

        $text = str_replace('<br />', '\n', $text);
        $text = str_replace('<br />', '\n', $text);

        if (preg_match_all('/<table>(.|\||\s)*?<\/table>/', $text, $matches)) {
            foreach ($matches[0] as $table_html) {
                $table_markdown = $this->htmlTableToMarkdown($table_html);
                $text = str_replace($table_html, $table_markdown, $text);
            }
        }

        //loại javascript
        $text = preg_replace('/<script[^>]*>.*?<\/script>/', '', $text);

        //chuyển số mũ thành dạng latext

        if(preg_match_all('/(?<=\s)([^\s>]+)\s*<sup\>([^<]+)<\/sup>/', $text, $matches)){
            foreach ($matches[0] as $k => $value){
                $co_so = $matches[1][$k];
                $he_so = $matches[2][$k];

                if($this->isValidSomu($co_so) && $this->isValidSomu($he_so)){
                    $latex = "\($co_so^$he_so\)";
                    $text = str_replace($value, $latex, $text);
                }
            }
        }

        if(preg_match_all('/(?<=\s)([^\s>]+)\s*<sub\>([^<]+)<\/sub>/', $text, $matches)){
            foreach ($matches[0] as $k => $value){
                $co_so = $matches[1][$k];
                $he_so = $matches[2][$k];

                if($this->isValidSomu($co_so) && $this->isValidSomu($he_so)){
                    $latex = "\($co_so"."_$he_so\)";
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
        if(preg_match_all('/<[^<>]*>/', $text, $matches)){

            foreach ($matches[0] as $tag_html){
                if(!preg_match('/<\s*img/', $tag_html)
                    && !preg_match('/<\s*table/', $tag_html)
                    && !preg_match('/<\/\s*table/', $tag_html)){

                    if(in_array($tag_html, $end_block_tags)) $text = str_replace($tag_html, '\n', $text);
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

        foreach ($remove_texts2 as $remove_text){
            $text = preg_replace('/^\s*'.$remove_text.'\s*:?\s*/ui', '', $text);
        }

        $text = preg_replace('/^\s*giải\s*:?\s*\\\n\s*/ui', '', $text);

        $text = htmlspecialchars_decode($text);
        $text = preg_replace('/(\s*\\\n\s*){2,}/', ' \n ', $text);
        $text = preg_replace("/\s{2,}/", ' ', $text);
        $text = str_ireplace("&nbsp;", ' ', $text);

        $text = str_replace('http://dev.data.giaingay.io/TestProject/public/media/', 'media/', $text);

        //loại \n đầu câu
        while (true){
            $text = trim($text);

            if(mb_strpos($text, '\n') === 0) $text = mb_substr($text, 2);
            else break;
        }

        //loại \n cuối câu
        while (true){
            $text = trim($text);

            if(mb_strrpos($text, '\n') === mb_strlen($text) - 2) $text = mb_substr($text, 0, mb_strlen($text) - 2);
            else break;
        }

        $text = trim($text);

        return $text;
    }
    
    public function removeEndl($text){
        if (preg_match_all('/<p>(&nbsp;)*<\/p>\n( )*(\n)*( )*/', $text, $matches)) {
            foreach ($matches[0] as $space_text) {
                $text = str_ireplace($space_text, '', $text);
            }
        }
        return $text;
    }

    public function brToEndlLatex($text) {
        $ok = 0;
        $ntext = '';
        for($i=0; $i<strlen($text); $i++){
            if($ok == 1 && $text[$i] == '<' && $text[$i+1] == 'b' && $text[$i+2] == 'r' && $text[$i+3] == '/' && $text[$i+4] == '>'){
                $ntext = $ntext . '\\\\';
                $i+=4;
                continue;
            }
            if($text[$i] == '\\' && $text[$i+1] == '(')
                $ok = 1;
            if($text[$i] == '\\' && $text[$i+1] == ')')
                $ok = 0;
            $ntext .= $text[$i];
        }
        return $ntext;
    }

    public function endlToBr($text)
    {
        $text = str_replace('\nolimits', '\zolimits', $text);
        $text = str_replace('\neq', '\zeq', $text);
        $text = str_replace('\ne', '\ze', $text);
        $text = str_replace('\n', '<br/>', $text);
        $text = str_replace('\zolimits', '\nolimits', $text);
        $text = str_replace('\zeq', '\neq', $text);
        $text = str_replace('\ze', '\ne', $text);

        

        $text = str_replace('media/', 'http://dev.data.giaingay.io/TestProject/public/media/', $text);

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
        if(preg_match_all('/\s{2,}/', $text, $matches)){
            foreach ($matches[0] as $space_text){
                $replace = str_repeat('&nbsp;', strlen($space_text));

                $text = str_ireplace($space_text, $replace, $text);
            }
        }
        return $text;
    }

    public function index(Request $request)
    {
        $post = DB::table('all_posts')->first();
        if ($post == null)
            return view('404');
        return redirect('/' . 'post' . '/' . $post->id . '/edit');
    }

    public function editPost($postId, Request $request)
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
            $history->de_bai = $this->endlToBr(json_decode($history->content)->de_bai);
            $history->dap_an = $this->endlToBr(json_decode($history->content)->dap_an);
            $history->created = date('H:i d-m-Y', strtotime($history->created_at . ' + 10 minutes'));
            return $history;
        });
        $data['histories_json'] = json_encode($data['histories']);
        return view('welcome', ['post' => $post, 'histories' => $data['histories']]);
    }

    public function rawHistory($postId, Request $request) {
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
            $history->created = date('H:i d-m-Y', strtotime($history->created_at . ' + 10 minutes'));
            return $history;
        });
        $data['histories_json'] = json_encode($data['histories']);
        return view('raw', $data);
    }

    public function editPostApi($postId, Request $request)
    {
        $post = Post::find($postId);

        $request->de_bai = $this->reverse($request->de_bai);
        $request->dap_an = $this->reverse($request->dap_an);

        $count = PostHistory::where('post_id', $postId)->count();
        if ($count == 6) {
            $h = PostHistory::where('post_id', $postId)->orderBy('created_at', 'asc')->first();
            $h->delete();
        }
        $history = new PostHistory();
        $history->post_id = $post->id;
        // $history->de_bai = str_replace('\r', '', $post->de_bai);
        // $history->dap_an = str_replace('\r', '', $post->dap_an);
        $history->de_bai = $post->de_bai;
        $history->dap_an = $post->dap_an;
        $history->content = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $history->save();

        $post->de_bai = $request->de_bai;
        $post->dap_an = $request->dap_an;
        $post->tieu_de = $request->tieu_de;
        $post->updated_at = date('Y-m-d H:i:s', strtotime(Carbon::now() . '+ 10 minutes'));

        $post->save();
        return ['message' => 'success'];
    }

    public function escapeSlash($text)
    {
        $next = '';
        for ($i = 0; $i < strlen($text); ++$i) {
            if ($text[$i] == '\\' && ($text[$i + 1] == '(' || $text[$i + 1] == ')')) {
                $next .= '\\\\' . $text[$i + 1];
                $i += 1;
            } else $next .= $text[$i];
        }
        return $next;
    }
    public function htmlTableToMarkdown($text) {
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
                    $max = max($max, strlen($array[$j][$i]));
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
                }
                else if ($i != count($array) - 1) {
                    $table .= PHP_EOL;
                }
            }
            $table .= '</table>';
            return $table;
        }
        return '';
    }
}
