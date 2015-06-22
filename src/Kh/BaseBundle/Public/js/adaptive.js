$(document).ready(function() {
	var container = $(document.body);

	$(window).resize(function () {
		if (container.width() <= 650) {
			$('.catsLi > a').removeAttr('data-toggle', '');
		} else {
			$('.catsLi > a').attr('data-toggle', 'dropdown');
		}
	}).resize();

	setInterval(function(){
		$('#wrapper').css('paddingTop', $('#menu').outerHeight());
	}, 500);
});