var $activeContainer='';
	var activeContainer1='';
	function getData(){
		$activeContainer=$('textarea:focus');
		activeContainer1=document.querySelectorAll('textarea:focus');
	}
	function strForConvert(str){
		data={};
		data['str']='';
		data['len']=0;
		data['option']=false;
		if (/^$/.test(str)){
			data['str']=false;
			return data;
		}
		else if (/^\\\(/u.test(str)){ //ищем начало строчной формулы
			if (/^\\\(.+?\\\)/us.test(str)){//проверяем имеет ли конец строчная формула
				data['str']=str.match(/^\\\((.+?)\\\)/us)[1];
				data['length']=data['str'].length+4;//4=/(/)
				data['option']='in-row formula';
				return data; //возвращаем строчную формулу
			}
			else{
				data['str']=str.match(/^\\\((.+?)$/)[1];
				data['str']=data['str'].length+4;//4=/(/)
				data['option']='in-row formula';
				return data;
			}
		}
		else if (/^\$\$/u.test(str)){ //ищем начало выключной формулы
			if (/^\$\$.+?\$\$/us.test(str)){ //проверяем имеет ли конец выключная формула
				data['str']=str.match(/^\$\$(.+?)\$\$/us)[1];
				data['length']=data['str'].length+4;//4=$$$$
				data['option']='alternative formula';
				return data; //возвращаем выключную формулу
			}
			else
				data['str']=str.match(/^\$\$(.+?)$/us)[1];
				data['length']=data['str'].length+4;//4=$$$$
				data['option']='alternative formula';
				return data;
		}
		else if (/^./us){
			data['str']=str.match(/^(.+?)(?=\\\(|\$\$|$)/us)[1];
			data['length']=data['str'].length;
			data['option']='text';
			return data;
		}
	}
	
	function convert() {
		//
		//  Get the TeX input
		//
		var input = $activeContainer.val().trim();
		var str='';
		var count=0;
	    //
		//  Disable the display and render buttons until MathJax is done
		//
		var button = document.querySelectorAll('.btnpastepre');
		button.disabled = true;
		//
		//  Clear the old output
		//
		output = activeContainer1[0]['nextElementSibling'];//document.getElementById('left_block');
		output.innerHTML = '';
		//
		//  Reset the tex labels (and automatic equation numbers, though there aren't any here).
		//  Get the conversion options (metrics and display settings)
		//  Convert the input to CommonHTML output and use a promise to wait for it to be ready
		//    (in case an extension needs to be loaded dynamically).
		//
		MathJax.texReset();
		var options = MathJax.getMetricsFor(output);
		while (strForConvert(input)['str']){
			str=strForConvert(input);
			input=input.slice(str['length']);
			if (str['option']=='in-row formula')       options.display=0;
			if (str['option']=='alternative formula')  options.display=1;
			if (str['option']=='text'){
				str['str']='\\mbox\{'+str['str']+'\}';
				options.display=0;
			}
			MathJax.tex2chtmlPromise(str['str'], options).then(function (node) {
				//
				//  The promise returns the typeset node, which we add to the output
				//  Then update the document to include the adjusted CSS for the
				//    content of the new equation.
				//
				output.appendChild(node);
				MathJax.startup.document.clear();
				MathJax.startup.document.updateDocument();
			}).catch(function (err) {
				//
				//  If there was an error, put the message into the output instead
				//
				output.appendChild(document.createElement('pre')).appendChild(document.createTextNode(err.message));
			}).then(function () {
				//
				//  Error or not, re-enable the display and render buttons
				//
				button.disabled = false;
			});
		}
    }
	
	jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                //For browsers like Internet Explorer
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                //For browsers like Firefox and Webkit based
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } 
            else {
                this.value += myValue;
                this.focus();
            }
        })
    }
	});

	var countOfElements= 0;

	$(window).load(function(){
		$('.btnpastepre').click(function() {
			var myhtml=$(this).attr('value');
			$activeContainer.insertAtCaret(myhtml);
			convert();
			var flagOfExist=false;
			if (countOfElements){
				if (countOfElements<=9){
					$('.formul_body:first').children('button').each(function(){
						if (myhtml==$(this).attr('value')){
							flagOfExist=true;
						}
					});
					if(!flagOfExist){
						$(this).clone('withDataAndEvents').insertBefore('button:first');
						countOfElements++;
					}
				}
				else{
					$('.formul_body:first').children('button').each(function(){
						if (myhtml==$(this).attr('value')){
							flagOfExist=true;
						}
					});
					if(!flagOfExist){
						$('.formul_body:first').children('button:last').remove();
						$(this).clone('withDataAndEvents').insertBefore('button:first');
					}
				}
			}
			else{
				$button=$(this).clone('withDataAndEvents');
				$('.formul_body:first').append(function(){return $button});
				countOfElements++;
			}
    })
})