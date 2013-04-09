<?php
	
require_once(dirname(__FILE__).'/lib/Autoload.php');

//si inicio sesion y es administrador
if ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() == 1))
{
  //si edito una categoria
  if (isset($_POST['submitEditar']))
  {
    $cat = Categoria_Item::selectOneByID($_POST['id']);
    // si no modifico el nombre
    if ($cat->getDescripcion() == $_POST['descripcion'])
    {
      if ($_POST['padre_id']==0)
        $_POST['padre_id']= NULL;
  	  $cat->setCategoriaPadreId($_POST['padre_id']);
  	  $cat->setBorrado($_POST['borrado']);
  	  $cat->update();
 	  $mensaje = "La actualizacion se realizo correctamente";
  	}
  	else
  	{
  	  if (Categoria_Item::selectOneByDescripcion($_POST['descripcion']))
  	  {
  	    $mensaje = "ERROR: Nombre de categoria ya existente, por favor elija otro";
  	  }
  	  else
  	  {
  	    $cat->setDescripcion($_POST['descripcion']);
  	    if ($_POST['padre_id']==0)
  		  $_POST['padre_id']= NULL;
  		$cat->setCategoriaPadreId($_POST['padre_id']);
  		$cat->setBorrado($_POST['borrado']);
	  	$cat->update();	 				
	  	$mensaje = "La actualizacion se realizo correctamente";
  	  }
  	}
  }  	
  if (isset($_POST['submitAgregar']))
  {
    if (Categoria_Item::selectOneByDescripcion($_POST['descripcion']))
  	{
  	  $mensaje = "ERROR: Nombre de categoria ya existente, por favor elija otro";  			
  	}
    else
    {
      $cat = new Categoria_Item();
  	  $cat->setDescripcion($_POST['descripcion']);
  	  if ($_POST['padre_id']==0)
  	    $_POST['padre_id']= NULL;
  	  $cat->setCategoriaPadreId($_POST['padre_id']);
  	  $cat->setBorrado($_POST['borrado']);
  	  $cat->create();
	  $mensaje = "La categoria se agrego correctamente";
    }
  }
  if (isset($_GET['editar']))
  {
    if ($editar = Categoria_Item::selectOneByID($_GET['editar']))
  	  $view_page = "categoria_item/editar.twig";
  	else
  	  header('Location: ABM_CategoriasItem.php');  						  				
  }
  elseif (isset($_GET['agregar']))
  {
    $view_page = "categoria_item/agregar.twig";
  }
  // listo categorias
  else
  {
  	$categs = Categoria_Item::selectAll();
  	$view_page = "categoria_item/listar.twig";
  	$conf = Configuracion::select();
	$itemsxpag = $conf->getItemsxpag();
  	$cantpag = intval (count($categs) / $itemsxpag);
  	if ((count($categs) % $itemsxpag) > 0)
  	  $cantpag++;
  	if ((isset($_GET['pagina'])) && (($_GET['pagina']) <= $cantpag))
  	{
  	  $inicio = ($itemsxpag * ($_GET['pagina'] - 1)) ;
  	}
  	else
  	{
  	  $inicio = 0;
  	}
  }
  $categorias = Categoria_Item::selectAll();
  $padres = array();
  foreach($categorias as $categoria)
  {
    if ($categoria->getCategoriaPadreId() != null)
  	  $padres[$categoria->getId()] = Categoria_Item::selectOneByID($categoria->getCategoriaPadreId());
  }
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('sitio/back-end_layout.twig');
  $template->display(array('titulo' => $conf->getNombre(),
  			'isset_view_page' => isset($view_page),
  			'view_page' => $view_page,
  			'username' => $_SESSION['usr']->getUsername(),
  			'editar' => $editar,
			'categorias' => $categorias,
  			'padres' => $padres,
  			'hayMensaje' => isset($mensaje),
  			'mensaje' => $mensaje,
  			'categs' => $categs,
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