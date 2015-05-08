<script>
 
  
jQuery(document).ready(function(){  

	jQuery(".wp-first-item").each(function( index, value ) {
	  
	   if( $(this).attr("href") == 'admin.php?page=getall' )
	    $(this).hide();
	
	});
	
	
	
	jQuery("#getall_popup_select").change(function(){
		
		
		jQuery("#getall_popup_edit").attr("href","https://www.getall.pl/strony-generator.php?edit="+jQuery(this).val()+"&popup=1");
		jQuery("#getall_popup_preview").attr("href","https://www.getall.pl/modules/popup/?id="+jQuery(this).val()+"&key=<? echo get_option('getall_key'); ?>");
		
		
	});

});
 
</script>
 