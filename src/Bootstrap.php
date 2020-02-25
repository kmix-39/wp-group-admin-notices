<?php
/**
 * @package wp-group-admin-notices
 * @author kmix-39
 * @license GPL-2.0+
 */
namespace Kmix39\WP_Group_Admin_Notices;

class Bootstrap {

	private $_groups;
	private $_display_options;

	private function __construct() {}

	public static function instance() {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new Bootstrap();
			$instance->_groups = [];
			$instance->_display_options = [];
		}
		return $instance;
	}

	public function add_notice( $slug, $code, $message ) {
		$this->init_group( $slug );
		$this->_groups[$slug]->add( $code, $message );
	}

	public function remove_notice( $slug, $code ) {
		$this->init_group( $slug );
		$this->_groups[$slug]->remove( $code );
	}

	public function display_notices( $slug, $class = '' ) {
		if ( empty( $this->_display_options ) ) {
			add_action( 'admin_notices', [ $this, '_admin_notices' ] );
			add_action( 'network_admin_notices', [ $this, '_admin_notices' ] );
		}
		$this->_display_options[$slug] = $class;
	}

	public function notices_count( $slug = null ) {
		if ( null === $slug ) {
			return count( $this->_groups );
		}
		if ( ! isset( $this->_groups[$slug] ) ) {
			return count( $this->_groups[$slug] );
		}
		return 0;
	}

	public function _admin_notices() {
		if ( empty( $this->_display_options ) ) {
			return;
		}
		foreach ( $this->_display_options as $slug => $class ) {
			$this->init_group( $slug );
			$group = $this->_groups[$slug];
			$codes = $group->get_codes();
			if ( ! empty( $codes ) ) {
				echo '<div class="notice ' . esc_attr( $class ) . ' is-dismissible">';
				foreach ( $codes as $code ) {
					$messages = $group->get_messages( $code );
					if ( empty( $messages ) ) {
						continue;
					}
					echo '<ul>';
					foreach ( $messages as $message ) {
						if ( '' === esc_html( $message ) ) {
							continue;
						}
						echo '<li>' . esc_html( $message ) . '</li>';
					}
					echo '</ul>';
				}
				echo '</div>';
			}
		}
	}

	private function init_group( $slug ) {
		if ( ! array_key_exists( $slug, $this->_groups ) ) {
			$this->_groups[$slug] = new Group;
		}
	}

}
