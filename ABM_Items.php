<?php
	
require_once(dirname(__FILE__).'/lib/Autoload.php');
//si inicio sesion y es administrador
if ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() == 1))
{
  //si edito un item
  if (isset($_POST['submitEditar'])) 	
  {
    $it = Item::selectOneByID($_POST['id']);
    $it->setDescripcion($_POST['descripcion']);
    $it->setCategoriaId($_POST['categoria_id']);
    $it->setTipoItemId($_POST['tipo_item_id']);
    $it->setBuscable($_POST['buscable']);
    $it->setRepetible($_POST['repetible']);
    $it->setTipoInput($_POST['tipo_input']);
    $it->setBorrado($_POST['borrado']);
    $it->update();
    $mensaje = "La actualizacion se realizo correctamente";
  }
  if (isset($_POST['submitAgregar']))
  {
    $it = new Item();
    $it->setDescripcion($_POST['descripcion']);
    $it->setCategoriaId($_POST['categoria_id']);
    $it->setTipoItemId($_POST['tipo_item_id']);
    $it->setBuscable($_POST['buscable']);
    $it->setRepetible($_POST['repetible']);
    $it->setTipoInput($_POST['tipo_input']);
    $it->setBorrado($_POST['borrado']);
    $it->create();
    $lastIt=Item::selectLastItem();
    Plantilla::agregarItemPlantilla($lastIt->getId(),1);//1=id de plantilla default
    $mensaje = "El item se agrego correctamente";
  }
  if (isset($_GET['editar']))
  {
    if ($editar = Item::selectOneByID($_GET['editar']))
      $view_page = "item/editar.twig";
    else
      header('Location: ABM_Items.php');  						  				
  }
  elseif (isset($_GET['agregar']))
  {
    $view_page = "item/agregar.twig";
  }
  // listo items
  else
  {
    $items = Item::selectAll();
    $view_page = "item/listar.twig";
    $conf = Configuracion::select();
    $itemsxpag = $conf->getItemsxpag();
    $cantpag = intval (count($items) / $itemsxpag);
    if ((count($items) % $itemsxpag) > 0)
      $cantpag++;
    if ((isset($_GET['pagina'])) && (($_GET['pagina']) <= $cantpag))
    {
      $inicio = ($itemsxpag * ($_GET['pagina'] - 1)) ;
    }
    else
    {
      $inicio = 0;
    }  
    $tipoItems = array();
    $categs = array();
    foreach ($items as $item)
    {
      $tipoItems[$item->getId()] = Tipo_Item::selectOneByIdTipoItem($item->getTipoItemId());  	
      $categs[$item->getId()] = Categoria_Item::selectDescripcionByID($item->getCategoriaId());  
    }			
  }
  $categorias = Categoria_Item::selectAll();  	
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('sitio/back-end_layout.twig');
  $template->display(array('titulo' => $conf->getNombre(),
  			'isset_view_page' => isset($view_page),
  			'view_page' => $view_page,
  			'username' => $_SESSION['usr']->getUsername(),
  			'mensaje' => $mensaje,
  			'categorias' => $categorias,
  			'items' => $items,
  			'tipoItems' => $tipoItems,
  			'categs' => $categs,
  			'hayMensaje' => isset($mensaje),
  			'editar' => $editar,
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