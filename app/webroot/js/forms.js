var f = {
		saveForm:function(objForm){
			//alert(1);
			if(f.defaultMarked()){
				if(!window.confirm('You marked this record as "Default". It is mean replace the current Default record. Is that what you want?')){
					return false;
				}
			}
			$(".ajaxLoadForm").show();
			
			$.ajax({
					type:'POST',
					url:'/remote/processRequest/saveForm/' + f.extractModel(objForm) ,
					dataType:'json',
					data:$(objForm).serialize(),
			}).done(
							function(response){
								var fieldId = "#" + response.model + "Id";
								$(fieldId).val(response.id);
								$(".saved").show();
								$(".ajaxLoadForm").hide();
							}
					).fail(function(response,textStatus){
						alert("Something went wrong! Try submit again.");
						$(".ajaxLoadForm").hide();
					});
			return false;
		},
		extractModel:function(objForm){
			return objForm.name;
		},
		defaultMarked:function(){
			var lst = $('input[type=checkbox]').filter(function(){ return this.id.match('Default*'); });
			for(i=0;i<lst.length;i++){
				if($(lst[i]).is(":checked")){
					return true
				}
			}
			return false;
			//alert($('input:regex(name,*default*').val());
			//if($('input:regex(name,*default*').val() == '1'){
				
			//}
		}
}