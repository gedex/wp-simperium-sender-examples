<?php

class Simperium_Sender_Post_Published extends Simperium_Sender {

	protected function get_actions() {
		return array(
			'transition_post_status' => array(
				'handler' => array( $this, 'handle' ),
			),
		);
	}

	public function handle( $new_status, $old_status, $post ) {
		if ( 'publish' !== $old_status && 'publish' === $new_status ) {
			do_action( 'simperium_send_data', 'posts', $post->to_array() );
		}
	}
}
