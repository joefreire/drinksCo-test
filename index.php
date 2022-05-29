<?php

require_once "Product.php";
require_once "Cart.php";
require_once "CartItem.php";

$product1 = new Product(1, "Wine", 10, 9, 3);
$product2 = new Product(2, "Tequila", 20, 15, 5);
$product3 = new Product(3, "Whisky", 25, 20, 2);
$cart = new Cart();
$cartItem1 = $cart->addProduct($product1, 1);
$cartItem1 = $cart->addProduct($product1, 2);

$cartItem2 = $product2->addToCart($cart, 5);
$cartItem3 = $product3->addToCart($cart, 1);

echo 'CART ' . PHP_EOL;
foreach ($cart->getItems() as $item) {
    $product = $item->getProduct();
    if ($item->getQuantity() >= $item->getProduct()->getMinToSale()) {
        echo $item->getQuantity() . ' - '. $product->getTitle() . ' = TOTAL: ' . ($item->getQuantity() * $product->getPriceSale()) . ' (Up '.$product->getPriceSale().')'. PHP_EOL;
    } else {
        echo $item->getQuantity() . ' - '. $product->getTitle() . ' = TOTAL: ' . ($item->getQuantity() * $product->getPrice()) . ' (Up '.$product->getPrice().')'. PHP_EOL;
    }
}
echo "Total price of items in cart: ". $cart->getTotalSum().PHP_EOL;
