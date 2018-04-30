<?php

namespace App\Http\Controllers;

use App\NFCore\Service\Cart\CartService;
use App\NFCore\Service\Tax\Services\MultiplicativePropertyTaxSystem;
use App\NFCore\Service\Tax\TaxService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function showCheckoutPage() {
        $cart = new CartService($this->request);
        $taxService = new TaxService($cart->getCartId());

        $data["cartItems"] = $cart->getCartItem($cart->getCartId());
        $data["tax"] = $taxService->get(new MultiplicativePropertyTaxSystem());

        dd($data);
    }
}
