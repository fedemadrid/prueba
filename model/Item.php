<?php

class Item extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'item';

  /**
  * atributos
  */
  protected
	$id,
	$categoria_id,
        $descripcion,
        $tipo_item_id,
        $buscable,
        $repetible,
  		$tipo_input,
  		$borrado;

  /**
  * devuelve TODOS los items de la tabla.
  */
  public static function selectAll()
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
   * devuelve los items de la tabla no borrados.
   */
  public static function select()
  {
  	$sql = sprintf('SELECT * FROM %s WHERE borrado=0', self::TABLE_NAME);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$objects = array();
  	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
  	{
  		$objects[] = parent::populateObject(__CLASS__, $row);
  	}
  
  	return $objects;
  }
	
  /**
  * busca un item en la tabla por su ID.
  */
  public static function selectOneByID($iditem)
  {
    if (is_null($iditem))
    {			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE id=%s', self::TABLE_NAME, $iditem);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }	
  
  public static function selectLastItem()
  {
  	$sql = sprintf('SELECT * FROM %s ORDER BY id DESC', self::TABLE_NAME);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
  
  	return parent::populateObject(__CLASS__, $first);
  }
  
  /**
   * Devuelve todos los items que pertenecen a una plantilla.
   */
  public static function selectAllItemsByIdPlantilla($id)
  {
  	if (is_null($id))
  	{
  		return null;
  	}
  
  	$sql = sprintf('SELECT item.id, categoria_id, item.descripcion, tipo_item_id, buscable, repetible, tipo_input, item.borrado FROM plantilla_item INNER JOIN item ON (plantilla_item.id_item=item.id) INNER JOIN categoria_item ON (categoria_item.id=item.categoria_id) WHERE id_plantilla="%s" AND item.borrado=0 AND categoria_item.borrado=0 ORDER BY categoria_id, orden', $id);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$objects = array();
  	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
  	{
  		$objects[] = parent::populateObject(__CLASS__, $row);
  	}
  
  	return $objects;
  }
  
  /**
   * Devuelve todos los items menos los que se encuentran en una plantilla.
   */
  public static function selectOthersItemsByIdPlantilla($id)
  {
  	if (is_null($id))
  	{
  		return null;
  	}
  	
  	$sql = sprintf('SELECT * FROM item as it WHERE it.id NOT IN (SELECT item.id FROM plantilla_item INNER JOIN item ON (plantilla_item.id_item=item.id) INNER JOIN categoria_item ON (categoria_item.id=item.categoria_id) WHERE id_plantilla="%s" AND item.borrado=0 AND categoria_item.borrado=0 ORDER BY categoria_id, orden)', $id);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$objects = array();
  	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
  	{
  		$objects[] = parent::populateObject(__CLASS__, $row);
  	}
  
  	return $objects;
  }
  
  /**
   * Devuelve todos los items que pertenecen a una categoria.
   */
  public static function selectAllItemsByIdCategoria($id)
  {
  	if (is_null($id))
  	{
  		return null;
  	}
  
  	$sql = sprintf('SELECT * FROM item WHERE categoria_id="%s" AND borrado=0', $id);
  
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$objects = array();
  	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
  	{
  		$objects[] = parent::populateObject(__CLASS__, $row);
  	}
  
  	return $objects;
  }
  
  /**
   * Elimina un item asociado a una plantilla.
   */
  /*public function deleteItemFromPlantillaWithId($id_plantilla, $id_item)
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  	
  	$sql = sprintf('DELETE FROM plantilla_item WHERE id_item = ? AND id_plantilla = ?');
  	$stmt = $con->prepare($sql, array('integer'), MDB2_PREPARE_MANIP);
  	
  	return $stmt->execute(array($id_item, $id_plantilla));
  }*/
  
  /**
   * Elimina todos los items asociados a una plantilla.
   */
  public static function deleteItemsFromPlantillaWithId($id_plantilla)
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  	 
  	$sql = sprintf('DELETE FROM plantilla_item WHERE id_plantilla = ?');
  	$stmt = $con->prepare($sql, array('integer'), MDB2_PREPARE_MANIP);
  	 
  	return $stmt->execute(array($id_plantilla));
  }
  
  /**
   * Inserta un elemento en la tabla
   */
  public function create()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
 
  	$sql = sprintf('INSERT INTO %s (categoria_id, descripcion, tipo_item_id, buscable, repetible, tipo_input, borrado) values (?, ?, ?, ?, ?, ?, ?)', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('integer', 'text', 'integer', 'integer', 'integer', 'text', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getCategoriaId(), $this->getDescripcion(), $this->getTipoItemId(), $this->getBuscable(), $this->getRepetible(), $this->getTipoInput(), $this->getBorrado()));
  }
  
  /**
   * realiza una actualización
   */
  public function update()
  {
  	$con = ConnectionManager::getInstance()->getConnection();
  
  	$sql = sprintf('UPDATE %s set categoria_id = ?, descripcion = ?, tipo_item_id = ?, buscable = ?, repetible = ?, tipo_input = ?, borrado = ? WHERE id = ?', self::TABLE_NAME);
  	$stmt = $con->prepare($sql, array('integer', 'text', 'integer', 'integer', 'integer', 'text', 'integer', 'integer'), MDB2_PREPARE_MANIP);
  
  	return $stmt->execute(array($this->getCategoriaId(), $this->getDescripcion(), $this->getTipoItemId(), $this->getBuscable(), $this->getRepetible(), $this->getTipoInput(), $this->getBorrado(), $this->getId()));
  }
  
  /**
  * GETTERS Y SETTERS
  */
  public function getId()
  {
    return $this->id;
  }

  public function setId($v)
  {
    $this->id = $v;
  }

  public function getDescripcion()
  {
    return $this->descripcion;
  }

  public function setDescripcion($v)
  {
    $this->descripcion = $v;
  }

  public function getCategoriaId()
  {
    return $this->categoria_id;
  }

  public function setCategoriaId($v)
  {
    $this->categoria_id = $v;
  }
  
  public function getTipoItemId()
  {
    return $this->tipo_item_id;
  }

  public function setTipoItemId($v)
  {
    $this->tipo_item_id = $v;
  }

  public function getBuscable()
  {
    return $this->buscable;
  }

  public function setBuscable($v)
  {
    $this->buscable = $v;
  }

  public function getRepetible()
  {
    return $this->repetible;
  }

  public function setRepetible($v)
  {
    $this->repetible = $v;
  }
  public function getTipoInput()
  {
  	return $this->tipo_input;
  }
  
  public function setTipoInput($v)
  {
  	$this->tipo_input = $v;
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