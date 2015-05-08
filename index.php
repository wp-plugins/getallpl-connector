<?php
/* 
Plugin Name: GetAll.pl Connector
Version: 1.0.0
Description: Konektor platformy GetAll.pl
Author: GetAll.pl
Author URI: http://getall.pl/
Plugin URI: http://getall.pl/
*/  

 
include('configure.php');

if($_POST["getall_key"])
 {
   add_option('getall_key', $_POST["getall_key"]);
   update_option('getall_key', $_POST["getall_key"]);
 }
 
 
 
function getall_boxy() {
                
     add_meta_box( 'getall_box_ustawienia', 'GetAll.pl PopUp', 'getall_box_ustawienia', 'post', 'normal', 'high' );
 
  }

 
function getall_box_ustawienia( $post ) {
                
   $getall_popup = get_post_meta( $post->ID, 'getall_popup', true);
         		
	   if(get_option('getall_key')) 
		 {
			  
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,
							'key='.get_option('getall_key').'&action=getPopupList');
		 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec ($ch);

				curl_close ($ch);

				$data =  json_decode($server_output, true);
			 
				echo '<select name="getall_popup" id="getall_popup_select">
					  <option value="" '; if($getall_popup == '') echo 'SELECTED'; echo'>Brak</option>';
				
					for($i=1;$i<=count($data);$i++)
					{
						echo '<option value="'.$data[$i]["id"].'" '; if($getall_popup == $data[$i]["id"]) echo 'SELECTED'; echo'>'.$data[$i]["tytul"].'</option>';
					}
				
				echo '</select> <A href="https://www.getall.pl/strony-generator.php?edit='.$getall_popup.'&popup=1" id="getall_popup_edit" target="_blank" style="font-size:20px;"><i class="fa fa-edit"></i></A>';
				echo '  <A href="https://www.getall.pl/modules/popup/?id='.$getall_popup.'&key='.get_option('getall_key').'" target="_blank" id="getall_popup_preview" style="font-size:20px;"><i class="fa fa-sign-out"></i></A>';
		 } 		
		else
		{
			echo '<A href="admin.php?page=getall">Połącz bloga z kontem getall.pl</A>';	
		}
 
   }
 
 
add_action('pre_post_update',  'getall_zapisz_post'); 
 
  
function getall_zapisz_post( $post_ID ) {
	
        global $post;
		update_post_meta($post->ID, 'getall_popup', $_POST["getall_popup"]);	 
			  
  }	
	
	
	
	
if (is_admin()) 
 {  

   function getall_create_menu() 
    {     
     global $current_user;

	 if($current_user -> roles[0] == 'administrator')
	  { 
	     add_action( 'add_meta_boxes', 'getall_boxy' );
		 
	     add_menu_page("GetAll.pl", "GetAll.pl", 0, "getall", "getall_main", plugins_url('getall-connector/icon.png'));    
	      add_submenu_page( 'getall', "PopUp", "PopUp", 0, 'popup', 'getall_popup' ); 
	   
	  }
    }    
 }
 
 
  function getall_admin_register_head() {
 
    $url = WP_PLUGIN_URL.'/getall-connector/style.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' /><script src='//code.jquery.com/jquery-1.11.2.min.js'></script>\n<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>";
	
    include('head.php');
  }
 
  add_action('wp_print_scripts', 'getall_admin_register_head');
  add_action("admin_menu", "getall_create_menu");    

 
 
  
 
