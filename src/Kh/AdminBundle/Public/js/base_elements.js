$.fn.datePicker = function(withTime) {
	return this.each(function(){
		var params = {
			closeText: 'Закрыть',
			prevText: '&#x3c;Пред',
			nextText: 'След&#x3e;',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
				'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
				'Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			timeText: 'Время',
			hourText: 'Часы',
			minuteText: 'Минуты',
			timeFormat: "HH:mm",
			isRTL: false
		};

		if (withTime) {
			$(this).datetimepicker(params);
		} else {
			$(this).datepicker(params);
		}
	});
};

$.fn.wysiwyg = function(){
	var input = $(this);

	input.css('height', 400);

	input.tinymce({
		script_url: '/bundles/khadmin/tinymce/tinymce.min.js',
		content_css: '/bundles/khadmin/css/tinymce.css',
		language:'ru',
		plugins:'image,paste,code,link,media',//inlinepopups,,advlink',
		image_advtab:true,
		toolbar:'bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,cut,copy,paste,|,link,unlink,|,image,|,code,removeformat',
		convert_urls:false,
		relative_urls:false,
		document_base_url:'/',
		browser_spellcheck:true,
		paste_as_text:true,
		media_alt_source:false,
		media_poster:false,
		media_dimensions:true,
		media_filter_html:false,
		width:900,
		rel_list: [
			{title: 'Нет', value: ''},
			{title: 'Скрыть от поисковиков', value: 'nofollow'}
		],
		file_picker_callback:function(callback, value, meta) {
			input.tinymce().windowManager.open({
				title:'Загрузка ' + (meta.filetype == 'file' ? 'файла' : 'изображения'),
				url:'/admin/56eb28693ab23b9d53bd0792ad47ca8c?type=' + meta.filetype,
				width:320,
				height:150
			}, {
				callback: callback
			});
		}
	});

};