<?php

class Dato_Item extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'dato_item';

  /**
  * atributos
  */
  protected
	$id_di,
	$usuario_id,
        $item_id,
        $contenido,
        $fecha_inicio,
        $fecha_fin,
        $entidad_otorgante,
        $entidad_destinataria,
        $caracter,
  		$borrado;

  /**
  * devuelve TODOS los dato_item de la tabla.
  */
  public static function select()
  {
    $sql = sprintf('SELECT * FROM %s', self::TABLE_NAME);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
      $objects[] = parent::populateObject(__CLASS__, $row);
    }

    return $objects;
  }
	
  /**
  * devuelve todos los dato_item perteneciente a un usuario.
  */
  public static function selectAllByIDItem($iditem, $iduser)
  {
    if (is_null($iditem)||is_null($iduser))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s INNER JOIN usuario ON (usuario.uid=dato_item.usuario_id) INNER JOIN item ON (item.id=dato_item.item_id) WHERE item_id=%s AND usuario_id=%s', self::TABLE_NAME, $iditem, $iduser);
    
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
    
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
    	$objects[] = parent::populateObject(__CLASS__, $row);
    }
    
    return $objects;
  }	
  
    /**
  * devuelve todos los dato_item pertenecientes a un usuario.
  */
  public static function selectAllByID($iduser)
  {
    if (is_null($iduser))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s INNER JOIN usuario ON (usuario.uid=dato_item.usuario_id) WHERE usuario_id=%s', self::TABLE_NAME, $iduser);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
      $objects[] = parent::populateObject(__CLASS__, $row);
    }

    return $objects;
  }	

  /**
   * realiza una actualización
   */
  public function update()
  {
    $con = ConnectionManager::getInstance()->getConnection();
   
    $sql = sprintf('UPDATE %s SET contenido = ?,fecha_inicio = ?, fecha_fin	= ?, entidad_otorgante = ?, entidad_destinataria = ?, caracter = ?, borrado = ? WHERE id_di = ?', self::TABLE_NAME);
    $stmt = $con->prepare($sql, array('text', 'date', 'date', 'text', 'text', 'text', 'integer', 'integer'), MDB2_PREPARE_MANIP);
	
    return $stmt->execute(array($this->getContenido(), $this->getFechaInicio(), $this->getFechaFin(), $this->getEntidadOtorgante(), $this->getEntidadDestinataria(), $this->getCaracter(), $this->getBorrado(), $this->getIdDi()));
  }
  
  /**
   * Inserta un elemento en la tabla
   */
  public function create()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  	 
  	$sql = sprintf('INSERT INTO %s (usuario_id, item_id, contenido, fecha_inicio, fecha_fin, entidad_otorgante, entidad_destinataria, caracter, borrado) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('text', 'date', 'date', 'text', 'text', 'text', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getUsuarioId(), $this->getItemId(), $this->getContenido(), $this->getFechaInicio(), $this->getFechaFin(), $this->getEntidadOtorgante(), $this->getEntidadDestinataria(), $this->getCaracter(), $this->getBorrado()));
  }
  
  /**
   * Elimina un elemento en la tabla
   */
  public function delete()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('DELETE FROM %s WHERE id_di = ?', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getIdDi()));
  }
  
  /**
  * GETTERS Y SETTERS
  */
  public function getIdDi()
  {
    return $this->id_di;
  }

  public function setIdDi($v)
  {
    $this->id_di = $v;
  }
  
  public function getUsuarioId()
  {
    return $this->usuario_id;
  }

  public function setUsuarioId($v)
  {
    $this->usuario_id = $v;
  }
  
  public function getItemId()
  {
    return $this->item_id;
  }

  public function setItemId($v)
  {
    $this->item_id = $v;
  }
  
  public function getContenido()
  {
    return $this->contenido;
  }

  public function setContenido($v)
  {
    $this->contenido = $v;
  }
  
  public function getFechaInicio()
  {
    return $this->fecha_inicio;
  }
  
  public function setFechaInicio($v)
  {
  	$this->fecha_inicio = $v;
  }
  
  public function getFechaFin()
  {
  	return $this->fecha_fin;
  }
  
  public function setFechaFin($v)
  {
    $this->fecha_fin = $v;
  }
  
  public function getEntidadOtorgante()
  {
    return $this->entidad_otorgante;
  }

  public function setEntidadOtorgante($v)
  {
  	$this->entidad_destinataria = $v;
  }
  
  public function getEntidadDestinataria()
  {
  	return $this->entidad_destinataria;
  }
  
  public function setEntidadDestinataria($v)
  {
    $this->entidad_destinataria = $v;
  }
  
  public function getCaracter()
  {
  	return $this->caracter;
  }
  
  public function setCaracter($v)
  {
  	$this->caracter = $v;
  }
  
  public function getBorrado()
  {
  	return $this->borrado;
  }
  
  public function setBorrado($v)
  {
  	$this->borrado = $v;
  }
}