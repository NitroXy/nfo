(function($){
	'use strict';

	function init(){
		/* disable options when a preset is selected */
		$('.preset-selector').change(function(){
			var any = $(this).val() !== '';
			$('.hidden-preset').prop('disabled', any);
		}).change();
	}

	$(init);
})(jQuery);
