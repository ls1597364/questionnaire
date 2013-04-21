<?php
require 'Slim/Slim.php';
require 'RedBean/rb.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->config(array(
	'templates.path'=>'./templates'));
$app->get('/', function () use($app) {    
	$data = array(
		'title' => '性格心理測驗 - 你會假裝快樂嗎？',
		'heading' => '強顏歡笑對身體有害？那可不一定。<br>
					“假裝快樂”是一種快速調整情緒的好方法，可以使人們脫離不良情緒。<br>
					身與心是互動的，當心情無法調節時，<br>
					如果強迫自己做微笑的動作，你就會發現內心開始湧動歡喜。<br>
					所以假裝快樂也會變成真的開心。');    
		$app->render('/question/template.tpl',$data);}); 
$app->run();
<script src="js/jQuery_1.9.js"></script>
<script src="js/main.js"></script>
?>