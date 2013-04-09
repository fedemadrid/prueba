<?php

/**
 * Singleton que maneja una conexion MDB2.
 */
class ConnectionManager
{
  protected static $instance = null;
  protected $connection = null;

  /**
   * Crea una conexión a partir del DNS definido en config/database.php
   */
  protected function __construct()
  {
    $this->connection = MDB2::connect(DSN);
  }
  
  /**
   * Devuelve la instancia (si no existe la crea)
   */
  public static function getInstance()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new self();
    }

    return self::$instance;
  }
  
  /**
   * Devuelve la conexión
   */
  public function getConnection()
  {
    return $this->connection;
  }
}

