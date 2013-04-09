<?php

require_once(dirname(__FILE__).'/lib/Autoload.php');
require_once(dirname(__FILE__).'/lib/fpdf17/fpdf.php');//libreria para exportar a pdf

if (isset($_SESSION['usr'])) 
{
  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(100,0,'Curriculum Vitae');
  $pdf->Cell(100,0,'___________________________________________________________',$pdf->ln(1));

  if ($idUser = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) 
  {
    if (count(Usuario::selectOneById($idUser))==1)
    {
	  //el usuario existe
	  $usuario = Usuario::selectOneByID($idUser);
	  if ($usuario->getCvPublico()==1)
	  {
	    $datos = array();
		// plantilla con id=1 es la por default
		$items = Item::selectAllItemsByIdPlantilla($_POST['formato']);
		foreach ($items as $item) 
		{
		  $datos[$item->getId()]=Dato_Item::selectAllByIDItem($item->getId(),$idUser);
		}
		foreach ($items as $item)
		{
		  if ($item->getTipoItemId()==1)
		  {
		    //es un label
			$pdf->Cell(100,5,$item->getDescripcion(),1,$pdf->ln(15));
		  }
		  elseif ($item->getTipoItemId()==3)
		  {
		    //es un item
			foreach ($datos as $dato)
			{
			  foreach ($dato as $d)
			  {
			    if ($d->getItemId()==$item->getId())
			    {
				  $i = $item->getDescripcion()." : ".$d->getContenido();
				  $pdf->Cell(100,5,$i,$pdf->ln(5));
				}
			  }
			}
		  }
		  else
		  {
		    //es un separador
			$pdf->Cell(100,5,"",$pdf->ln(2));
		  }
		}
	  } 
	  else 
	  {
	    header ('Location: MostrarDatosUsuario.php');
	  }
	}
	else
	{
	  header ('Location: MostrarDatosUsuario.php');
	}
  }
  else
  {
    header ('Location: MostrarDatosUsuario.php');
  }
  $pdf->Output();
}
else
{
  header ('Location: MostrarDatosUsuario.php');
}