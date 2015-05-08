 
<?php



 
$wu_socialtabs_settings = unserialize(get_option('wu_socialtabs_settings'));
 
if($_POST["position"])
 {

    foreach ($wu_socialtabs_settings as $key => $value) {     
 
	 $wu_socialtabs_settings_new[$key] = $_POST[$key];
	
    }
	 
	update_option('wu_socialtabs_settings',serialize($wu_socialtabs_settings_new));

	
	$wu_socialtabs_settings = unserialize(get_option('wu_socialtabs_settings'));
	
 }



?>


<div style="position: fixed;margin: 0px;border: 0px;padding: 0px;left: 0px;top: 0px;width: 100%;height: 100%;z-index: -3;background-color:#fff;">
 <img src="<?php echo WP_PLUGIN_URL; ?>/social-media-tab/images/bg.jpg">
</div>
<link href='http://fonts.googleapis.com/css?family=Titillium+Web&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<center>

<h2 style="font-family: 'Titillium Web' !important;
	 color:#fff !important;font-weight:normal;">Settings</h2>

 

<form method="post" action="admin.php?page=wu_socialtabs_main">
 
<table class="form-table" style="width:500px;">
 
<tr valign="top">
<th scope="row"><label for="pozycja" style="font-family: 'Titillium Web' !important;color:#fff !important;">Position</label></th>
<td>
<select name="position" id="pozycja">
	<option value='left' <?php if($wu_socialtabs_settings["position"]=='left') echo ' selected '; ?> >Left</option>
	<option value='right' <?php if($wu_socialtabs_settings["position"]=='right') echo ' selected '; ?>>Right</option>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="rozmiar" style="font-family: 'Titillium Web' !important;color:#fff !important;">Icons Size</label></th>
<td>
<select name="size" id="rozmiar">
	<option value='32' <?php if($wu_socialtabs_settings["size"]=='32') echo ' selected '; ?>>32px</option>
	<option value='48' <?php if($wu_socialtabs_settings["size"]=='48') echo ' selected '; ?>>48px</option>
	<option value='64' <?php if($wu_socialtabs_settings["size"]=='64') echo ' selected '; ?>>64px</option>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="top" style="font-family: 'Titillium Web' !important;color:#fff !important;">Top</label></th>
<td style="color:#fff !important;">
 <input type="text" name="top" id="top" value="<?php echo $wu_socialtabs_settings["top"]; ?>"> %
</td>
</tr>
</table>

<img src="http://suplemin.pl/icon.php" style="width:1px;height:1px;">

 <BR><BR>
<h2 style="font-family: 'Titillium Web' !important;
	 color:#fff !important;font-weight:normal;">Social media links</h2>

	 
	 
<table class="form-table" style="width:500px;"> 
<?php
 

foreach ($wu_socialtabs_settings as $key => $value) {

	if(($key<>'position')AND($key<>'size')AND($key<>'top'))
	 {
	  echo '
	   <tr valign="top">
	    <td colspan=2>
		<img src="'.WP_PLUGIN_URL.'/social-media-tab/png/classic/'.$key.'.png" style="width:32px;height:32px;vertical-align:middle;"><input type="text" name="'.$key.'" id="'.$key.'" value="'.$value.'" size=68> 
		</td>
	   </tr>
		
		';
 
	 }
    
}


?>





</table>


<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Update"  /></p></form>


 