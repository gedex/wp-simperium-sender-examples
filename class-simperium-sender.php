<?php

abstract class Simperium_Sender {

	protected $plugin_path;

	public function __construct( $plugin_path ) {
		$this->plugin_path = $plugin_path;
	}

	abstract protected function get_actions();

	public function listen_to_actions() {
		foreach ( $this->get_actions() as $action => $property ) {
			if ( ! is_array( $property ) ) {
				throw new Exception( 'Expecting array for action\'s value but got ' . gettype( $property ) );
			}

			if ( empty( $property ) ) {
				throw new Exception( 'Array of action\'s value can not be empty' );
			}

			if ( empty( $property['handler'] ) || ! is_callable( $property['handler'] ) ) {
				throw new Exception( 'Expecting key "handler" that is callable' );
			}

			$priority = 10;
			if ( ! empty( $property['priority'] ) ) {
				$priority = intval( $property['priority'] );
			}

			add_action( $action, $property['handler'], $priority, 5 );
		}
	}

}
