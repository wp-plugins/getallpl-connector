<script>
 
  
jQuery(document).ready(function(){  

	$.each(".wp-first-item", function( index, value ) {
	  
	   if( $(this).attr("href") == 'admin.php?page=getall' )
	    $(this).hide();
	
	});

});
 
</script>
