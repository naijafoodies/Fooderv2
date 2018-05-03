<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/29/2018
 * Time: 9:59 PM
 */

namespace App\NFCore\Service\Checkout\Services;


interface ICheckout
{
    public function makePayment(\StdClass $checkoutOptions);
}