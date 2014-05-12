<?php

class Simperium_Sender_New_Comment extends Simperium_Sender {

	protected function get_actions() {
		return array(
			'wp_insert_comment' => array(
				'handler' => array( $this, 'handle' ),
			),
		);
	}

	public function handle( $comment_id, $comment ) {
		$comment = is_object( $comment ) ? $comment : get_comment( absint( $comment ) );
		do_action( 'simperium_send_data', 'commments', get_object_vars( $comment ) );
	}
}
