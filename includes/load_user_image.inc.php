<?php require_once 'checkSession.inc.php';
if ($is_login):?>
	<script>
	$(document).ready(function(){
		var avatar=document.getElementById('profile_avatar');
		avatar.innerHTML='';
		avatar.style.backgroundImage=<?='"url('.htmlspecialchars($path).')"'?>;
		var rect=document.getElementById("avatar-full-size");
		var circ=document.getElementById("file-img-preview");
		rect.src = <?='"'.htmlspecialchars($path).'"'?>;
		circ.src = <?='"'.htmlspecialchars($path).'"'?>;
		var bigAvatar=document.getElementById('profile_img');
		bigAvatar.style.backgroundImage=<?='"url('.htmlspecialchars($path).')"'?>;
	})
	</script>
<?php endif;?>