"use strict";

$(function() {
	var counter = $('#div-databases').children().length;
	var limit = 5;

	var literatureSelect = $('select[name=type]');
	var literatureDiv = $('#div-literature');
	var literatureId = $('#id-literature').html();
	var databaseButton = $('#btn-database');

	// load additional form immediately for EDIT purposes
	loadLiteratureForm();

	// add events handlers
 	literatureSelect.change(loadLiteratureForm);
 	databaseButton.click(loadDatabaseForm);

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
});