function getall_print_popup() {
	
	 global $post;
     
	 if(( !is_home() )AND( !is_front_page() ))
		 $getall_popup = get_post_meta( $post->ID, 'getall_popup', true);
	 

				 
	 
	 if(($getall_popup<>'')AND($getall_popup<>0))
	 {
		 // Popup dla postu
			
			 
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,
							'key='.get_option('getall_key').'&action=getPopupData&id='.$getall_popup);
		 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec ($ch);

				curl_close ($ch);

				$data =  json_decode($server_output, true); 
				$data["data"] = base64_decode($data["data"]);
				
			    $ust_pop = json_decode($data["data"]);
				
				 if($ust_pop[3] == 'center')
					$position = '';
				 
				 if($ust_pop[3] == 'right')
					$position = '&bottom=1';	

				 if($ust_pop[3] == 'top')
					$position = '&top=1';	

				 if($ust_pop[3] == 'bottom')
					$position = '&bottom_center=1';	
				
				echo '<script type=\'text/javascript\' src=\'https://www.getall.pl/modules/popup/popup.min.php?id='.$getall_popup.'&hash='.$data["hash"].'&popup=1&delay='.$ust_pop[0].'&exit_block='.$ust_pop[1].$position.'&theme='.$ust_pop[2].'&efect='.$ust_pop[4].'&ilosc='.$ust_pop[5].'&dni='.$ust_pop[6].'\'></script>';
	
			  
			 
	 }
	 else
	 {
		 // Popup globalny
		 if(get_option('getall_popup_global'))
		 {
			 
				$getall_popup = get_option('getall_popup_global');
				
				
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,
							'key='.get_option('getall_key').'&action=getPopupData&id='.$getall_popup);
		 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec ($ch);

				curl_close ($ch);

				$data =  json_decode($server_output, true); 
				$data["data"] = base64_decode($data["data"]);
				
			    $ust_pop = json_decode($data["data"]);
				
				 if($ust_pop[3] == 'center')
					$position = '';
				 
				 if($ust_pop[3] == 'right')
					$position = '&bottom=1';	

				 if($ust_pop[3] == 'top')
					$position = '&top=1';	

				 if($ust_pop[3] == 'bottom')
					$position = '&bottom_center=1';	
				
				echo '<script type=\'text/javascript\' src=\'https://www.getall.pl/modules/popup/popup.min.php?id='.$getall_popup.'&hash='.$data["hash"].'&popup=1&delay='.$ust_pop[0].'&exit_block='.$ust_pop[1].$position.'&theme='.$ust_pop[2].'&efect='.$ust_pop[4].'&ilosc='.$ust_pop[5].'&dni='.$ust_pop[6].'\'></script>';
		 
			 
			 
		 }
		 
		 
		 
	 }
 
}
add_action('wp_head', 'getall_print_popup');
 
  
  
  
  
  //
  // Widgety
  //
  
  class getall_widget extends WP_Widget {

	// constructor
	function getall_widget() {
	 parent::WP_Widget(false, $name = __('GetAll.pl PopUp', 'getall_widget') );
	}

	// widget form creation
	function form($instance) {	
				 
			// Check values
			if( $instance) {
				 $title = esc_attr($instance['title']);
				 $text = esc_attr($instance['text']);
				 $textarea = esc_textarea($instance['textarea']);
				 $getall_widget_sidebar =  $instance['getall_widget_sidebar'] ;
			} else {
				 $title = '';
				 $text = '';
				 $textarea = '';
				 $getall_widget_sidebar = '';
			}
			?>

			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tytuł', 'getall_widget'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id('getall_widget_sidebar'); ?>"><?php _e('Wybierz widget', 'getall_widget'); ?></label>
			
			
			<select class="widefat" id="<?php echo $this->get_field_id('getall_widget_sidebar'); ?>" name="<?php echo $this->get_field_name('getall_widget_sidebar'); ?>">
			<?
			
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,
							'key='.get_option('getall_key').'&action=getPopupList');
		 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec ($ch);

				curl_close ($ch);

				$data =  json_decode($server_output, true);
			  
			 
  
				echo ' 
					  <option value="" id="null" '; if($getall_widget_sidebar == '') echo 'selected="selected"'; echo'>Brak</option>';
				
					for($i=1;$i<=count($data);$i++)
					{
 
						echo '<option value="' . $data[$i]["id"] . '" id="' . $data[$i]["id"] . '"', $getall_widget_sidebar == $data[$i]["id"] ? ' selected="selected"' : '', '>', $data[$i]["tytul"], '</option>';
					
					
					}
				
				 
				
			?>
			</select>
			
			
			</p>

			 
			<?php
	}

	 
	function update($new_instance, $old_instance) {
	     $instance = $old_instance;
		
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['text'] = strip_tags($new_instance['text']);
		  $instance['textarea'] = strip_tags($new_instance['textarea']);
		  $instance['getall_widget_sidebar'] = strip_tags($new_instance['getall_widget_sidebar']);
		 return $instance;
	}

	 
	function widget($args, $instance) {
	  extract( $args );
    
	   $title = apply_filters('widget_title', $instance['title']);
	   $text = $instance['text'];
	   $textarea = $instance['textarea'];
	   $getall_widget_sidebar = $instance['getall_widget_sidebar'];
	   echo $before_widget;
	   
	   echo '<div class="widget-text wp_widget_plugin_box">';

	    
	   if ( $title ) {
		  echo $before_title . $title . $after_title;
	   }

	   if( $getall_widget_sidebar ) {
		 echo '<p class="wp_widget_plugin_textarea"><script type="text/javascript" src="https://www.getall.pl/modules/popup/widget.min.php?id='.$getall_widget_sidebar.'&key='.get_option('getall_key').'"></script></p>';
		 
		 

 


	   }
	   
	   echo '</div>';
	   echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("getall_widget");'));
  
  
  
  
// WP EDITOR - wstawianie w tresci
  
   

function getall_add_tinymce() {
    global $typenow;
 
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return ;

    add_filter( 'mce_external_plugins', 'getall_add_tinymce_plugin' );
 
    add_filter( 'mce_buttons', 'getall_add_tinymce_button' );
}

 
function getall_add_tinymce_plugin( $plugin_array ) {

    $plugin_array['getall_popup'] = plugins_url( '/getall-connector/js/plugin.js.php?key='.get_option('getall_key')  );
   
    return $plugin_array;
}

 
function getall_add_tinymce_button( $buttons ) {

    array_push( $buttons, 'getall_popup_button_key' );
   
    return $buttons;
}


add_action( 'admin_head', 'getall_add_tinymce' );
 
 
 
 
// SHORTCODES
 
function getall_shortcode_function($atts){
   extract(shortcode_atts(array(
      'id' => 1,
   ), $atts));

   $return_string = '<script type="text/javascript" src="https://www.getall.pl/modules/popup/widget.min.php?id='.$id.'&key='.get_option('getall_key').'"></script>';
 
   return $return_string;
}


 
function register_getall_shortcodes(){
   add_shortcode('getall-widget', 'getall_shortcode_function');
} 
 
 
add_action( 'init', 'register_getall_shortcodes');
 
 
 if(get_option('getall_key') == '{\"type\":\"notesIframeMessage\",\"action\":\"iFrameReady\"}' )
  update_option('getall_key','');

 
function getall_main(){

 ob_start();
 if(get_option('getall_key')) 
  include('popup.php');
 else
  include('activate.php');
 $body = ob_get_contents();
 ob_end_clean();
 
 echo $body;
 
}


	
function getall_popup(){

 ob_start();
 if(get_option('getall_key')) 
  include('popup.php');
 else
  include('activate.php');
 $body = ob_get_contents();
 ob_end_clean();
 
 echo $body;
 
}
	
 
 
?>