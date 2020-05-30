$(document).ready(function () {
  $( "#dialog_window_1" ).dialog({
    autoOpen: false
  });
  
  $("#create-invite").click(function() {
    $("#dialog_window_1").dialog('open');
  });
  
  $( "#dialog_window_1" ).on( "dialogbeforeclose", function( event, ui ) {} );
});