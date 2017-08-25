$(() => {
    'use strict';

    // if it is editing page, literature id will be submitted with every request
    let literatureId = $('#id-literature').html();

    let databasesDiv = $('#div-databases');
    let databaseAppendButton = $('#btn-database-append');
    let databaseDeleteButton = $('#btn-database-delete');

	let literatureSelect = $('select[name=type]');
	let literatureDiv = $('#div-literature');

    let counter = databasesDiv.children().length;
    let limit = 5;

	// initialize ajax loading immediately for editing purpose
	if (literatureId) loadLiteratureForm();

	// add events handlers
 	literatureSelect.change(loadLiteratureForm);
    databaseAppendButton.click(loadDatabaseForm);
    databaseDeleteButton.click(deleteDatabaseForm);

	// make AJAX request
	function loadLiteratureForm() {
		if (literatureSelect.val() == 'journal') {
	    	literatureDiv.load('/literature/ajax/for-journal/' + literatureId);
	    } else if (literatureSelect.val() == 'book' ||
                   literatureSelect.val() == 'conference proceedings') {
	    	literatureDiv.load('/literature/ajax/for-book-or-proceedings/' + literatureId);
	    } else {
	    	literatureDiv.empty();
	    }
	}

	// make AJAX request
	function loadDatabaseForm() {
		if (counter < limit) {
			databasesDiv.append(
                $('<div></div>').load('/literature/ajax/database/' + (++counter))
            );
		}
	}

    function deleteDatabaseForm() {
        if (counter > 1) {
            databasesDiv.children().last().remove();
            counter--;
        }
    }
});
