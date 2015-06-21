$(document).ready(function(){
	$('.comment .commentRemove').deleteComment();
	$('.navbar-search').searchForm();
	$('#comments form').commentForm();
	$('#content img').contentImage();
});

$.fn.contentImage = function(){
	return this.each(function(){
		var img = $(this);
		var realImg = $('<img src="' + img.attr('src') + '" />');

		realImg.load(function(){
			var realWidth = this.width;

			if (realWidth > img.width()) {
				img.wrap('<a class="imageCanZoom" href="' + img.attr('src') + '"></a>');

				var parent = img.parent();
				if (img.attr('title') && img.attr('title').length > 0) {
					parent.attr('title', img.attr('title'));
				} else if (img.attr('alt') && img.attr('alt').length > 0) {
					parent.attr('title', img.attr('alt'));
				}
				parent.append('<span class="zoomIcon"></span>');

				parent.fancybox();
			}
		});
	});
};

$.fn.commentForm = function(){
	return this.each(function(){
		var form = $(this);
		var textarea = form.find('textarea');
		var address1 = form.find('#address1');
		var address2 = form.find('#address2');

		address2.val(address1.val());

		textarea.keydown(function(e){
			if (e.which == 13 && e.ctrlKey) {
				form.submit();
			}
		});
	});
};

$.fn.searchForm = function(){
	return this.each(function(){
		var input = $(this).find('input');

		input.keydown(function(e){
			if (e.which == 13) {
				if (input.val())
					input.parents('form:first').submit();
			}
		});
	});
};

$.fn.deleteComment = function(){
	return this.each(function(){
		var button = $(this);

		button.click(function(){
			if (confirm('Вы действительно хотите удалить комментарий?')) {
				$.ajax({
					data:{
						cid:button.attr('data-cid')
					},
					url:'/735cb427f94a5fd53fe00e757e46f57c',
					type:'post'
				});
				button.parents('.comment:first').animate({
					opacity:0
				}, 'slow', '', function(){
					$(this).remove();
				});
			}
		});
	});
};