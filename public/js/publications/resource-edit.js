$(function() {
    'use strict';

    // if it is editing page, publication id will be submitted with every request
    var publicationId = $('#id-publication').html();

    var authorsDiv = $('#div-authors');
    var authorAppendButton = $('#btn-author-append');
    var authorDeleteButton = $('#btn-author-delete');
    var publicationTypeSelect = $('select[name=type]');
    var literatureNameDiv = $('#div-literature-name');
    var literatureNameSelect;
    var literatureFormDiv = $('#div-literature-form');

    var counter = authorsDiv.children().length;
    var limit = 5;

    // initialize ajax loading immediately for editing purpose
    if (publicationId) loadLiteratureNames('edit');

    publicationTypeSelect.change(loadLiteratureNames);
    authorAppendButton.click(loadAuthorForm);
    authorDeleteButton.click(deleteAuthorForm);

    // make AJAX request
    function loadLiteratureNames(flag) {
        switch (publicationTypeSelect.val()) {
            case 'journal article':
                literatureNameDiv.load('/publications/ajax/literature-titles/journal/'  + publicationId, addHandler);
                break;
            case 'book article':
                literatureNameDiv.load('/publications/ajax/literature-titles/book/'  + publicationId, addHandler);
                break;
            case 'report of conference':
                literatureNameDiv.load('/publications/ajax/literature-titles/conference_proceedings/'  + publicationId, addHandler);
                break;
            default:
                literatureNameDiv.empty();
        }

        literatureFormDiv.empty();

        function addHandler() {
            literatureNameSelect = $('select[name=literature_id]');

            literatureNameSelect.change(function() {
                literatureFormDiv.load('/publications/ajax/literature-form/' + literatureNameSelect.val() + '/' + publicationId);
            });

            if (flag == 'edit') literatureNameSelect.trigger('change');
        }
    }

    // make AJAX request
    function loadAuthorForm() {
        if (counter < limit) {
            authorsDiv.append($('<div></div>').load('/publications/ajax/author-form/' + (++counter)));
        }
    }

    function deleteAuthorForm() {
        if (counter > 1) {
            authorsDiv.children().last().remove();
            counter--;
        }
    }
});
