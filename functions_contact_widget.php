<?php

/**
 * Contact Info widget
 * Displays contact info (address, phone, etc)
 * and associated action buttons (call, email)
 *
 * @version 20150210
 */
 
add_action( 'widgets_init', 'uci_register_contact_widget' );
function uci_register_contact_widget() {
	register_widget( 'UCI_Contact_Widget' );
}

 
class UCI_Contact_Widget extends WP_Widget {

	/*
	 * Widget setup.
	 */
	function UCI_Contact_Widget() {
		//* Widget settings.
		$widget_ops = array( 'classname' => 'contact', 'description' => __('Displays contact info and associated action buttons.', 'contact') );

		//* Widget control settings.
		$control_ops = array( 'id_base' => 'contact-info-widget' );

		//* Create the widget.
		$this->WP_Widget( 'contact-info-widget', __('UCI - Contact Info', 'contact'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		//* Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$address1 = $instance['address1'];
		$address2 = $instance['address2'];
		$address3 = $instance['address3'];
		$email = $instance['email'];
		$phone = $instance['phone'];
		$buttons = $instance['buttons'];

		//* Before widget (defined by themes).
		echo $before_widget;

		//* Display the widget title if one was input (before and after defined by themes).
		if ( $title )
			echo $before_title . $title . $after_title;
		
		echo '<address class="uci-contact">';
		
		$linebreak = false;
		
		if ( $name ) {
			echo $name;
			$linebreak = true;
		}
		if ( $address1 ) {
			if ($linebreak)
				echo '<br/>';
			echo $address1;
			$linebreak = true;
		}
		if ( $address2 ) {
			if ($linebreak)
				echo '<br/>';
			echo $address2;
			$linebreak = true;
		}
		if ( $address3 ) {
			if ($linebreak)
				echo '<br/>';
			echo $address3;
			$linebreak = true;
		}
		if ( $email ) {
			if ($linebreak)
				echo '<br/>';
			echo '<a href="mailto:' . $email . '">' . $email . '</a>';
			$linebreak = true;
		}
		if ( $phone ) {
			if ($linebreak)
				echo '<br/>';
			echo '<a href="tel:' . $phone . '">' . $phone . '</a>';
			$linebreak = true;
		}

		echo '</address>';
		
		if ( $buttons == 'show' ) {
			echo '<div class="uci-contact-actions clearfix">';
			if ( $email ) {
				echo '<a class="uci-contact-email" href="mailto:' . $email . '"><i class="fa fa-envelope"></i><span class="screen-reader-text">Email ' . $name . '</span></a>';
			}
			if ( $phone ) {
				echo '<a class="uci-contact-phone" href="tel:' . $phone . '"><i class="fa fa-phone"></i><span class="screen-reader-text">Call ' . $name . '</span></a>';
			}
			echo '</div>';
		}

		//* After widget (defined by themes).
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['address1'] = strip_tags( $new_instance['address1'] );
		$instance['address2'] = strip_tags( $new_instance['address2'] );
		$instance['address3'] = strip_tags( $new_instance['address3'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['buttons'] = $new_instance['buttons'];

		if ( $instance['name'] && $instance['name'] != '' ) {
			return $instance;
		} else {
			return false;
		}
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		//* Set up some default widget settings.
		$defaults = array( 
			'title' => __('', 'contact'),
			'name' => __('', 'contact'),
			'address1' => __('', 'contact'),
			'address2' => __('', 'contact'),
			'address3' => __('', 'contact'),
			'email' => __('', 'contact'),
			'phone' => __('', 'contact'),
			'buttons' => __('', 'contact')
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Unit Name:', 'contact'); ?> </label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" placeholder="REQUIRED" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'address1' ); ?>"><?php _e('Address 1:', 'contact'); ?></label>
			<input id="<?php echo $this->get_field_id( 'address1' ); ?>" name="<?php echo $this->get_field_name( 'address1' ); ?>" value="<?php echo $instance['address1']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'address2' ); ?>"><?php _e('Address 2:', 'contact'); ?></label>
			<input id="<?php echo $this->get_field_id( 'address2' ); ?>" name="<?php echo $this->get_field_name( 'address2' ); ?>" value="<?php echo $instance['address2']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'address3' ); ?>"><?php _e('Address 3:', 'contact'); ?></label>
			<input id="<?php echo $this->get_field_id( 'address3' ); ?>" name="<?php echo $this->get_field_name( 'address3' ); ?>" value="<?php echo $instance['address3']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'contact'); ?></label>
			<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone:', 'contact'); ?></label>
			<input id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" style="width:100%;" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'buttons' ); ?>" name="<?php echo $this->get_field_name( 'buttons' ); ?>" type="checkbox" value="show" <?php if ( $instance['buttons']) echo 'checked'; ?> />
			<label for="<?php echo $this->get_field_id( 'buttons' ); ?>"><?php _e('Show Action Buttons', 'contact'); ?></label>
		</p>

	<?php
	}
}

?>