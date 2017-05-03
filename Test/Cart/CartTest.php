<?php
/**
 * Name: CartTest.php
 *
 * Author: Jorge Copia <eycopia@gmail.com>
 *
 * Description:
 */

namespace Cart;


class CartTest extends \PHPUnit_Framework_TestCase
{
    public function test_agregar_dos_productos()
    {
        $cart = new Cart();
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar(new Producto('Pan', 1));
        $this->assertEquals(2, $cart->getTotalProductos());
    }

    public function test_sumar_precios()
    {
        $expected = (2 * Cart::IGV)/100 + 2;
        $cart = new Cart();
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar(new Producto('Pan', 1));
        $this->assertEquals($expected, $cart->getTotalAPagar());
    }

    public function test_aplicar_descuento(){
        $cart = new Cart();
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar(new Producto('Pan', 1));
        $descuento = 0.3;
        $cart->setDescuento('viernes santo', $descuento);
        $expected = (2 * Cart::IGV)/100 + 2 - $descuento;
        $this->assertEquals($expected, $cart->getTotalAPagar());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_no_debe_descontar_mas_del_precio(){
        $cart = new Cart();
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar(new Producto('Pan', 1));
        $descuento = 3;
        $cart->setDescuento('viernes santo', $descuento);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage tiene un descuento aplicado
     */
    public function test_no_puede_aplicar_mas_de_un_descuento()
    {
        $cart = new Cart();
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar(new Producto('Pan', 1));
        $descuento = 0.3;
        $cart->setDescuento('viernes santo', $descuento);
        $cart->setDescuento('viernes 13', $descuento);
    }

    public function test_eliminar_producto(){
        $cart = new Cart();
        $pan = new Producto('Pan', 1);
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar($pan);
        $cart->quitar($pan);
    }

    /**
     * @expectedException \Exception
     */
    public function test_eliminar_producto_que_no_esta_en_el_carro(){
        $cart = new Cart();
        $pan = new Producto('Pan', 1);
        $biscocho = new Producto('Biscocho', 1.2);
        $cart->agregar(new Producto('Leche descremada', 1));
        $cart->agregar($pan);
        $cart->quitar($biscocho);
    }

    public function test_total_luego_de_agregar_eliminar_y_descuentar()
    {
        $cart = new Cart();
        $pan = new Producto('Pan', 1);
        $biscocho = new Producto('Biscocho', 1.2);
        $leche = new Producto('Leche descremada', 1);
        $arroz = new Producto('Arroz', 3.5);

        $descuento = 0.5;

        $cart->agregar($leche);
        $cart->agregar($biscocho);
        $cart->setDescuento('Primer comprador', $descuento);
        $cart->agregar($arroz);
        $cart->agregar($pan);
        $cart->quitar($arroz);

        $subtotal = $pan->getPrecio() + $leche->getPrecio() + $biscocho->getPrecio();
        $total = ($subtotal * Cart::IGV)/100 + $subtotal - $descuento;
        $this->assertEquals($total, $cart->getTotalAPagar());
    }
}
