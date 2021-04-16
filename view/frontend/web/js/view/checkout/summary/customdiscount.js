define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/totals'
    ],
    function ($,Component, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Mageplaza_Affiliate/checkout/summary/customdiscount'
            },
            isDisplayedCustomdiscount : function(){
                if(Math.abs(totals.getSegment('referral').value) > 0) return true
                return false
            },
            getCustomDiscount : function(){
                let referral = totals.getSegment('referral').value
                return this.getFormattedPrice(referral)
            }
        });
    }
);
