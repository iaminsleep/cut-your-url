<?php
  require_once('../../requires/admin_functions.php');
  require_once('../../requires/default_functions.php');

  if(!$isAdmin) redirect(); /* данное действие могут выполнять только админы */
  
  $previousPage = $_SERVER['HTTP_REFERER'];

  $userId = $_GET['id'];
  
  if(!isset($userId) || empty($userId)) {
    $_SESSION['error'] = 'Произошла ошибка';
  }

  else {
    deleteLink($userId);
  }

  redirectTo($previousPage);