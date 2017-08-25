$(() => {
    'use strict';

    // if it is editing page, publication id will be submitted with every request
    let publicationId = $('#id-publication').html();

    let authorsDiv = $('#div-authors');
    let authorAppendButton = $('#btn-author-append');
    let authorDeleteButton = $('#btn-author-delete');
    
    let publicationTypeSelect = $('select[name=type]');
    let literatureNameDiv = $('#div-literature-name');
    let literatureNameSelect;
    let literatureFormDiv = $('#div-literature-form');

    let counter = authorsDiv.children().length;
    let limit = 5;

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
                literatureFormDiv.load(
                    '/publications/ajax/literature/' +
                    literatureNameSelect.val() + '/' + publicationId
                );
            });

            if (flag == 'edit') literatureNameSelect.trigger('change');
        }
    }

    // make AJAX request
    function loadAuthorForm() {
        if (counter < limit) {
            authorsDiv.append($('<div></div>').load('/publications/ajax/author/' + (++counter)));
        }
    }

    function deleteAuthorForm() {
        if (counter > 1) {
            authorsDiv.children().last().remove();
            counter--;
        }
    }
});
