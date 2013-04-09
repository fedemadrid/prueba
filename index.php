<?php
require_once(dirname(__FILE__).'/lib/Autoload.php');
$tienePermiso = false;
if (isset($_SESSION["usr"]))
{
  if (($_SESSION["usr"]->getPerfilUsuarioId() == 1) || ($_SESSION["usr"]->getPerfilUsuarioId() == 3))
  {
    $tienePermiso = true;
  }
}
$i = 0;
$users = array();
$usuarios = Usuario::selectAllUsers();
if (isset($_SESSION['usr'])) 
{
  //usuario registrado
  foreach ($usuarios as $usuario) 
  {
    if ($usuario->getPerfilUsuarioId()==2)
    {
      //el perfil del usuario es "usuario"
	  $users[$i] = $usuario;
	  $i++;
    }
  }
}
else
{
  foreach ($usuarios as $usuario)
  {
    //visitante
    if (($usuario->getCvPublico()==1) && ($usuario->getPerfilUsuarioId()==2))
    {
      //el usuario tiene perfil publico y su perfil es usuario
      $users[$i] = $usuario;
      $i++;
    }
  }
}
if (isset($_GET['buscar']))
{
  //realizar busqueda
  $busqueda = $_GET['buscar'];
  if ($busqueda=='')
  {
    header ('Location: index.php');
  }
  elseif (isset($_SESSION['usr']))
  {
    // usuario registrado
    if ($tienePermiso)
	  $resBusqueda=Usuario::buscarPorUnCampo($busqueda);
	else
	  $resBusqueda=Usuario::buscarPorUnCampoUsuarioCvPublico($busqueda);
  }
  else
  {
    //usuario no registrado
	$resBusqueda=Usuario::buscarPorUnCampoUsuarioCvPublico($busqueda);
  }
  //paginacion
  $conf = Configuracion::select();
  $itemsxpag = $conf->getItemsxpag();
  $cantpag = intval (count($resBusqueda) / $itemsxpag);
  if ((count($resBusqueda) % $itemsxpag) > 0)
  	$cantpag++;
  if ((isset($_GET['pagina'])) && (($_GET['pagina']) <= $cantpag))
  {
  	$inicio = ($itemsxpag * ($_GET['pagina'] - 1)) ;
  }
  else {
  	$inicio = 0;
  }
  //paginacion
}
else
{
  $listadoUsuarios="usuarios_view.twig";
}

if (isset($_SESSION['usr']))
  $myId = $_SESSION['usr']->getId();
else
  $myId = null;

//inicializacion twig
$templateDir = "views";
$loader = new Twig_Loader_Filesystem($templateDir);
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('sitio/index_layout.twig');
$template->display(array('titulo' => $conf->getNombre(),
		'logueado' => isset($_SESSION['usr']), 
		'tienePermiso' => $tienePermiso,
		'myId' => $myId,
		'buscar' => isset($_GET['buscar']),
		'criterio' => $_GET['buscar'],
		'resBusqueda' => $resBusqueda,
		'listadoUsuarios' => $listadoUsuarios,
		'cantpag' => $cantpag,
		'inicio' => $inicio,
		'itemsxpag' => $itemsxpag,
		));