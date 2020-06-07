$(document).ready(function () {
  $( "#dialog_window_1" ).dialog({
    autoOpen: false
  });
  
  $("#create-invite").click(function() {
    $("#dialog_window_1").dialog('open');
     
  });
 

	$("#dialog_window_1").bind("dialogopen", function(){
    $("#dialog_window_1").dialog( "option", "modal", true );
    /*console.log($(this));
    let par=this.parentElement;
    let wrapper = document.createElement('div');
    wrapper.classList.add('popup-fade');
    wrapper.innerHTML = par.outerHTML;
    par.parentNode.replaceChild(wrapper,par);
    par.classList.add('ui-widget'); 
      $('.popup-fade').fadeIn(0);*/

		let testmenu=document.getElementById("testmenu");
	});
    $( "#dialog_window_1" ).on( "dialogbeforeclose", function( event, ui ) {
      $("#dialog_window_1").dialog( "option", "modal", false );} );

});

  /*$(document).ready(function($) {
    $('#create-invite').click(function() {
     
      return false;
    });
      
     $('.form_btn_close').click(function() {
       $(this).parents('.popup-fade').fadeOut(0);
      return false;
     });   
     
    $(document).keydown(function(e) {
      if (e.keyCode === 27) {
        e.stopPropagation();
         $('.popup-fade').fadeOut(0);
       }
    });
      
    $('.popup-fade').click(function(e) {
      if ($(e.target).closest('.popup').length == 0) {
          $(this).fadeOut(0);         
       }
     });
   });*/
