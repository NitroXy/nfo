(function($){
	'use strict';

	function ajaxbind(element){
		var $this = $(element);
		var $target = $($this.data('ajax'));
		var href = $this.attr('href');

		$this.click(function(e){
			e.preventDefault();

			$.get(href, {_partial: true}).done(function(data){
				/* temporary wrap in a container so it is possible to find top-level elements */
				var $container = $('<div></div>');
				var $partial = $(data);
				$container.append($partial);

				/* bind any new ajax-based links */
				$partial.find('a[data-ajax]').each(function(){
					ajaxbind(this);
				});

				/* bind cancel action */
				$container.find('*[data-ajax-cancel]').click(function(e){
					e.preventDefault();
					$target.empty();
				});

				/* submit using ajax */
				$container.find('form').submit(function(e){
					/* placeholder, not implemented yet due to handling of file upload */
				});

				$target.html($container);
				$target.get(0).scrollIntoView();
			});
		});
	}

	function init(){
		/* disable options when a preset is selected */
		$('.preset-selector').change(function(){
			var value = $(this).val();
			var any = value !== '';
			$('.hidden-preset').prop('disabled', any);

			if ( any ){
				var preset = presets[value];
				$('input.hidden-preset[name="SchemeItem[color]"]').val(preset.color);
			}
		}).change();

		$('.dropdown-toggle').dropdown();

		/* handle request for ajax-based forms */
		$('a[data-ajax]').each(function(){
			ajaxbind(this);
		});
	}

	$(init);
})(jQuery);
