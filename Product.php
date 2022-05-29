<?php


class Product
{
    private $id;
    private $title;
    private $price;
    private $price_sale;
    private $min_to_sale;

    /**
     * Product constructor.
     *
     * @param int    $id
     * @param string $title
     * @param float  $price
     * @param int    $price_sale
     * @param int    $min_to_sale
     */
    public function __construct($id, $title, $price, $price_sale, $min_to_sale)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->price_sale = $price_sale;
        $this->min_to_sale = $min_to_sale;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPriceSale()
    {
        return $this->price_sale;
    }

    /**
     * @param int $price_sale
     */
    public function setPriceSale($price_sale)
    {
        $this->price_sale = $price_sale;
    }
    /**
     * @return int
     */
    public function getMinToSale()
    {
        return $this->min_to_sale;
    }

    /**
     * @param int $price_sale
     */
    public function setMinToSale($min_to_sale)
    {
        $this->min_to_sale = $min_to_sale;
    }

    /**
     * Add Product $product into cart. If product already exists inside cart
     * it must update quantity.
     *
     * @param Cart $cart
     * @param int  $quantity
     * @return \CartItem
     * @throws \Exception
     */
    public function addToCart(Cart $cart, int $quantity)
    {
        if (count($cart->getItems()) >= 10) {
            throw new Exception("Itens in the cart can not be more than 10");
        }
        return $cart->addProduct($this, $quantity);
    }

    /**
     * Remove product from cart
     *
     * @param Cart $cart
     */
    public function removeFromCart(Cart $cart)
    {
        return $cart->removeProduct($this);
    }
}
