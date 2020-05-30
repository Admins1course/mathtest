<script type="text/javascript">
 $(function () {
  $( "#dialog_window_1" ).dialog({
    autoOpen: false
  });
  
  $("#create-invite").click(function() {
    $("#dialog_window_1").dialog('open');
  });
});
</script>
