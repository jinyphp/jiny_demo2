<?php
const ROOT = "";
require __DIR__.ROOT."/vendor/autoload.php";

// DB를 초기화 합니다.
const DBINFO = "dbconf.php";
$db = \Jiny\Database\db_init(DBINFO);

$table = "board5";

$titleText = "셈플입력입니다.";
$data = [
    'regdate' => "aaaa",
    'title' => htmlspecialchars(strip_tags($titleText))
];
$db->table($table)->insert($data);

if ($rows = $db->table($table)->select(['regdate','title'])) {
    print_r($rows);
}
