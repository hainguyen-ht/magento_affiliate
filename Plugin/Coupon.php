<?php
namespace Mageplaza\Affiliate\Plugin;

class Coupon{
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->checkoutSession= $checkoutSession;
    }
    public function afterGetCouponCode(\Magento\Checkout\Block\Cart\Coupon $subject, $result){
        if($code = $this->checkoutSession->getCode()) {
            return $code;
        }
    }
}
?>
