<?php 

require_once(dirname(__FILE__).'/lib/Autoload.php');
//si inicio sesion
if ( (isset($_SESSION['usr'])) )
{
  $ubic = Ubicacion::selectOneByID($_SESSION['usr']->getId());
  if (isset($_POST['submitEditar']))
  {
	if ($ubic == null)
	{
	  $ubic = new Ubicacion();
	  $ubic->setIdUsuario($_SESSION['usr']->getId());
	  $ubic->setLatitud($_POST['latitud']);
	  $ubic->setLongitud($_POST['longitud']);
      $ubic->create();
	}
	else
	{
	  $ubic->setLatitud($_POST['latitud']);
	  $ubic->setLongitud($_POST['longitud']);
	  $ubic->update();
	}
  }	
  $view_page = "sitio/miUbicacion.twig";
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('sitio/index_layout.twig');
  $template->display(array('view_page' => $view_page,
	'isset_view_page' => isset($view_page),
	'ubic' => $ubic,
	'logueado' => isset($_SESSION['usr']),
	'tienePermiso' => $tienePermiso,
	'isset_mi_ubicacion' => true		
  )); 
}
else
{
  header('Location: index.php');
}