<?php
/**
 * Name: Cart.php
 *
 * Author: Jorge Copia <eycopia@gmail.com>
 *
 * Description:
 */

namespace Cart;


class Cart
{
    /**
     * Valor porcentual del IGV
     * @static int
     */
    const IGV = 18;
    /**
     * @var array
     */
    private $productos = array();

    /**
     * @var array
     */
    private $descuento = null;

    /**
     * Agrega un producto al carrito
     * @param Producto $producto
     */
    public function agregar(Producto $producto)
    {
        $this->productos[$producto->getId()] = $producto;
    }

    /**
     * Elimina un producto del carrito
     * @param Producto $producto
     */
    public function quitar(Producto $producto)
    {
        if(!isset($this->productos[$producto->getId()])){
            throw new \Exception('Este producto no esta en el carrito');
        }
        unset($this->productos[$producto->getId()]);
    }

    /**
     * Devuelve los productos que contiene el carrito
     * @return array
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Devuelve el numero de productos en el carrito
     * @return int|float
     */
    public function getTotalProductos()
    {
        return count($this->productos);
    }

    /**
     * Registra el descuento a utilizar
     * @param $nombre
     * @param $valor
     * @throws \Exception
     */
    public function setDescuento($nombre, $valor){
        if(!is_null($this->descuento)){
            throw new \Exception('Ya tiene un descuento aplicado');
        }

        if(!is_numeric($valor) || $valor < 0){
            throw new \InvalidArgumentException('El valor del descuento debe ser un número mayor a cero');
        }

        if($valor > $this->getTotalAPagar()){
            throw new \InvalidArgumentException('No puede aplicar un descuento superior al total a pagar');
        }

        $this->descuento = array();
        $this->descuento['nombre'] = $nombre;
        $this->descuento['valor'] = $valor;
    }

    /**
     * Calcula el total a pagar por la compra
     * @return float|int
     */
    public function getTotalAPagar(){
        $total = $subtotal = 0;
        foreach ($this->productos as $producto){
            $subtotal += $producto->getPrecio();
        }
        $total = ($subtotal * self::IGV)/100 + $subtotal;
        if(isset($this->descuento['valor'])){
            $total = $total - $this->descuento['valor'];
        }
        return $total;
    }
}