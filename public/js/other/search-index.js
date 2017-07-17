$(() => {
    'use strict';

    let entitySelect = $('select[name=entity]');
    let form = $('#div-form');
    let interval;
    let slider;

    entitySelect.change(() => {
        form.load('/search/ajax/' + entitySelect.val(), init);
    });

    function init() {
        initElementsBlocking();
        initTimeInterval();
    }

    function initElementsBlocking() {
        let typeSelect = $('select[name=type]');

        typeSelect.change(() => {
            switch(typeSelect.val()) {
                /* publication */
                case 'journal article':
                    $('select[name=issue_number]').prop('disabled', false);
                    interval.prop('disabled', false);
                    slider.slider('enable');
                    break;

                case 'book article':
                case 'report of conference':
                    $('select[name=issue_number]').prop('disabled', true);
                    interval.prop('disabled', true);
                    slider.slider('disable');
                    break;

                /* literature */
                case 'journal':
                    $('select[name=periodicity]').prop('disabled', false);
                    interval.prop('disabled', true);
                    slider.slider('disable');
                    break;

                case 'book':
                case 'conference proceedings':
                    $('select[name=periodicity]').prop('disabled', true);
                    interval.prop('disabled', false);
                    slider.slider('enable');
                    break;
            }
        });
    }

    function initTimeInterval() {
        interval = $('[name="interval"]');
        slider = $('#time-slider');

        if (!interval || !slider) return;

        let year = new Date().getFullYear();

        slider.slider({
            range: true,
            min: 1990,
            max: year,
            values: [1990, year],
            slide: (event, ui) => {
                interval.val(ui.values[0] + ' - ' + ui.values[1]);
            }
       });

       interval.val(slider.slider('values', 0) + ' - ' + slider.slider('values', 1));

       slider.slider('disable');
    }
});
