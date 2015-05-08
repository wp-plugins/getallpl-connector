( function() {
    tinymce.PluginManager.add( 'getall_popup', function( editor, url ) {

        // Add a button that opens a window
        editor.addButton( 'getall_popup_button_key', {

             
            image: 'https://www.getall.pl/assets/img/widget-icon.png',
			tooltip: 'Wstaw GetAll.pl Widget',
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: 'Wstaw widget',
                    body: [{type: 'listbox', 
							name: 'widg', 
							label: '', 
							'values': [
							<?
							 
								$ch = curl_init();

								curl_setopt($ch, CURLOPT_URL,"http://www.getall.pl/api/wordpress/index.php");
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS,
											'key='.$_GET["key"].'&action=getPopupList');
						 
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

								$server_output = curl_exec ($ch);

								curl_close ($ch);

								$data =  json_decode($server_output, true);
						 
									for($i=1;$i<=count($data);$i++)
									{
										echo '{text: \''.$data[$i]["tytul"].'\', value: \''.$data[$i]["id"].'\'}, ';
									}
													
							
							?>
								
								{text: '', value: ''}
							
							]
						}],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        editor.insertContent( '[getall-widget id="' + e.data.widg + '"]' );
                    }

                } );
            }

        } );

    } );

} )();