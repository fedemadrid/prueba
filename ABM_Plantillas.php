<?php 

require_once(dirname(__FILE__).'/lib/Autoload.php');
//si inicio sesion y es administrador
if ((isset($_SESSION['usr'])) && ($_SESSION["usr"]->getPerfilUsuarioId() == 1))
{
  //si edito una plantilla
  if (isset($_POST['submitEditar']))
  {
    $elementsNuevos = $_POST['selPHP'];
	if ($_POST['descripcion'] != null && count($elementsNuevos)>0)
	{
	  Item::deleteItemsFromPlantillaWithId($_POST['id']);
	  for ($i=0; $i<count($elementsNuevos); $i++)
	  {
	    Plantilla::agregarItemPlantilla($_POST['id'],$elementsNuevos[$i],$i+1);
	  }
	  $sheet = Plantilla::selectOneByID($_POST['id']);
	  $sheet->setDescripcion($_POST['descripcion']);
	  $sheet->setBorrado($_POST['borrado']);
	  $sheet->update();
	  $mensaje = "La plantilla se actualizo correctamente";
	}
	else 
	  header('Location: ABM_Plantillas.php');
  }
  //si agrego una plantilla
  if (isset($_POST['submitAgregar']))
  {
    $elements = $_POST['selPHP'];
 	if ($_POST['descripcion'] != null && count($elements)>0)
 	{
	  $sheet = new Plantilla();
	  $sheet->setDescripcion($_POST['descripcion']);
	  $sheet->create();
	  $lastSheet=Plantilla::selectLastPlantilla();
	  for ($i=0; $i<count($elements); $i++)    
	  { 
	    Plantilla::agregarItemPlantilla($lastSheet->getId(),$elements[$i],$i+1);
	  }
	  $mensaje = "La plantilla se creo correctamente";
	}
	else
	  header('Location: ABM_Plantillas.php');
  }
  $items = Item::select();
  $tipoItems = array();
  $categs = array();
  foreach ($items as $item)
  {
    $tipoItems[$item->getId()] = Tipo_Item::selectOneByIdTipoItem($item->getTipoItemId());
	$categs[$item->getId()] = Categoria_Item::selectDescripcionByID($item->getCategoriaId());
  }
  if (isset($_GET['editar']))
  {
    if ($editar = Plantilla::selectOneByID($_GET['editar']))
    {
	  $view_page = "plantilla/editar.twig";
	  $editarItemsPlantilla = Item::selectAllItemsByIdPlantilla($_GET['editar']);
	  $otrosItems = Item::selectOthersItemsByIdPlantilla($_GET['editar']);
	}
	else
	  header('Location: ABM_Plantillas.php');
  }
  elseif (isset($_GET['agregar']))
  {
    $view_page = "plantilla/agregar.twig";
  }
  // listo plantillas
  else
  {
    $plantillas = Plantilla::selectAll();
 	$view_page = "plantilla/listar.twig";
	$conf = Configuracion::select();
	$itemsxpag = $conf->getItemsxpag();
	$cantpag = intval (count($plantillas) / $itemsxpag);
	if ((count($plantillas) % $itemsxpag) > 0)
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
  //inicializacion twig
  $templateDir = "views";
  $loader = new Twig_Loader_Filesystem($templateDir);
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('sitio/back-end_layout.twig');
  $template->display(array('titulo' => $conf->getNombre(),
			'isset_view_page' => isset($view_page),
			'view_page' => $view_page,
			'username' => $_SESSION['usr']->getUsername(),
			'items' => $items,
			'categs' => $categs,
			'mensaje' => $mensaje,
			'tipoItems' => $tipoItems,
			'plantillas' => $plantillas,
			'hayMensaje' => isset($mensaje),
			'editarItemsPlantilla' => $editarItemsPlantilla,
			'editar' => $editar,
			'otrosItems' => $otrosItems,
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