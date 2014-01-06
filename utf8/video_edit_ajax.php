<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once dirname(__FILE__) . '/spark_config.php';
require_once dirname(__FILE__) . '/class/spark_function.php';
$time = time();
$info = array(); 
$info['videoid'] = $_GET['videoid'];
if($_GET['title']) {
	$info['title'] = $_GET['title'];
}
if($_GET['tag']) {
	$info['tag'] = trim($_GET['tag']);
}
if($_GET['description']) {
	$info['description'] = $_GET['description'];
}
if($_GET['categoryid']) {
	$info['categoryid'] = $_GET['categoryid'];
}
if($_GET['imageindex']) {
	$info['imageindex'] = $_GET['imageindex'];
}
$key = $spark_config['key'];
$url = $spark_config['api_editvideo'] . '?' . spark_function::get_hashed_query_string($info, $time, $key);
$result_xml = spark_function::url_get_xml($url);
$result = spark_function::parse_videos_xml($result_xml);
if ($result['video']['id']) {
	echo "<div style='color:red;'>编辑成功</div>请同步视频,查看编辑结果 &nbsp;&nbsp;<a href='videosync.php?videoidFrom=&videoidTo=' target='_self'>同步视频</a><br/><br/>";
} else {
	echo "编辑失败!";
}