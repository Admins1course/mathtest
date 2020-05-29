var files;
$(document).ready(function(){
	$('#custom-file-upload').on("change",function(event){
		files = this.files;
		if (typeof files != 'undefined') {
			var oFReader = new FileReader();
			oFReader.readAsDataURL(files[0]);
			oFReader.onload = function (oFREvent) {
				var rect=document.getElementById("avatar-full-size");
				var circ=document.getElementById("file-img-preview");
				rect.src = oFREvent.target.result;
				circ.src = oFREvent.target.result;
			};
			event.stopPropagation(); // остановка всех текущих JS событий
			event.preventDefault();  // остановка дефолтного события для текущего элемента

			// создадим объект данных формы
			var data = new FormData();
			// заполняем объект данных файлами в подходящем для отправки формате
			$.each( files, function( key, value ){
				data.append( key, value );
			});

			// добавим переменную для идентификации запроса
			data.append( 'my_file_upload', 1 );
			var loading=document.getElementById('filupp');
			loading.style.display="none";
			var waiting=document.getElementById('Loading-image-text');
			waiting.style.display="block";
			// AJAX запрос
			$.ajax({
				url         : document.location.origin+"/loadAvatars.php",
				type        : 'POST', // важно!
				data        : data,
				cache       : false,
				dataType    : 'json',
				// отключаем обработку передаваемых данных, пусть передаются как есть
				processData : false,
				// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
				contentType : false, 
				// функция успешного ответа сервера
				success:function(data){
					avat=document.getElementById('profile_avatar');
					avat.innerHTML='';
					avat.style.backgroundImage="url(avatars/"+data['id']+"/"+data['name']+")";
					loading.style.display="block";
					waiting.style.display="none";
				},
				// функция ошибки ответа сервера
				error: function(data){
					console.log(data);
					loading.style.display="block";
					waiting.style.display="none";
				}
			});	
		}
	});
})