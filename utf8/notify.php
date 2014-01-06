<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ob_start();
require_once dirname(__FILE__) . '/spark_config.php';
require_once dirname(__FILE__) . '/class/spark_function.php';
require_once dirname(__FILE__) . '/storage.php';

/**
 * 功能：视频处理完成回调接口
 * 版本：1.0
 * 日期：2010-12-28
 * 作者：Eachcan, Kelystor
 */

// 注意：回调接口需判断数据来源是否有效

$info = array ();
//判断回调视频的状态，对回调参数进行验证
if ($_GET['status'] == 'OK') {
	$info = array (
		'videoid' => $_GET['videoid'],
		'status' => $_GET['status'],
		'duration' => $_GET['duration'],
		'image' => $_GET['image'],
		
	);
} else {
	$info = array (
		'videoid' => $_GET['videoid'],
		'status' => $_GET['status'],
	);
}

$qs_hash = spark_function::get_info_hash($info, $_GET['time'], $spark_config['key']);

$result = 'fail';
if ($qs_hash == $_GET['hash']) {	// 通过对hash值的判断，来确定数据来源的有效性
	$storage = new storage();
	if ($storage->save_url($_SERVER['QUERY_STRING'])) {
		$result = 'OK';
	}
}
ob_clean();
$content = <<<OT
<?xml version="1.0" encoding="UTF-8"?>
<result>$result</result>
OT;
header('Content-Type:text/xml');
echo $content;
