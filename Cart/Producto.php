<?php
/**
 * Name: Producto.php
 *
 * Author: Jorge Copia <eycopia@gmail.com>
 *
 * Description:
 */

namespace Cart;


class Producto
{
    private $id;
    private $nombre;
    private $precio;

    /**
     * Producto constructor
     *
     * @param $nombre
     * @param $precio
     *
     * @throws \InvalidArgumentException cuando el precio no es un numero, o es menos a 0
     */
    public function __construct($nombre, $precio)
    {
        if(is_null($nombre)){
            throw new \InvalidArgumentException('Debe ingresar un nombre para el producto');
        }

        if(!is_numeric($precio) || $precio < 0 ){
            throw new \InvalidArgumentException("El precio del producto debe ser un numero");
        }
        $this->id = uniqid($nombre);
        $this->nombre = $nombre;
        $this->precio  = $precio;
    }


    /**
     * Identificador del producto
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Precio del producto
     * @return int|double
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Devuelve el nombre del producto
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

}