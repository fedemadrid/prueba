<?php

class Perfil extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'perfil_usuario';

  /**
  * atributos
  */
  protected
	$id,
    $perfil;
          
  /**
  * devuelve TODOS los perfiles de la tabla.
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
  
  public function getPerfil()
  {
    return $this->perfil;
  }

  public function setPerfil($v)
  {
    $this->perfil = $v;
  }
}