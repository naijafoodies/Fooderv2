<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/29/2018
 * Time: 10:26 PM
 */

namespace App\NFCore\Service\Tax;


class TaxService
{
    private $cartId;

    public function __construct($cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @param ITax $service
     * @return mixed
     *
     */
    public function get(ITax $service) {

        if (!$service instanceof ITax) {
            throw new \InvalidArgumentException("Argument must be of type ITax");
        }

        return $service->getTaxAmount($this->cartId);
    }

}