 
<?php


 if($_POST["save_popup"] == 'Zapisz')
 {
   add_option('getall_popup_global', $_POST["getall_popup_global"]);
   update_option('getall_popup_global', $_POST["getall_popup_global"]); 
 }


 
 if(get_option('getall_key')) 
 {
	  

	
?>

	<h1> Getall.pl / PopUp </h1>
	<h4> Ustaw globalny popup dla bloga</h4>
 
 <?
 
    $getall_popup_global = get_option('getall_popup_global');
	
	
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,
							'key='.get_option('getall_key').'&action=getPopupList');
		 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec ($ch);

				curl_close ($ch);

				$data =  json_decode($server_output, true);
			 
				echo '<form method="POST">
					  <select name="getall_popup_global" id="getall_popup_select">
					  <option value="" '; if($getall_popup_global == '') echo 'SELECTED'; echo'>Brak</option>';
				
					for($i=1;$i<=count($data);$i++)
					{
						echo '<option value="'.$data[$i]["id"].'" '; if($getall_popup_global == $data[$i]["id"]) echo 'SELECTED'; echo'>'.$data[$i]["tytul"].'</option>';
					}
				
				echo '</select> <A href="https://www.getall.pl/strony-generator.php?edit='.$getall_popup_global.'&popup=1" id="getall_popup_edit" target="_blank" style="font-size:20px;"><i class="fa fa-edit"></i></A>';
				echo '  <A href="https://www.getall.pl/modules/popup/?id='.$getall_popup_global.'&key='.get_option('getall_key').'" target="_blank" id="getall_popup_preview" style="font-size:20px;"><i class="fa fa-sign-out"></i></A>';
	   
	   
				echo '<BR><BR><input type=submit name="save_popup" value="Zapisz" class="button button-primary"></form>';
	   
	  }
	  
	?>