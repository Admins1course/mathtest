<script type="text/javascript">
	$(document).ready(function(){
		$('.open_notifications').click(function(){
			$('.notifications_body').stop().slideToggle(500);
		});
	});
	$('.open_notifications').click( function() {
		$(this).siblings(".notifications_body").slideToggle(500);
		return false;
	});
	//$(document).on("mousedown touchstart",function(e){
  	//var $info = $('.notifications_body');
  //	if (!$info.is(e.target) && $info.has(e.target).length === 0) {
  //  $info.hide();
 // }
//});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
		
		$('.exit_menu').click(function(){
			$('.exit_menu_body').stop().slideToggle(500);
		});
	});


	</script>
	<script>
	$(document).ready(function($) {
	$('.load_avatar_open').click(function() {
		$('.load_avatar_fade').fadeIn();
		return false;
	});	
	
	$('.load_avatar_close').click(function() {
		$(this).parents('.load_avatar_fade').fadeOut();
		return false;
	});		
 
	$(document).keydown(function(e) {
		if (e.keyCode === 27) {
			e.stopPropagation();
			$('.load_avatar_fade').fadeOut();
		}
	});
	
	
});
</script>
<script >
$(function(){
		$(window).scroll(function() {
			if($(this).scrollTop() >= 550) {
				$('#left_block').addClass('stickytop');
			}
			else{
				$('#left_block').removeClass('stickytop');
			}
		});
	});
</script>	