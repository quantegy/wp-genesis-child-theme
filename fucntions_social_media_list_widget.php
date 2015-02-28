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
		$control_ops = array( 'id_base' => 'social-media-list-widget' );

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
		
		$uci_debug = false;
		
		$selectable_platforms = array(
			array('Facebook','facebook'),
			array('Twitter','twitter'),
			array('YouTube','youtube'),
			array('Instagram','instagram'),
			array('LinkedIn','linkedin'),
			array('Google+','google-plus'),
			array('Flickr','flickr'),
			array('Pinterest','pinterest'),
			array('Tumblr','tumblr')
		);

		$title = isset ( $instance['title'] ) ? $instance['title'] : '';
		$title = esc_attr( $title );
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<button class="uci-social uci-add">Add link</button>			

<?php
			
		if ( isset( $instance['links'] ) ) {
			$links = $instance['links'];
		} else {
			$links = array();
		}
		
		if ( $_POST['uci-add'] == 'add' ) {
			array_unshift( $links, array( 'platform'=>'','url'=>'' ) );
			//array_splice( $links, 0, 0, 'add' );
		}
		
		if ( $_POST['uci-insert'] && ctype_digit( $_POST['uci-insert'] ) ) {
			$position = $_POST['uci-insert'];
			if ( $position > 0 && $position <= count( $links )  ) {
				array_splice( $links, $position, 0, 'insert' );
			}
			$links[$position] = array( 'platform'=>'', 'url'=>'' );
		}
		
		if ( $_POST['uci-remove'] && ctype_digit( $_POST['uci-remove'] ) ) {
			if ( count( $links ) == 1 ) {
				$links = array();
				$instance['links'] = array();
			} else {
				$position = $_POST['uci-remove'] - 1; // because array indices start at 0
				if ( $position >= 0 && $position < count( $links )  ) {
					array_splice( $links, $position, 1);
				}
			}
		}
		

		if ( $uci_debug ) {
			echo '<br>';
			print_r($links);
			echo '<hr>';
		}		

		foreach ( $links as $key => $value ) {			
			
?>

		<p>
			<div class="genesis-widget-column-box uci-social-container" data-position="<?php echo $key + 1; ?>">
				
<?php
			
			if ( $uci_debug ) {
				print_r($value);
				print "<p>Platform: " . $value[platform] . "</p>";
				echo '<p>URL: ' . $value[url] . '</p>';
				echo '<hr>';
			}
			
?>			
			<fieldset>
				<legend><strong>Social Media Link <?php echo $key + 1; ?></strong></legend>
				<p>
					<label>Platform:
						<select name="<?php echo $this->get_field_name( 'links' ); ?>[<?php echo $key; ?>][platform]">
							<option></option>
<?php
	
			foreach ($selectable_platforms as $selection) {
				echo '<option value="' . $selection[1] . '"';
				if ( $selection[1] == $value[platform] )
					echo ' selected="selected"';
				echo '>' . $selection[0] . '</option>';
			}
	
?>
						</select>
					</label>
				</p>
				<p>	
					<label>Link:
						<input name="<?php echo $this->get_field_name( 'links' ); ?>[<?php echo $key; ?>][url]" value="<?php echo $value[url] ?>"/>
					</label>
				</p>
			</fieldset>
			<p>
				<button class="uci-social uci-insert">Insert link below</button>
				<button class="uci-social uci-remove">Remove this link</button>
			</p>
			</div>
		</p>

<?php
							
		}
?>

		<script>
			
			(function($) {
				/**
				 * The idea here is that the add/insert/remove buttons
				 * inject hidden form inputs and auto-submit the form.
				 * Those form input values are used by php to manage the 
				 * links array one element at a time.
				 */ 
				 
				$('button.uci-social').on('click', function(event) {
					event.preventDefault();
				});
				
				$('.uci-add').on('click', function() {
					$(this).parent('.widget-content')
						.append('<input type="hidden" name="uci-add" value="add"/>')
						.siblings('.widget-control-actions')
							.find('.widget-control-save')
								.trigger('click');
				});
				
				$('.uci-insert').on('click', function() {
					var position = $(this).parents('.uci-social-container').attr('data-position');
					
					$(this).parents('.widget-content')
						.append('<input type="hidden" name="uci-insert" value="' + position + '"/>')
						.siblings('.widget-control-actions')
							.find('.widget-control-save')
								.trigger('click');
				});
				
				$('.uci-remove').on('click', function() {
					var position = $(this).parents('.uci-social-container').attr('data-position');
					
					$(this).parents('.widget-content')
						.append('<input type="hidden" name="uci-remove" value="' + position + '"/>')
						.siblings('.widget-control-actions')
							.find('.widget-control-save')
								.trigger('click');
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
		} else {
			$instance['links'] = array();
		}

		return $instance;
	}

}
?>