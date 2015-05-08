




<center>
<BR><BR><BR><BR><BR>
<BR><BR><BR><BR><BR>
<img src="https://www.getall.pl/FRONTEND/images/logo.png">
 
</center>

 
 
<div style="position: fixed;margin: 0px;border: 0px;padding: 0px;left: 0px;top: 0px;width: 100%;height: 100%;z-index: -3;background-color:#fff;">
 
</div>
<link href='http://fonts.googleapis.com/css?family=Titillium+Web&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	
<center>		
 
 

<h2 style="font-family: 'Open Sans' !important;
	 color:#000 !important;font-weight:normal;">Połącz swoje konto GetAll.pl z blogiem</h2>

 

 <a href="#" id="activate" style="font-family:open sans;" class="button button-primary"/>Połącz</A>
 
 <form method="post" id="activate-form">
 
    <input type="submit" id="zakoncz" style="font-family:open sans;display:none;" class="button button-primary" value="Zakończ konfigurację"/> 

	<input type=hidden name="getall_key" id="apikey">
 </form>
 
 
 
</center>

 
<script>


	window.addEventListener("message", receiveMessage, false);

		function receiveMessage(event)
		{
  
		  jQuery("#apikey").val(event.data);
		  
		  if(event.data != '{\"type\":\"notesIframeMessage\",\"action\":\"iFrameReady\"}')
		   jQuery("#activate-form").submit();
		   
		}


	 jQuery(document).ready(function(){  

		jQuery("#activate").click(function(){
			 
			window.open('https://www.getall.pl/login.php?action=login&zrodlo=wordpress-plugin&goto=https://www.getall.pl/api/wordpress/connect.php?url=<? echo get_site_url(); ?>', '_blank', 'location=yes,height=600,width=500,scrollbars=yes,status=no');
			 
		});
		
		
 	 });
	 
	 
</script>