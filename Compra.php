<?php require_once "vendor/autoload.php";
/**
 * Name: Compra.php
 *
 * Author: Jorge Copia <eycopia@gmail.com>
 *
 * Description: Simula una compra utilizando Cart
 */
echo "Bienvenido".PHP_EOL;

//productos de la tienda
$arroz = new \Cart\Producto('Arroz', 3.5);
$leche = new \Cart\Producto('Leche gloria', 2.2);
$pan = new \Cart\Producto('Pan', 1);
$aceite = new \Cart\Producto('Aceite', 5);
$fideo = new \Cart\Producto('Fideo', 2);

$carrito = new \Cart\Cart();

//agregar productos del carrito
$carrito->agregar($fideo);
$carrito->agregar($arroz);
$carrito->agregar($leche);

echo PHP_EOL."El carrito tiene los siguientes productos: ".PHP_EOL;
foreach ($carrito->getProductos() as $producto) {
    echo sprintf("1 unidad de:  %s  a  S/ %s ", $producto->getNombre(), $producto->getPrecio()) .PHP_EOL;
}

//aplicar descuento
$carrito->setDescuento('Comprador 100', 5);
echo "Usted es el comprador 100, tiene 5 soles de descuento ".PHP_EOL;
echo "El total a pagar es: " . $carrito->getTotalAPagar() . PHP_EOL;
echo "Gracias por su compra" .PHP_EOL;
