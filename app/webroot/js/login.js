var login = {
		validaLogin: function(){
			
			var form = $('#loginIndexForm');
			$("#loginNotPossible").hide();
			if (($('#loginUsername').val() != "") && ($('#loginPassword').val() != "")){
				$('.ajaxLoading').show();
				$.ajax({
					type:'POST',
					url:'/remote/processRequest/checkLogin',
					data:$('#loginIndexForm').serialize(),
					dataType: "json"}).done
					(function(response){
						//alert(response.result);
						if(response.loginResult == "error"){
							$("#loginNotPossible").show();
						}else{
							window.location = "/dash_board";	
						}
						$('.ajaxLoading').hide();
						
					}).fail(function(response,textStatus){
						//alert(textStatus);
						alert('Something goes wrong. Please try again.');
						$('.ajaxLoading').hide();
					});
			}else{
				alert('You must provide username and password to log in the system.');
			}
			
			return false;
		},
		forgotPassword:function(){
			if(($('#loginUsername').val() != "")){
				$('.ajaxLoading').show();
				$.ajax({
					type:'POST',
					url:'/remote/processRequest/forgotPassword',
					data:$('#loginIndexForm').serialize(),
					dataType: "json"}).done
					(function(response){
						alert(response.message);
						$('.ajaxLoading').hide();
						//window.location = "/dash_board";
					}).fail(function(response,textStatus){
						alert('Something goes wrong. Please try again.');
						$('.ajaxLoading').hide();
						//alert(textStatus);
					});
			}else{
				alert('You must provide User ID.');
			}
			
		}
		
}