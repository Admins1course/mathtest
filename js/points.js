//суммирование баллов
let points_array=new Map();
function enterPoints(element){
	result=$(element).val();
	rep=/\D/us;
	if (result.length==1){
		rep=/\D/us;
	}
	if (result.length>1){
		if (/[.]/us.test(result.slice(0,-1))){
			if(/[.](\d+)/us.test(result)){
				if(result.match(/[.](\d+)/us)[1].length>1){
					rep=/./us;
				}
			}
			else{
				rep=/\D/us;
			}
		}
		else{
			rep=/[^\d.,]/us;
		}
	}
	if(result.slice(-1)==','){
		result=result.slice(0,-1)+'.';
	}
	$(element).val(result.slice(0,-1)+result.slice(-1).replace(rep,''));
	points_array.set($(element).attr('id'), Number($(element).val()));
}
$(document).ready(function(){
	$('.popup-open').click(function(){
		sum=0;
		points_array.forEach(function(value,key){
			sum+=value;
		});
		$('[type="range"]').attr('max',sum);
		let label_data='';
		for (i=0;i<=10;i++){
			label_data+='<option value="'+((sum/10.0)*i).toFixed(2)+'" label="'+i*10+'%">'
		}
		$('#points_label').html(label_data);
	});
})
function outputPoints(element){
	$('output[for="'+$(element).attr('id')+'"]').text($(element).val());
}