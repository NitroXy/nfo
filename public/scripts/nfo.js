(function($){
	'use strict';

	var preview_timer = null;

	function preview($container, element){
		var $this = $(element);
		var selector = $this.data('preview');
		var $target = $(selector) || $container.find(selector);
		$target.addClass('loading');
		$.ajax({
			url: root + '/admin/markdown?_partial=true',
			method: 'post',
			contentType: 'text/markdown',
			processData: false,
			data: $this.val(),
		}).done(function(parsed){
			$target.html(parsed);
		}).always(function(){
			$target.removeClass('loading');
		});
	}

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

		/* bind any preview listeners */
		$target.find('textarea[data-preview]').on('change keyup paste', function(){
			var element = this;
			if ( preview_timer ) clearTimeout(preview_timer);
			preview_timer = setTimeout(function(){
				preview_timer = null;
				preview($target, element);
			}, 200);
		}).change();
	}

	function ajaxopen(state){
		/* temporary wrap in a container so it is possible to find top-level elements */
		var $container = $('<div></div>');
		var $partial = $(state.partial);
		$container.append($partial);

		/* initialize new dom */
		dominit($container);

		/* bind cancel action */
		$container.find('*[data-ajax-cancel]').click(function(e){
			e.preventDefault();
			$target.empty();

			/* hack: clear #preview (hardcoded id) */
			$('#preview').empty();
		});

		/* submit using ajax */
		$container.find('form').submit(function(e){
			/* placeholder, not implemented yet due to handling of file upload */
		});

		var $target = $(state.target);
		console.log(state);
		console.log(state.target, $target);
		$target.html($container);
		$target.get(0).scrollIntoView();
	}

	function ajaxbind(element){
		var $this = $(element);
		var target = $this.data('ajax');
		var href = $this.attr('href');

		$this.click(function(e){
			e.preventDefault();

			/* hack: clear #preview (hardcoded id) */
			$('#preview').empty();

			$.get(href, {_partial: true}).done(function(data){
				var state = {partial: data, target: target};
				history.pushState(state, '', href);
				ajaxopen(state);
			});
		});
	}

	window.onpopstate = function(event){
		if ( event.state ){
			ajaxopen(event.state);
		} else {
			/* hack: hardcoded id */
			$('#work').empty();
		}
	}

	function init(){
		dominit(document);
		$('.dropdown-toggle').dropdown();
	}

	$(init);
})(jQuery);
