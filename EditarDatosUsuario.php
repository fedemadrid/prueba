<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

$datos = array();
//$categ = Categoria_Item::select();
$plantillas = Plantilla::select();
// plantilla con id=1 es la por default
//$items = Item::selectAllItemsByIdPlantilla(1);
if (isset($_POST['submitEditarPlantilla']))
{
	$p=$_POST['plantilla'];
	$items = Item::selectAllItemsByIdPlantilla($p);
	foreach ($items as $item)
	{
		$datos[$item->getId()]=Dato_Item::selectAllByIDItem($item->getId(),$_SESSION['usr']->getId());
	}
	$view_page = "editarPlantilla_view.twig";
}
/*if (isset($_POST['submitEditarCategoria']))
{
  $c=$_POST['categoria'];
  $view_page = "editarCategoria_view.twig";
}*/

//inicializacion twig
$templateDir = "views/perfil";
$loader = new Twig_Loader_Filesystem($templateDir);
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('editarPerfil_view.twig');
$template->display(array('titulo' => $conf->getNombre(),
		'logueado' => isset($_SESSION['usr']),
		//'categ' => $categ,
		'isset_view_page' => isset($view_page),
		'view_page' => $view_page,
		'datos' => $datos,
		'items' => $items,
		//'c' => $c,
		'i' => $i,
		'p' => $p,
		'plantillas' => $plantillas
));

//include ('views/perfil/editarPerfil_view.twig');