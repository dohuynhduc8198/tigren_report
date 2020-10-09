define([
        "jquery",
    'mage/translate',
    'mage/calendar'
    ], function($, $t){
        "use strict";
        //calender
        $('#example-date').calendar({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            currentText: $t('Go Today'),
            closeText: $t('Close'),
            showWeek: true
        });
        //return onclick popup
        return function(config, element) {
            $(element).click(function (){
                alert("Jquery sample text");
            });
            alert(config.message);
        }
    }
)
;
