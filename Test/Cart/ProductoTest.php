<?php
/**
 * Name: ProductoTest.php
 *
 * Author: Jorge Copia <eycopia@gmail.com>
 *
 * Description:
 */

namespace Test\Cart;


use Cart\Producto;


class ProductoTest extends \PHPUnit_Framework_TestCase
{

    public function test_nuevo_producto(){
        $producto = new Producto('Leche descremada', 1.12);
        $this->assertEquals(1.12, $producto->getPrecio());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_precio_invalido()
    {
        new Producto('Leche descremada', -1.12);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_precio_texto()
    {
        new Producto('Leche descremada', 'un sol');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_producto_sin_nombre()
    {
        new Producto(null, 11);
    }

}
