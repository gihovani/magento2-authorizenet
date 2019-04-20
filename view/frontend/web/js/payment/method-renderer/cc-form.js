define(['Magento_Payment/js/view/payment/cc-form'], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Gg2_Authorizenet/payment/cc-form',
            code: 'gg2_authorizenet'
        },

        getCode: function() {
            return this.code;
        }
    });
});
