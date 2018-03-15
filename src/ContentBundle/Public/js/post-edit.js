$(document).ready(function(){
	$('#form').postEditForm();
});

$.fn.postEditForm = function(){
	return this.each(function(){
		var form = $(this);
		var catsDiv = $('<div class="postCats"></div>');
		var input = form.find('#categories');
		var inputedCats = [];

		$.each(input.val().split(','), function(){
			inputedCats[this] = true;
		});

		$.each(categories, function(){
			var row = $('<label class="pcRow"><input type="checkbox" data-id="' + this.id + '" /> ' + this.name + '</label>');
			var checkbox = row.find('input');

			if (inputedCats[this.id]) {
				checkbox.attr('checked', 1);
			}

			checkbox.change(function(){
				var joins = [];
				catsDiv.find('input:checked').each(function(){
					joins[joins.length] = $(this).data('id');
				});

				input.val(joins.join(','));
			});

			catsDiv.append(row);
		});

		$('.postEdit').before(catsDiv);

		setTimeout(function(){
			catsDiv.css('height', form.outerHeight() * 0.8);
		}, 1000);
	});
};