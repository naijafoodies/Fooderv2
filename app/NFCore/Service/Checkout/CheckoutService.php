<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/29/2018
 * Time: 9:57 PM
 */

namespace App\NFCore\Service\Checkout;


use App\NFCore\Service\Checkout\Services\ICheckout;

class CheckoutService
{
    /**
     * @var
     * Service is the kind of service to be instantiated.
     */
    protected  $service;

    /**
     * CheckoutService constructor.
     * @param $service
     */
    public function __construct(ICheckout $service)
    {
        if(!$service instanceof ICheckout) {
            throw new \InvalidArgumentException("Must be of type ICheckout");
        }
        $this->service = $service;
    }

    /**
     * @param \StdClass $paymentOptions
     */
    public function pay(\StdClass $paymentOptions)
    {
        return $this->service->makePayment($paymentOptions);
    }
}