<?php

class BaseObject
{
  /**
   * Crea un objeto a partir de un arreglo de atributos y el nombre de la clase
   */
  protected static function populateObject($class, $array)
  {
    $obj = null;

    if (is_array($array))
    {
      $obj = new $class();

      foreach ($array as $attribute_name => $attribute_value)
      {
        $obj->$attribute_name = $attribute_value;
      }
    }

    return $obj;
  }
}
