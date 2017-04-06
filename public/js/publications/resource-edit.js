"use strict";

$(function() {
	var counter = $('#div-authors').children().length;
	var limit = 5;

	var publicationId = $('#id-publication').html();
	var publicationType = $('select[name=type]');
	var literatureName = $('#div-literature-name');
	var literatureForm = $('#div-literature-form');
	var authorButton = $('#btn-author');

	// load additional form immediately for EDIT purposes
	loadLiteratureForm();

	// add events handlers
 	publicationType.change(loadLiteratureForm);
 	authorButton.click(loadAuthorForm);

	// make AJAX request
	function loadLiteratureForm() {
		switch (publicationType.val()) {
			case 'journal article':
				literatureName.load('/publications/literature/journal/'  + publicationId);
	    		literatureForm.load('/publications/form-journal/' + publicationId);
	    		break;
	    	case 'book article':
	    		literatureName.load('/publications/literature/book/' + publicationId);
	    		literatureForm.load('/publications/form-pages/' + publicationId);
	    		break;
	    	case 'report of conference':
				literatureName.load('/publications/literature/conference_proceedings/' + publicationId);
	    		literatureForm.load('/publications/form-pages/' + publicationId);
	    		break;
	    	default:
	    		literatureName.empty();
	    		literatureForm.empty();
		}
	}

	// make AJAX request
	function loadAuthorForm() {
		if (counter < limit) {
			$('#div-authors').append($('<div></div>').load('/publications/form-author'));
			counter++;
		}
	}
});