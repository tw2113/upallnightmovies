<?php
/**
 * @package TSF_Extension_Manager\Extension\Local
 */

namespace TSF_Extension_Manager\Extension\Local;

\defined( 'TSF_EXTENSION_MANAGER_PRESENT' ) or die;

if ( \tsfem()->_blocked_extension_file( $_instance, $bits[1] ) ) return;

/**
 * Local extension for The SEO Framework
 * Copyright (C) 2017 - 2024 Sybre Waaijer, CyberWire B.V. (https://cyberwire.nl/)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 3 as published
 * by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Require extension options trait.
 *
 * @since 1.0.0
 */
\TSF_Extension_Manager\_load_trait( 'extension/options' );

/**
 * Class TSF_Extension_Manager\Extension\Local\Core
 *
 * Holds extension core methods.
 *
 * @since 1.0.0
 * @access private
 * @uses TSF_Extension_Manager\Traits
 */
class Core {
	use \TSF_Extension_Manager\Construct_Core_Interface,
		\TSF_Extension_Manager\Extension_Options;

	/**
	 * Child constructor.
	 *
	 * @since 1.0.0
	 */
	private function construct() {

		$that = __NAMESPACE__ . ( \is_admin() ? '\\Admin' : '\\Front' );
		$this instanceof $that or \wp_die( -1 );

		/**
		 * Set options index.
		 *
		 * @see trait TSF_Extension_Manager\Extension_Options
		 */
		$this->o_index = 'local';
	}
}
