define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'newpayment',
                component: 'Tigren_NewPayment/js/view/payment/method-renderer/newpayment'
            }
        );
        return Component.extend({});
    }
);
