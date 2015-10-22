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

		/* image gallery */
		$target.find('.image-gallery .image-thumbnail').click(function(e){
			e.preventDefault();

			/* prepare */
			var $this = $(this);
			var selector = $this.data('target');
			var $editor = $(selector) || $target.find(selector);
			var editor = $editor.get(0);
			var src = $this.find('img').data('image');
			var md = "![alt-text](" + src + ")";
			var caret = editor.selectionStart;
			var content = $editor.val();

			/* append markdown to editor */
			$editor.val(content.substring(0, caret) + md + content.substring(caret));
			$editor.focus().change();
			editor.selectionStart = editor.selectionEnd = caret + md.length;
		});

		var schedule_marks = {
			reset: function(){
				$('#schedule .schedule-clock').removeClass('in');
			},
			update: function(begin, end){
				for ( var i = begin; i < end; i++ ){
					var selector = '#schedule .schedule-clock[data-hour="' + i + '"]';
					$(selector).addClass('in');
				}
			},
		};

		/* schedule hover */
		$('#schedule .schedule-item').hover(function(){
			var $this = $(this);
			var begin = $this.data('begin');
			var end = $this.data('end');

			/* unwrap hours, that is put 01 back as the 25th hour (as it appears in the rendering) */
			if ( begin < DAY_ENDS ){
				begin += 24;
			}
			if ( end < begin ){
				end += 24;
			}

			schedule_marks.reset();
			schedule_marks.update(begin, end);
		}, function(){
			schedule_marks.reset();
		});
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
