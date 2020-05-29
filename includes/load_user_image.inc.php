<script>
$(document).ready(function(){
	var avatar=document.getElementById('profile_avatar');
	avatar.innerHTML='';
	avatar.style.backgroundImage=<?='"url('.$path.')"'?>;
	var rect=document.getElementById("avatar-full-size");
	var circ=document.getElementById("file-img-preview");
	rect.src = <?='"'.$path.'"'?>;
	circ.src = <?='"'.$path.'"'?>;
})
</script>