$(function() {
    'use strict';

    // if it is editing page, literature id will be submitted with every request
    var literatureId = $('#id-literature').html();

	var literatureSelect = $('select[name=type]');
	var literatureDiv = $('#div-literature');
    var databasesDiv = $('#div-databases');
    var databaseAppendButton = $('#btn-database-append');
    var databaseDeleteButton = $('#btn-database-delete');

    var counter = $('#div-databases').children().length;
    var limit = 5;

	// initialize ajax loading immediately for editing purpose
	if (literatureId) loadLiteratureForm();

	// add events handlers
 	literatureSelect.change(loadLiteratureForm);
    databaseAppendButton.click(loadDatabaseForm);
    databaseDeleteButton.click(deleteDatabaseForm);

	// make AJAX request
	function loadLiteratureForm() {
		if (literatureSelect.val() == 'journal') {
	    	literatureDiv.load('/literature/form-journal/' + literatureId);
	    } else if (literatureSelect.val() == 'book' || literatureSelect.val() == 'conference proceedings') {
	    	literatureDiv.load('/literature/form-book-proceedings/' + literatureId);
	    } else {
	    	literatureDiv.empty();
	    }
	}

	// make AJAX request
	function loadDatabaseForm() {
		if (counter < limit) {
			$('#div-databases').append($('<div></div>').load('/literature/form-database/'));
			counter++;
		}
	}

    function deleteDatabaseForm() {
        if (counter > 1) {
            databasesDiv.children().last().remove();
            counter--;
        }
    }
});
