(function($){
	'use strict';

	function dominit(element){
		var $target = $(element);

		/* disable options when a preset is selected */
		$target.find('.preset-selector').change(function(){
			var value = $(this).val();
			var any = value !== '';
			$target.find('.hidden-preset').prop('disabled', any);

			if ( any ){
				var preset = presets[value];
				$target.find('input.hidden-preset[name="SchemeItem[color]"]').val(preset.color);
			}
		}).change();

		/* bind any new ajax-based links */
		$target.find('a[data-ajax]').each(function(){
			ajaxbind(this);
		});
	}

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

				/* initialize new dom */
				dominit($container);

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
		dominit(document);
		$('.dropdown-toggle').dropdown();
	}

	$(init);
})(jQuery);
