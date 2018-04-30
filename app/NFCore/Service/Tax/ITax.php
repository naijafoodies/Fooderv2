<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 5/2/2018
 * Time: 10:17 PM
 */

namespace App\NFCore\Service\Tax;


interface ITax
{
    public function getTaxAmount(string $cartId);
}