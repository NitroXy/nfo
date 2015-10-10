(function($){
	'use strict';

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
	}

	$(init);
})(jQuery);
