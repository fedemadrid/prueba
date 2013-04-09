<?php
	
require_once(dirname(__FILE__).'/lib/Autoload.php');

//si inicio sesion y no es usuario
if  ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() != 2 ))
{
  // es administrador
  if ($_SESSION["usr"]->getPerfilUsuarioId() == 1)
  {
  	$loadTemp = "sitio/back-end_layout.twig";
    //si edito un usuario
  	if (isset($_POST['submitEditar']))
  	{
  	  $usr = Usuario::selectOneByID($_POST['id']);
  	  // si no modifico el nombre
  	  if ($usr->getUsername() == $_POST['username'])
  	  {
  	    $usr->setPassword($_POST['password']);
  	 	$usr->setPerfilUsuarioId($_POST['perfil_usuario_id']);
  		$usr->setCvPublico($_POST['cv_publico']);
  		$usr->setActivo($_POST['usr_act']);
  		$usr->update();
 		$mensaje = "La actualizacion se realizo correctamente";
  	  }
  	  else
  	  {
  	    if (Usuario::selectOneByUsername($_POST['username']))
  		{
  		  $mensaje = "ERROR: Nombre de usuario ya existente, por favor elija otro";
  		}
  		else
  		{
  		  $usr->setUsername($_POST['username']);
  		  $usr->setPassword($_POST['password']);
	  	  $usr->setPerfilUsuarioId($_POST['perfil_usuario_id']);
	  	  $usr->setCvPublico($_POST['cv_publico']);
	  	  $usr->setActivo($_POST['usr_act']);
	  	  $usr->update();
	 	  $mensaje = "La actualizacion se realizo correctamente";
  		}
  	  }
  	}
  	if (isset($_POST['submitAgregar']))
  	{
  	  if (Usuario::selectOneByUsername($_POST['username']))
  	  {
  	    $mensaje = "ERROR: Nombre de usuario ya existente, por favor elija otro";  			
  	  }
  	  else
  	  {
  	    $usr = new Usuario();
  	 	$usr->setUsername($_POST['username']);
  		$usr->setPassword($_POST['password']);
		$usr->setPerfilUsuarioId($_POST['perfil_usuario_id']);
		$usr->setCvPublico($_POST['cv_publico']);
		$usr->setActivo($_POST['usr_act']);
  		$usr->create();
	  	$mensaje = "El usuario se agrego correctamente";
  	  }
  	}
  	if (isset($_GET['editar']))
  	{
  	  if ($editar = Usuario::selectOneByID($_GET['editar'])){
  	  	$perfiles = Perfil::select();
  	  	$view_page = "usuario/editar.twig";  	  	
  	  }
  	  else
  		header('Location: ABM_Usuarios.php');  						  				
  	}
  	elseif (isset($_GET['agregar']))
  	{
  	  $perfiles = Perfil::select();
  	  $view_page = "usuario/agregar.twig";
  	}
  	// listo usuarios
  	else
  	{
  	  $usuarios = Usuario::selectAllUsers();
  	  $view_page = "usuario/listar.twig";
  	  $conf = Configuracion::select();
  	  $itemsxpag = $conf->getItemsxpag();
  	  
  	  $cantpag = intval (count($usuarios) / $itemsxpag);
  	  if ((count($usuarios) % $itemsxpag) > 0)
  	  	$cantpag++;
  	  //echo $cantpag;
  	  if ((isset($_GET['pagina'])) && (($_GET['pagina']) <= $cantpag))
  	  {
  	  	$inicio = ($itemsxpag * ($_GET['pagina'] - 1)) ;
  	  }
  	  else {
  	  	$inicio = 0;
  	  }
  	}
  	
  	//include (dirname(__FILE__).'/views/sitio/back-end_layout.twig');
  }
  // es secretario
  else
  {
  	$loadTemp = "sitio/back-end_layout_secretario.twig";
  	
    //si edito un usuario
  	if (isset($_POST['submitEditar']))
  	{
  	  $usr = Usuario::selectOneByID($_POST['id']);  		 				
  	  $usr->setCvPublico($_POST['cv_publico']);
  	  $usr->update();
      $mensaje = "La actualizacion se realizo correctamente";
  	}
  	if (isset($_GET['editar']))
  	{
  	  if ($editar = Usuario::selectOneByID($_GET['editar']))
  	  	$view_page = "usuario/editar_secretario.twig";  	  	
  	  else
  		header('Location: ABM_Usuarios.php');
  	}
  	// listo usuarios
  	else
  	{
  	  $usuarios = Usuario::selectAllUsers();
  	  $view_page = "usuario/listar_secretario.twig";
  	  $conf = Configuracion::select();
  	  $itemsxpag = $conf->getItemsxpag();
  	  $cantpag = intval (count($usuarios) / $itemsxpag);
  	  if ((count($usuarios) % $itemsxpag) > 0)
  	  	$cantpag++;
  	  //echo $cantpag;
  	  if ((isset($_GET['pagina'])) && (($_GET['pagina']) <= $cantpag))
  	  {
  	  	$inicio = ($itemsxpag * ($_GET['pagina'] - 1)) ;
  	  }
  	  else {
  	  	$inicio = 0;
  	  }
  	}
  }	
  
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate($loadTemp);
  $template->display(array('titulo' => $conf->getNombre(),
  		'isset_view_page' => isset($view_page),
  		'view_page' => $view_page,
  		'username' => $_SESSION['usr']->getUsername(),
  		'perfiles' => $perfiles,
  		'mensaje' => $mensaje,
  		'hayMensaje' => isset($mensaje),
  		'editar' => $editar,
  		'usuarios' => $usuarios,
  		'cantpag' => $cantpag,
  		'inicio' => $inicio,
  		'itemsxpag' => $itemsxpag,
  		'logueado' => isset($_SESSION['usr'])
  ));
  
}		
else
{
  header('Location: index.php');
}