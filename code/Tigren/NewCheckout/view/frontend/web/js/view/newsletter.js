define(
    [
        'ko',
        'uiComponent'
    ],
    function (ko, Component) {
        "use strict";

        return Component.extend({
            defaults: {
                template: 'Tigren_NewCheckout/newsletter'
            },
            isRegisterNewsletter: true
        });
    }
);
