(function($){

	jQuery.fn.mDialog = function (options) {
		
		// Some jConfirmAction options (limited to customize language) :
		// question : a text for your question.
		// yesAnswer : a text for Yes answer.
		// cancelAnswer : a text for Cancel/No answer.
		var theOptions = jQuery.extend ({
			question: "Emin Misiniz ?",
			yesAnswer: "Evet",
			cancelAnswer: "Hayır"
		}, options);
		
		return this.each (function () {
			
			$(this).bind('click', function(e) {

				e.preventDefault();
				thisHref	= $(this).attr('href');
				
				if($(this).next('.question').length <= 0)
					$(this).after('<div class="question">'+theOptions.question+'<br/> <span class="yes">'+theOptions.yesAnswer+'</span><span class="cancel">'+theOptions.cancelAnswer+'</span></div>');
				
				$(this).next('.question').animate({opacity: 1}, 300);
				
				$('.yes').bind('click', function(){
					window.location = thisHref;
				});
		
				$('.cancel').bind('click', function(){
					$(this).parents('.question').fadeOut(300, function() {
						$(this).remove();
					});
				});
				
			});
			
		});
	}
	
})(jQuery);