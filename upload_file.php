<?php
/**
 * Created by PhpStorm.
 * User: TinyPoro
 * Date: 1/10/19
 * Time: 2:58 AM
 */

require __DIR__ . '/vendor/autoload.php';

$upload_file = $_FILES["upload"];
$img_path = $upload_file['tmp_name'];
$img_name = $upload_file['name'];

$id = $_POST['id'];
$type = $_POST['type'];

try{
    $image_server = 'http://dev.data.giaingay.io/TestProject/public/api/v1/upload_multipart2';

    $client = new \GuzzleHttp\Client();

    $response = $client->request('POST', $image_server, [
        'multipart' => [
            [
                'name'     => 'file',
                'contents' => file_get_contents($img_path),
            ],
            [
                'name'     => 'id',
                'contents' => $id
            ],
            [
                'name'     => 'type',
                'contents' => $type
            ],
        ],
    ]);

    $res = json_decode(trim($response->getBody()->getContents()));
    $new_img_path = $res->data;

    echo json_encode([
        "uploaded" => 1,
        "fileName" => $img_name,
        "url" => $new_img_path,
        "id" => $id,
        "type" => $type
    ]);
}catch (Exception $e){
    echo json_encode([
        "uploaded" => 0,
        "error" => $e->getMessage()
    ]);
}



//}