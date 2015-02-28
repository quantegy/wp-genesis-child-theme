<?php

/**
 * Social Media List widget
 * Displays a list of social media links with icons
 *
 * @version 20150210
 */

add_action( 'widgets_init', 'uci_register_social_media_list_widget' );
function uci_register_social_media_list_widget() {
	register_widget( 'UCI_Social_Media_List_Widget' );
}

class UCI_Social_Media_List_Widget extends WP_Widget {
	
	/*
	 * Widget setup.
	 */
	function UCI_Social_Media_List_Widget() {
		//* Widget settings.
		$widget_ops = array( 'classname' => 'social', 'description' => __('Displays a list of social media links with icons.', 'social') );

		//* Widget control settings.
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'social-media-list-widget' );

		//* Create the widget.
		$this->WP_Widget( 'social-media-list-widget', __('UCI - Social Media List', 'contact'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		//* Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );

		//* Before widget (defined by themes).
		echo $before_widget;

		//* Display the widget title if one was input (before and after defined by themes).
		if ( $title )
			echo $before_title . $title . $after_title;
			
		//TODO: SHOW GUTS HERE
			
		//* After widget (defined by themes).
		echo $after_widget;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	public function form( $instance ) {
				
		$links = isset ( $instance['links'] ) ? $instance['links'] : array( array( 'platform'=>'', 'url'=>'' ) );
		$scope_php = str_replace( '[links]', '',  $this->get_field_name( 'links' ));
		$scope_html = str_replace( '[', '-', $scope_php );
		$scope_html = str_replace( ']', '', $scope_html );
		
		
		echo '<p>Links: '.count($links).'</p>';
		print_r( $links );
		echo '<hr>';
		
		echo '<p>Scope php:</p>';
		echo $scope_php;
		echo '<hr>';
		echo '<p>Scope html:</p>';
		echo $scope_html;
		echo '<hr>';
		echo '<div id="' . $scope_html . '" class="uci-social-container">';
		$title = isset ( $instance['title'] ) ? $instance['title'] : '';
		$title = esc_attr( $title );
?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
			<button class="uci-social uci-add">Add link to top</button>
<input type="submit" name="savewidget" class="widget-control-save" value="Save">
		</div>
		<script>
			
			(function($) {
				/** 
				 * BIG IMPORTANT NOTE!!
				 * 
				 * DOM manipulation gets tricky because there can
				 * be multiple instances of a widget on the page.
				 * 
				 * Be sure to limit the scope of DOM manipulations 
				 * to only the desired widget instance.
				 *
				 * The scope var helps for this.
				 */
				
				var selectable_platforms = [
					// name, value
					['Facebook','facebook'],
					['Twitter','twitter'],
					['YouTube','youtube'],
					['Instagram','instagram'],
					['LinkedIn','linkedin'],
					['Google+','google-plus'],
					['Flickr','flickr'],
					['Pinterest','pinterest'],
					['Tumblr','tumblr']
				];
								
<?php
	
		echo 'var scope = "#' . $scope_html . '";';
		echo 'var prefix = "' . $scope_php . '";';
	
		// Iterate over a php array to pump out html with javascript
		foreach ( $links as $key => $value ) {
				
			$platformName = $this->get_field_name( 'links' ) . '[' . $key . '][platform]';
			$platformValue = $instance['links'][$key][platform];
			$urlName = $this->get_field_name( 'links' ) . '[' . $key . '][url]';
			$urlValue = $instance['links'][$key][url];
			//echo 'insert_link( $(scope).find(".uci-add"),"' . $platformName . '","' . $platformValue . '","' . $urlName . '","' . $urlValue . '");';
			
		}
?>
				
				console.log('scope: ' + scope);
				console.log('prefix: ' + prefix);
							
				function insert_link(elem, platformName, platformValue, urlName, urlValue) {
										
					var link_html = '<div class="genesis-widget-column-box uci-social-link"> \
						<fieldset> \
							<legend><strong>Social Media Link</strong></legend> \
							<p> \
								<label>Platform: \
									<select name="' + platformName + '" class="uci-social">';
									
					for (i = 0; i < selectable_platforms.length; i++) {
						link_html += '<option value="' + selectable_platforms[i][1] + '"';
						if (platformValue == selectable_platforms[i][1]) {
							link_html += ' selected';
						}
						link_html += '>' + selectable_platforms[i][0] + '</option>';
					}
									
						link_html += '			</select> \
								</label> \
							</p> \
							<p> \
								<label>Link: \
									<input name="' + urlName + '" class="uci-social" value="' + urlValue + '"/> \
								</label> \
							</p> \
						</fieldset> \
					</div>';
					
					elem.after(link_html);
					order_links();
				}
				
				function order_links() {
					
					var links = $(scope).find('.uci-social-link'),
						link_counter = 0;
					
					links.each(function(){
						//$(this).find('legend').html('<strong>Social Media Link ' + ++link_counter + ' of ' + links.length + '</strong>');
						//$(this).find('select.uci-social')
						//$(this).find('input')
					});
					
				}
				
			
				$('button.uci-social').click(function(event) {
					event.preventDefault();
				});
				
				$('button.uci-add').click(function(event) {
					insert_link($(this), prefix+'[0][platform]', '', prefix+'[0][url]', '');
					console.log('button add');
					
				});

			}
			(jQuery)
			);
		</script>

<?php

	}







	/**
	 * Update the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = esc_html( $new_instance['title'] );
		
		if ( isset ( $new_instance['links'] ) ) {
			$instance['links'] = $new_instance['links'];
		}

		return $instance;
	}

}
?>