$(function() {
    'use strict';
	var authorSelect = $('select[name=status]');
	var authorStatus = $('#div-author-status');
	var authorId = $('#id-author').html();

	// load additional form immediately for EDIT purposes
	loadAuthorForm();

	// process onChange event
 	authorSelect.change(loadAuthorForm);

	// make AJAX request
	function loadAuthorForm() {
		if (authorSelect.val() == 'student') {
	    	authorStatus.load('/authors/form-student/' + authorId);
	    } else if (authorSelect.val() == 'department staff') {
	    	authorStatus.load('/authors/form-staff/' + authorId);
	    } else {
	    	authorStatus.empty();
	    }
	};
});
