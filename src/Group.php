<?php
/**
 * @package wp-group-admin-notices
 * @author kmix-39
 * @license GPL-2.0+
 */
namespace Kmix39\WP_Group_Admin_Notices;

use WP_Error;

final class Group {

	private $_options = null;

	public function get_codes() {
		if ( null === $this->_options ) {
			return [];
		}
		return $this->_options->get_error_codes();
	}

	public function get_messages( $code ) {
		if ( null === $this->_options ) {
			return [];
		}
		return $this->_options->get_error_messages( $code );
	}

	public function add( $code, $message ) {
		if ( null === $this->_options ) {
			$this->init_options();
		}
		$this->_options->add( $code, $message, '' );
	}

	public function remove( $code ) {
		if ( null === $this->_options ) {
			return;
		}
		$this->_options->remove( $code );
	}

	private function init_options() {
		$this->_options = new WP_Error();
	}

}
