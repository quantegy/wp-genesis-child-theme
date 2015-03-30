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
		$this->WP_Widget( 'social-media-list-widget', __('UCI - Social Media List', 'social'), $widget_ops, $control_ops );
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
			
		//* Display social media links
		if ( count( $instance['links'] ) > 0 ) {
			
			if ( 'horz' == $instance['arrangement'] )
				$arrangement = ' uci-social-horz';
			
			echo '<ul class="uci-social' . $arrangement . '">';
			
			if ( 'icon' == $instance['display'] )
				$hideText = ' class="screen-reader-text"';
			
			foreach( $instance['links'] as $link ) {
				$platformParts = explode( '__',  $link['platform']);
				if ( $link['url'] && trim( $link['url'] ) != '' ) {
					echo '<li><a href="' . $link['url'] . '"><i class="fa fa-' . $platformParts[0] . '"></i><span' . $hideText . '>' . $platformParts[1] . '</span></a></li>';
				}
				
			}
			
			echo '</ul>';
		}
			
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
		
		if ( $uci_debug ) {
			print_r($instance);
			echo '<hr>';
		}		
		
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
		
		<p>
			<label>Arrangement:
				<select name="<?php echo $this->get_field_name( 'arrangement' ); ?>">
<?php
					echo '<option value="vert"';
					if ( 'vert' == $instance['arrangement'] )
						echo ' selected';
					echo '>Vertical</option>';
					echo '<option value="horz"';
					if ( 'horz' == $instance['arrangement'] )
						echo ' selected';
					echo '>Horizontal</option>';
					
?>
				</select>
			</label>
		</p>
		
		<p>
			<label>Display:
				<select name="<?php echo $this->get_field_name( 'display' ); ?>">
<?php
					echo '<option value="text"';
					if ( 'text' == $instance['display'] )
						echo ' selected';
					echo '>Icon and text</option>';
					echo '<option value="icon"';
					if ( 'icon' == $instance['display'] )
						echo ' selected';
					echo '>Icon only</option>';
					
?>
				</select>
			</label>
		</p>

<?php
			
		if ( isset( $instance['links'] ) ) {
			$links = $instance['links'];
		} else {
			$links = array(
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>''),
				array('platform'=>'','url'=>'')
			);
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
				<p>
					<label>Platform:
						<select name="<?php echo $this->get_field_name( 'links' ); ?>[<?php echo $key; ?>][platform]">
							<option></option>
<?php
	
			foreach ($selectable_platforms as $selection) {
				// option value is both array elements concatenated with '__'
				// so that both can be extrated for the displayed ul/li
				$optionValue = $selection[1] . '__' . $selection[0];
				echo '<option value="' . $optionValue . '"';
				if ( $optionValue == $value[platform] )
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
			</div>
		</p>

<?php
							
		}
	}

	/**
	 * Update the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = esc_html( $new_instance['title'] );
		
		if ( isset ( $new_instance['arrangement'] ) )
			$instance['arrangement'] = $new_instance['arrangement'];

		if ( isset ( $new_instance['display'] ) )
			$instance['display'] = $new_instance['display'];

		if ( isset ( $new_instance['links'] ) ) {
			$instance['links'] = $new_instance['links'];
		} else {
			$instance['links'] = array();
		}

		return $instance;
	}

}
?>