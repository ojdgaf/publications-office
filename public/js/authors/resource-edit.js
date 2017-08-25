$(() => {
    'use strict';

	let authorSelect = $('select[name=status]');
	let authorStatus = $('#div-author-status');
	let authorId = $('#id-author').html();

	// load additional form immediately for EDIT purposes
	loadAuthorForm();

	// process onChange event
 	authorSelect.change(loadAuthorForm);

	// make AJAX request
	function loadAuthorForm() {
		if (authorSelect.val() == 'student') {
	    	authorStatus.load('/authors/ajax/for-student/' + authorId);
	    } else if (authorSelect.val() == 'department staff') {
	    	authorStatus.load('/authors/ajax/for-staff/' + authorId);
	    } else {
	    	authorStatus.empty();
	    }
	};
});
