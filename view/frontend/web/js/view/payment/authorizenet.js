define(['uiComponent', 'Magento_Checkout/js/model/payment/renderer-list'],
    function (uiComponent, rendererList) {
        'use strict';

        rendererList.push({
            type: 'gg2_authorizenet',
            component: 'Gg2_Authorizenet/js/view/payment/method-renderer/cc-form'
        });
        return uiComponent.extend({});
    });
