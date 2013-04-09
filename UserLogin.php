<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

if(isset($_REQUEST['login_ajax']) && $_REQUEST['login_ajax'])
{
  $esValido = Usuario::check($_REQUEST['username_login'], $_REQUEST['password_login']);
  if((trim($_REQUEST['username_login']) == '') || (trim($_REQUEST['password_login']) == ''))
  {
    $esValido = false;
  }
  if ($esValido)
  {
    $_SESSION['usr'] = Usuario::selectOneByUsername($_REQUEST['username_login']);
  	if ($_SESSION["usr"]->getPerfilUsuarioId() == 1)					
	  echo "admin";			
	elseif ($_SESSION["usr"]->getPerfilUsuarioId() == 3)
	  echo "sec";
	else
	  echo "usr";
  }
  else 
    echo "error";
}
else
{
  header('Location: index.php');
}