;(function(){
	var notifier = document.getElementById('notifier');
	notifier.classList.add('javascript');
	notifier.querySelector('button.close').classList.remove('hide');

	// We need to delay this, otherwise the css transition won't run.
	setTimeout(function(){
		notifier.classList.add('opened');
	}, 10);

	var alerts = document.querySelectorAll('.alert.alert-dismissable > .close, .alert.alert-dismissible > .close');
	for (var i = 0; i < alerts.length; ++i) {
		var parent = alerts[i].parentElement;

		alerts[i].onclick = function() {
			parent.classList.add('closed');
		}

		// Auto-close after 10 seconds if class autoclose is available on parent.
		if (parent.classList.contains('autoclose')) {
			setTimeout(function(){
				parent.classList.add('closed');
			}, 5000);
		}
	}
})();