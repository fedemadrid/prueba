<?php

class Usuario extends BaseObject
{
  /**
  * nombre de la tabla
  */
  const TABLE_NAME = 'usuario';

  /**
  * atributos
  */
  protected
	$uid,
	$username,
	$password,
	$cv_publico,
	$perfil_usuario_id,
	$activo,
  	$perfil;

  /**
  * devuelve TODOS los usuarios de la tabla.
  */
  public static function selectAllUsers()
  {
    $sql = sprintf('SELECT * FROM %s INNER JOIN perfil_usuario ON (usuario.perfil_usuario_id = perfil_usuario.id)', self::TABLE_NAME);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $objects = array();
    while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
      $objects[] = parent::populateObject(__CLASS__, $row);
    }

    return $objects;
  }
	
  /**
  * busca un usuario de la tabla por su ID.
  */
  public static function selectOneByID($idusuario)
  {
    if (is_null($idusuario))
    {
			
      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s INNER JOIN perfil_usuario ON (usuario.perfil_usuario_id = perfil_usuario.id) WHERE uid=%s', self::TABLE_NAME, $idusuario);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }
	
  /**
  * busca un usuario de la tabla por su nombre.
  */
  public static function selectOneByUsername($username)
  {
    if (is_null($username))
    {

      return null;
    }
	
    $sql = sprintf('SELECT * FROM %s WHERE username="%s"', self::TABLE_NAME, $username);
	
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
	
    $first = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	
    return parent::populateObject(__CLASS__, $first);
  }
	
  public static function check($username,$password)
  {
    $sql = sprintf('SELECT * FROM %s WHERE username="%s" AND activo=1', self::TABLE_NAME, $username);
    $result = ConnectionManager::getInstance()->getConnection()->query($sql);
    $usr = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
    return ($usr['password']==$password);
  }
  
 
  /**
  * Inserta un elemento en la tabla
  */
  public function create()
  {
    $con = ConnectionManager::getInstance()->getConnection();
    	
    $sql = sprintf('INSERT INTO %s (username, password, cv_publico, perfil_usuario_id, activo) values (?, ?, ?, ?, ?)', self::TABLE_NAME);
    $stmt = $con->prepare($sql, array('text', 'text', 'integer', 'integer', 'integer'), MDB2_PREPARE_MANIP);
	
    return $stmt->execute(array($this->getUsername(), $this->getPassword(), $this->getCvPublico(), $this->getPerfilUsuarioId(), $this->getActivo()));
  }
	
  /**
  * realiza una actualización
  */
  public function update()
  {
    $con = ConnectionManager::getInstance()->getConnection();
	
    $sql = sprintf('UPDATE %s set username = ?, password = ?, cv_publico = ?, perfil_usuario_id = ?, activo = ? WHERE uid = ?', self::TABLE_NAME);
    $stmt = $con->prepare($sql, array('text', 'text', 'integer', 'integer', 'integer', 'integer'), MDB2_PREPARE_MANIP);
	
    return $stmt->execute(array($this->getUsername(), $this->getPassword(), $this->getCvPublico(), $this->getPerfilUsuarioId(), $this->getActivo(), $this->getId()));
  }
	
  /**
   * Devuelve todos los datos que coinciden con $busqueda. Los usuarios tienen CV publico.
   */
  public static function buscarPorUnCampoUsuarioCvPublico($busqueda)
  {
  	if (is_null($busqueda))
  	{
  		return null;
  	}
  	$sql = sprintf('SELECT distinct(usuario.uid), username FROM `dato_item` INNER JOIN `item` ON (item.id=dato_item.item_id) INNER JOIN `usuario` ON (dato_item.usuario_id=usuario.uid) WHERE (usuario.cv_publico = 1 AND usuario.activo = 1 AND buscable = 1 AND contenido = "%s") LIMIT 20', $busqueda);
  	 
  	$result = ConnectionManager::getInstance()->getConnection()->query($sql);
  
  	$objects = array();
  	while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC))
  	{
  		$objects[] = parent::populateObject(__CLASS__, $row);
  	}
  
  	return $objects;
  }
  
  /**
   * Devuelve todos los datos que coinciden con $busqueda. Los usuarios tienen CV publico y privado.
   */
  public static function buscarPorUnCampo($busqueda)
  {
  	if (is_null($busqueda))
  	{
  		return null;
  	}
  	$sql = sprintf('SELECT distinct(usuario.uid), username FROM `dato_item` INNER JOIN `item` ON (item.id=dato_item.item_id) INNER JOIN `usuario` ON (dato_item.usuario_id=usuario.uid) WHERE (buscable = 1 AND usuario.activo = 1 AND contenido = "%s") LIMIT 20', $busqueda);
  	 
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
    return $this->uid;
  }

  public function setId($v)
  {
    $this->uid = $v;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($v)
  {
    $this->username = $v;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($v)
  {
    $this->password = $v;
  }

  public function getPerfilUsuarioId()
  {
    return $this->perfil_usuario_id;
  }

  public function setPerfilUsuarioId($v)
  {
    $this->perfil_usuario_id = $v;
  }

  public function getActivo()
  {
    return $this->activo;
  }

  public function setActivo($v)
  {
    $this->activo = $v;
  }
	
  public function getCvPublico()
  {
    return $this->cv_publico;
  }
	
  public function setCvPublico($v)
  {
    $this->cv_publico = $v;
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