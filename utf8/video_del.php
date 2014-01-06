<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once dirname(__FILE__) . '/spark_config.php';
require_once dirname(__FILE__) . '/class/spark_function.php';
$time = time();
$info = array();
$info['videoid'] = $_GET['videoid'];
$key = $spark_config['key'];
$url = $spark_config['api_deletevideo'] . '?' . spark_function::get_hashed_query_string($info, $time, $key);
$result_xml = spark_function::url_get_xml($url);
$result = spark_function::parse_videos_xml($result_xml);

if ($result[""][0] == 'OK') {
	echo "删除成功，请同步视频查看结果";
} else {
	echo "删除失败!";
}
?>
 
