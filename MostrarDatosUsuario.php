<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');

if (isset($_POST['submitEditar']))
{
  //si entro aca es porque el usuario selecciono la opcion para guardar los cambios en editarPerfil_view.php
  //tengo que guardar en la bd los cambios que realizo el usuario
  //$items = Item::selectAllItemsByIdCategoria($_POST['cat_id']);
  $items = Item::selectAllItemsByIdPlantilla($_POST['plant_id']);
  foreach ($items as $item)
  {
    if ($item->getTipoItemId()==3)
    {
	  //es un item
	  $data = Dato_Item::selectAllByIDItem($item->getId(),$_SESSION['usr']->getId());	
	  if ($item->getRepetible()==1)
	  {
	    //es repetible
		$i = 1;
		foreach ($data as $datum)
		{
		  //todos los que ya se encuentran cargados en la bd
		  $indice=$datum->getItemId()."_".$i;
		  if ($_POST[$indice]!='')
		  {
			$datum->setContenido(trim($_POST[$indice]));
			$datum->update();
			$i++;
		  }
		  else {
		  	$datum->delete();
		  }
		}
		//maximo 30 repetidos
		for ($j=1; $j<=30; $j++)
		{
		  //todos los que todavia no se encuentran cargados en la bd
		  $indice=$item->getId()."_".$i;
		  if ($_POST[$indice]!='')
		  {
		    $datoRepetible = new Dato_Item();
		    $datoRepetible->setUsuarioId($_SESSION['usr']->getId());
		    $datoRepetible->setItemId($item->getId());
		    $datoRepetible->setContenido(trim($_POST[$indice]));
			$datoRepetible->setBorrado(0);
			$datoRepetible->create();
			
		  }
		  $i++;
		}
	  }
	  else
	  {
	    if ($data)
	    {
		  //=> actualizar
		  foreach ($data as $datum)
		  {
		    if ($_POST[$datum->getItemId()]!='')
		    {
			  $datum->setContenido(trim($_POST[$datum->getItemId()]));
			  $datum->update();
			}
			else {
				$datum->delete();
			}
	      }
		}
		else
		{
		  //=> insertar
		  if ($_POST[$item->getId()]!='')
		  {
		    $dato = new Dato_Item();
		 	$dato->setUsuarioId($_SESSION['usr']->getId());
			$dato->setItemId($item->getId());
			$dato->setContenido(trim($_POST[$item->getId()]));
			$dato->setBorrado(0);
			$dato->create();
		  }
		}
	  }
	}
  }
}
if ($idUser = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
{
  if (count(Usuario::selectOneById($idUser))==1)
  {
    //el usuario existe
    $usuario = Usuario::selectOneByID($idUser);
    if (($usuario->getCvPublico()==1)|| (( isset($_SESSION['usr']) ) && (($usuario->getId()==$_SESSION['usr']->getId()) || ($_SESSION["usr"]->getPerfilUsuarioId() != 2 ))))
    {
      $plantillas = Plantilla::select();
      $datos = array();
      // plantilla con id=1 es la por default
      
      if (isset($_POST['submitVerPlantilla']))
      {
      	$p=$_POST['plantilla'];
      	$items = Item::selectAllItemsByIdPlantilla($p);
	      foreach ($items as $item)
	      {
	        $datos[$item->getId()]=Dato_Item::selectAllByIDItem($item->getId(),$idUser);
		  }
      	$view_page = "verPlantilla_view.twig";
      }
      
      
	  //inicializacion twig
	  $templateDir = "views/perfil";
	  $loader = new Twig_Loader_Filesystem($templateDir);
	  $twig = new Twig_Environment($loader);
	  $template = $twig->loadTemplate('verPerfil_view.twig');
	  $template->display(array('conf' => $conf,
	  		'logueado' => isset($_SESSION['usr']),
	  		'items' => $items,
	  		'datos' => $datos,
	  		'usuario' => $_SESSION['usr'],
	  		'plantillas' => $plantillas,
	  		'view_page' => $view_page,
	  		'idUser' => $idUser,
	  		'isset_view_page' => isset($view_page)
	  		
	  ));
	  
	  //include ('views/perfil/verPerfil_view.php');
	}
	else
	{
	  header('Location: index.php');
	}
  }
  else
  {
    header('Location: index.php');
  }
}
else
{
  header('Location: index.php');
}