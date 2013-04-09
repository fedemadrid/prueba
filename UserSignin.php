<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

if(isset($_REQUEST['signin_ajax']) && $_REQUEST['signin_ajax'])
{
  $vacio = false;
  $existe = Usuario::selectOneByUsername($_REQUEST['username_signin']);
  if((trim($_REQUEST['username_signin']) == '') || (trim($_REQUEST['password_signin']) == ''))
  {
    $vacio = true;
  }
  if ($vacio)
    echo "vacio";
  else 
  {
    if ($existe)
	{
	  echo "existente";
	}
	else
	{
	  $usr = new Usuario();
	  $usr->setUsername($_REQUEST['username_signin']);
	  $usr->setPassword($_REQUEST['password_signin']);
	  $usr->setPerfilUsuarioId(2);
	  $usr->setActivo(1);
	  $usr->setCvPublico(1);
	  $usr->create();
	  echo "creado";
	}
  }
}
else
  header('Location: index.php');