$(() => {
    'use strict';

    for (let i = 1; i <= 4; i++) {
        $('#header-' + i).click(() => {
            $('#panel-' + i).slideToggle("fast");
        });
    }
});
