$(document).ready(function(){
		
   $("#master_container").on('click', "#sendRequest", function(e) {
   	$('#sendRequest').prop('disabled',true);
   	NProgress.start();
   	var error = "";
   	var title = $.trim($("#titleRequest").val());
   	var request = $.trim($("#textarea").text());
   	  	
   	if (request.length < 0 || request == ""){
   		error = "Formula la domanda!"
   	}
   	if (title.length < 0 || title == ""){
   		error = "Assegna un titolo alla domanda!"
   	}
   	
   	if (error == "") {
   		$.ajax({
			type: 'POST',
			url: 'send_request.php',
			data: '&title='+ title + '&request='+ request,
			success: function(result){
				if (result == "Antiflood Control Active") {
					if ($('#messageAlert').length) {
	     				NProgress.done();
	     				$('#sendRequest').prop('disabled',false);
					}else{
   					$("#master_container").append('<div id="messageAlert">'+result+'</div>');
   					setTimeout('$("#messageAlert").remove()',2000); 
   					$('#sendRequest').prop('disabled',false);
   					NProgress.done();
   				}
				}else{
						if (result == "sent") {
							NProgress.done();	
							$("#textarea").text("");
							$("#titleRequest").val("");
							//$('<form action="similar-requests.php" method="POST"><input type="hidden" name="title" value="'+title+'"/></form>').appendTo('body').submit();
            			window.location.href = "similar-requests.php?title="+title;
            		}else{
            			if ($('#messageAlert').length) {
	     						NProgress.done();
	     						$('#sendRequest').prop('disabled',false);
							}else{
   							$("#master_container").append('<div id="messageAlert">'+result+'</div>');
   							setTimeout('$("#messageAlert").remove()',2000); 
   							$('#sendRequest').prop('disabled',false);
   							NProgress.done();
   						}
						}
				}
			}
			});
   	}else {
   		if ($('#messageAlert').length) {
	     		NProgress.done();
	     		$('#sendRequest').prop('disabled',false);
			}else{
   			$("#master_container").append('<div id="messageAlert">'+error+'</div>');
   			setTimeout('$("#messageAlert").remove()',2000); 
   			$('#sendRequest').prop('disabled',false);
   			NProgress.done();
   		}
   	} 	
	});
});