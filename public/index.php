<?php
  defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../app'));
  require(APPLICATION_PATH.'/config/config.php');
  $page = $functions -> getPageName();
  $model = $config['MODEL_PATH'].$page.'.php';
  $view = $config['VIEW_PATH'].$page.'.php';
  $controller = $config['CONTROLLER_PATH'].$page.'.php';
  $fileNotFound = $config['VIEW_PATH'].'404.php';

  if(file_exists($model)){
    require $model;
  }
  if (file_exists($controller)) {
    require $controller;
  }

  $mainContent = $fileNotFound;
  if (file_exists($view)) {
    $mainContent = $view;
  }
  
  include $config['VIEW_PATH'].'layout.php';
?>
