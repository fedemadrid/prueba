<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

//si inicio sesion y no es usuario
if  ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() != 2 ))
{
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir); 
  $twig = new Twig_Environment($loader);
  
  if ($_SESSION["usr"]->getPerfilUsuarioId() == 1)
  {	
    $template = $twig->loadTemplate('sitio/back-end_layout.twig');
  }
  else
  {
    $template = $twig->loadTemplate('sitio/back-end_layout_secretario.twig');
  }

  $template->display(array('isset_view_page' => isset($view_page),
  		'username' => $_SESSION['usr']->getUsername(),
  		'titulo' => $conf->getNombre(),
  		'logueado' => isset($_SESSION['usr'])
  ));
}
else
  header('Location: index.php');