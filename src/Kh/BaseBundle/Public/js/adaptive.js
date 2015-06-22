$(document).ready(function() {
	var container = $(document.body);

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
		if (container.width() <= 650) {
			$('.catsLi > a').removeAttr('data-toggle', '');
			container.addClass('width650');
		} else {
			$('.catsLi > a').attr('data-toggle', 'dropdown');
			container.removeClass('width650');
		}
		if (container.width() <= 500) {
			container.addClass('width500');
		} else {
			container.removeClass('width500');
		}
	}).resize();

	setTimeout(function(){
		$('#wrapper').css('paddingTop', $('#menu').outerHeight());
	}, 500);
});