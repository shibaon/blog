$(document).ready(function() {
	var container = $('.adaptive-container');

	$(window).resize(function () {
		if (container.width() <= 850) {
			container.addClass('width850');
		} else {
			container.removeClass('width850');
		}
		if (container.width() <= 800) {
			container.addClass('width800');
		} else {
			container.removeClass('width800');
		}
		if (container.width() <= 750) {
			container.addClass('width750');
		} else {
			container.removeClass('width750');
		}
		if (container.width() <= 500) {
			container.addClass('width500');
		} else {
			container.removeClass('width500');
		}
	}).resize();
});