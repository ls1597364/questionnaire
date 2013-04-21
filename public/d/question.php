<?php

require 'Slim/Slim.php';
require 'RedBean/rb.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config(array(
	'templates.path'=>'./templates'));
	
$app->get('/question/', function() use ($app){
  R::setup('mysql:host=localhost;dbname=questionnaire','localhost','');
  $data = R::getAll( 'select * from questions' );
  $app->render('/question/listQuestion.php',$data);
});

$app->run();

?>