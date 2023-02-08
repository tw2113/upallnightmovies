<?php
/**
 * @package TSF_Extension_Manager\Classes
 */

namespace TSF_Extension_Manager;

\defined( 'TSF_EXTENSION_MANAGER_PRESENT' ) or die;

/**
 * The SEO Framework - Extension Manager plugin
 * Copyright (C) 2016-2023 Sybre Waaijer, CyberWire (https://cyberwire.nl/)
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
 * Class TSF_Extension_Manager\Panes
 *
 * Holds plugin extensions overview functions.
 *
 * @since 1.0.0
 * @access private
 */
class Panes extends API {
	use Construct_Child_Interface;

	/**
	 * Constructor, initializes WordPress Admin actions.
	 *
	 * @since 1.0.0
	 */
	private function construct() {

		// Ajax listener for updating feed option.
		\add_action( 'wp_ajax_tsfem_enable_feeds', [ $this, '_wp_ajax_enable_feeds' ] );

		// Ajax listener for updating extension setting.
		\add_action( 'wp_ajax_tsfem_update_extension', [ $this, '_wp_ajax_tsfem_update_extension' ] );

		// Ajax listener for after updating the extension setting.
		\add_action( 'wp_ajax_tsfem_update_extension_desc_footer', [ $this, '_wp_ajax_tsfem_update_extension_desc_footer' ] );
	}

	/**
	 * Returns the SEO trends and updates overview.
	 *
	 * @since 1.0.0
	 *
	 * @return string The escaped SEO Trends and Updates overview.
	 */
	protected function get_seo_trends_and_updates_overview() {

		if ( $this->get_option( '_enable_feed' ) ) {
			$output = $this->get_trends_output();
		} else {
			$output = $this->get_trends_activation_output();
		}

		return sprintf( '<div class="tsfem-pane-inner-wrap tsfem-trends-wrap">%s</div>', $output );
	}

	/**
	 * Returns TSF Extension Manager account actions overview.
	 *
	 * @since 1.0.0
	 *
	 * @return string The escaped account actions overview.
	 */
	protected function get_extensions_actions_overview() {
		return sprintf(
			'<div class="tsfem-pane-inner-wrap tsfem-actions-wrap">%s</div>',
			vsprintf(
				'<div class="tsfem-actions tsfem-flex">%s%s%s%s%s</div>',
				[
					$this->get_account_information(),
					$this->get_transfer_domain_form(),
					$this->get_account_upgrade_form(),
					$this->get_support_buttons(),
					$this->get_disconnect_button(),
				]
			)
		);
	}

	/**
	 * Returns the extension overview.
	 *
	 * @since 1.0.0
	 *
	 * @return string The extensions overview.
	 */
	protected function get_extension_overview() {

		$this->get_verification_codes( $_instance, $bits );

		Extensions::initialize( 'overview', $_instance, $bits );

		Extensions::set_nonces( 'nonce_name', $this->nonce_name );
		Extensions::set_nonces( 'request_name', $this->request_name );
		Extensions::set_nonces( 'nonce_action', $this->nonce_action );

		Extensions::set_account( $this->get_subscription_status() );

		$content = Extensions::get( 'layout_content' );
		$content = sprintf( '<div class=tsfem-extensions-overview-content>%s</div>', $content );

		Extensions::reset();

		return sprintf( '<div class="tsfem-pane-inner-wrap tsfem-extensions-wrap">%s</div>', $content );
	}

	/**
	 * Returns wrapped Google Feed with status notices.
	 *
	 * @since 1.0.0
	 *
	 * @return string The wrapped Google Webmasters feed output.
	 */
	protected function get_trends_output() {

		$feed = $this->get_trends_feed();

		if ( -1 === $feed ) {
			$output = sprintf(
				'<h4 class=tsfem-status-title>%s</h4>',
				\esc_html__( "Unfortunately, your server can't process this request as of yet.", 'the-seo-framework-extension-manager' )
			);
		} elseif ( ! $feed ) {
			$output = sprintf(
				'<h4 class=tsfem-status-title>%s</h4>',
				\esc_html__( 'There are no trends and updates to report yet.', 'the-seo-framework-extension-manager' )
			);
		} else {
			$output = sprintf( '<div class="tsfem-feed-wrap tsfem-flex tsfem-flex-row">%s</div>', $feed );
		}

		return sprintf( '<div class="tsfem-trends tsfem-ltr tsfem-flex tsfem-flex-row">%s</div>', $output );
	}

	/**
	 * Returns wrapped Google Feed with status notices.
	 *
	 * @since 1.0.0
	 *
	 * @return array {
	 *    'data' => array The feed items.
	 *    'wrap' => string The feed items wrap.
	 *    'error_output' => string If feed has an error, this is sent too.
	 * }
	 */
	protected function ajax_get_trends_output() {

		$data = $this->get_trends_feed( true );

		if ( -1 === $data ) {
			$output = sprintf(
				'<h4 class=tsfem-status-title>%s</h4>',
				\esc_html__( "Unfortunately, your server can't process this request as of yet.", 'the-seo-framework-extension-manager' )
			);

			$send = [
				'status'       => 'parse_error',
				'error_output' => sprintf( '<div class="tsfem-trends tsfem-ltr tsfem-flex tsfem-flex-row">%s</div>', $output ),
			];
		} elseif ( ! $data ) {
			$output = sprintf(
				'<h4 class=tsfem-status-title>%s</h4>',
				\esc_html__( 'There are no trends and updates to report yet.', 'the-seo-framework-extension-manager' )
			);

			$send = [
				'status'       => 'unknown_error',
				'error_output' => sprintf( '<div class="tsfem-trends tsfem-ltr tsfem-flex tsfem-flex-row">%s</div>', $output ),
			];
		} else {
			$send = [
				'status' => 'success',
				'wrap'   => '<div class="tsfem-trends tsfem-ltr tsfem-flex tsfem-flex-row"><div class="tsfem-feed-wrap tsfem-flex tsfem-flex-row"></div></div>',
			];
		}

		return [ 'data' => $data ] + $send;
	}

	/**
	 * Returns Google Webmaster's blog Feed.
	 *
	 * @since 1.0.0
	 * @uses TSF_Extension_Manager\Trends::get()
	 * @todo Consider loading via AJAX if transient has expired (set transient ->
	 * auto-load through ajax (calculate difference with local UNIX time -> might error?) & delete transient -> if failed run anyway).
	 *
	 * @param bool $ajax Whether the trends are fetched through AJAX.
	 * @return string The sanitized Google Webmasters feed output.
	 */
	protected function get_trends_feed( $ajax = false ) {

		$this->get_verification_codes( $_instance, $bits );

		if ( $ajax )
			return \TSF_Extension_Manager\Trends::get( 'ajax_feed', $_instance, $bits );

		return \TSF_Extension_Manager\Trends::get( 'feed', $_instance, $bits );
	}

	/**
	 * Returns trends activation introduction.
	 *
	 * @since 1.0.0
	 * @todo convert to secure Trends instance? Trends isn't "super-secure" (no bit verification).
	 *       Do so when converting to own blog entries (auto-enabled?). Relucatance towards backwards compat.
	 *
	 * @return string Trends activation buttons.
	 */
	protected function get_trends_activation_output() {

		$output = '';

		$googleblog = $this->get_link( [
			'url'     => 'https://webmasters.googleblog.com/',
			'content' => 'Google Webmaster Central Blog',
			'target'  => '_blank',
		] );
		/* translators: %s = "Google Webmaster Central Blog" */
		$acquiredfrom  = sprintf( \esc_html__( 'The feed is acquired from %s.', 'the-seo-framework-extension-manager' ), $googleblog );
		$googleprivacy = $this->get_link( [
			'url'     => 'https://www.google.com/policies/privacy/',
			'content' => \__( "Google's Privacy Policy", 'the-seo-framework-extension-manager' ),
			'target'  => '_blank',
		] );
		/* translators: %s = "Google's Privacy Policy" */
		$privacystatement = sprintf( \esc_html__( 'Read %s.', 'the-seo-framework-extension-manager' ), $googleprivacy );

		// The feed is totally optional until it pulls from The SEO Framework premium. I.e. privacy.
		$title = sprintf(
			'<h4 class=tsfem-status-title>%s</h4>',
			\esc_html__( 'The feed has been disabled to protect your privacy.', 'the-seo-framework-extension-manager' )
		);

		$output .= '<p>' . \esc_html__( 'You may choose to enable the feed. Once enabled, it can not be disabled.', 'the-seo-framework-extension-manager' ) . '</p>';
		$output .= "<p>$acquiredfrom $privacystatement</p>";
		$output .= $this->get_feed_enabler_button();

		return sprintf( '<div class=tsfem-trends-activation>%s</div>', $title . $output );
	}

	/**
	 * Returns a button that implements an AJAX request for Feed enabling.
	 *
	 * @since 1.0.0
	 * @todo @see $this->get_trends_activation_output().
	 *
	 * @return string The feed enabled button.
	 */
	protected function get_feed_enabler_button() {

		$enable = \__( 'Enable feed?', 'the-seo-framework-extension-manager' );

		$nonce_action = $this->_get_nonce_action_field( $this->request_name['enable-feed'] );
		$nonce        = \wp_nonce_field( $this->nonce_action['enable-feed'], $this->nonce_name, true, false );
		$submit       = sprintf(
			'<input type=submit name=submit id=tsfem-submit-enable-feed class=tsfem-button-primary value="%s">',
			\esc_attr( $enable )
		);

		$form = "{$nonce_action}{$nonce}{$submit}";

		$nojs = sprintf(
			'<form action="%s" method=post id=tsfem-enable-feeds-form class=hide-if-tsf-js autocomplete=off data-form-type=other>%s</form>',
			\esc_url( $this->get_admin_page_url() ),
			$form
		);
		$js   = '<p class=hide-if-no-tsf-js><a id=tsfem-enable-feeds href=javascript:; class=tsfem-button-primary>' . \esc_html( $enable ) . '</a></p>';

		return sprintf( '<div class="tsfem-flex tsfem-flex-no-wrap tsfem-enable-feed-button">%s</div>', "{$js}{$nojs}" );
	}

	/**
	 * Enables feed through AJAX and echos the feed output through AJAX response.
	 *
	 * @since 1.0.0
	 * @since 2.0.0 Now uses \TSF_Extension_Manager\can_do_manager_settings()
	 * @TODO update to newer ajax handler.
	 * @access private
	 */
	public function _wp_ajax_enable_feeds() {

		if ( \wp_doing_ajax() ) :
			if ( \TSF_Extension_Manager\can_do_manager_settings() ) :

				\check_ajax_referer( 'tsfem-ajax-nonce', 'nonce' );

				$data = [];
				$type = 'unknown';

				if ( $this->get_option( '_enable_feed' ) ) {
					// Another admin has initialized this after the last page load.
					$type = 'success';
					$data = [
						'content' => $this->ajax_get_trends_output(),
						'type'    => $type,
					];
				} else {
					$type = $this->update_option( '_enable_feed', true ) ? 'success' : 'error';
					$data = [
						'content' => 'success' === $type ? $this->ajax_get_trends_output() : '',
						'type'    => $type,
					];
				}

				$this->send_json( $data, $type );
			endif;
		endif;

		exit;
	}

	/**
	 * Updates extension through AJAX and returns AJAX response.
	 *
	 * @since 1.0.0
	 * @since 1.5.0 Now uses the updated AJAX handler.
	 * @since 2.0.0 Now uses \TSF_Extension_Manager\can_do_manager_settings()
	 * @access private
	 */
	public function _wp_ajax_tsfem_update_extension() {

		if ( \wp_doing_ajax() ) :
			if ( \TSF_Extension_Manager\can_do_manager_settings() ) :

				$case = '';
				$slug = '';

				if ( \check_ajax_referer( 'tsfem-ajax-nonce', 'nonce', false ) ) {
					// As data is passed to UNIX/IIS for file existence, strip as much as possible.
					$slug = isset( $_POST['slug'] ) ? $this->s_ajax_string( $_POST['slug'] ) : ''; // Input var, sanitization OK.
					$case = isset( $_POST['case'] ) ? $this->s_ajax_string( $_POST['case'] ) : ''; // Input var, sanitization OK.
				}

				if ( $case && $slug ) {
					$options = [
						'extension' => $slug,
					];

					if ( 'activate' === $case ) {
						$results = $this->activate_extension( $options, true );
						$type    = 'success';
					} elseif ( 'deactivate' === $case ) {
						$results = $this->deactivate_extension( $options, true );
						$type    = 'success';
					} else {
						$results = $this->get_ajax_notice( false, 10101 );
					}
				} else {
					$results = $this->get_ajax_notice( false, 10102 );
				}

				$data = compact( 'slug', 'case' );

				$this->send_json( compact( 'results', 'data' ), $type ?? 'failure' );
			endif;
		endif;

		exit;
	}

	/**
	 * Returns updated footer fields for the activated extension.
	 *
	 * Generates a rogue menu entry item.
	 *
	 * @since 1.0.0
	 * @since 2.0.0 Now uses \TSF_Extension_Manager\can_do_manager_settings()
	 * @access private
	 */
	final public function _wp_ajax_tsfem_update_extension_desc_footer() {

		if ( \wp_doing_ajax() ) :
			if ( \TSF_Extension_Manager\can_do_manager_settings() ) :

				$slug = '';
				$case = '';

				if ( \check_ajax_referer( 'tsfem-ajax-nonce', 'nonce', false ) ) {
					// As data is passed to UNIX/IIS for file existence, strip as much as possible.
					$slug = isset( $_POST['slug'] ) ? $this->s_ajax_string( $_POST['slug'] ) : ''; // Input var, sanitization OK.
					$case = isset( $_POST['case'] ) ? $this->s_ajax_string( $_POST['case'] ) : ''; // Input var, sanitization OK.
				}

				if ( $slug && $case ) :
					// Tell the plugin we're on the correct page.
					$this->ajax_is_tsf_extension_manager_page( true );

					$this->get_verification_codes( $_instance, $bits );

					Extensions::initialize( 'ajax_layout', $_instance, $bits );

					if ( 'activate' === $case ) :
						// Check for menu slug in order to add it.
						$header = Extensions::get( 'ajax_get_extension_header', $slug );

						if ( ! empty( $header['MenuSlug'] ) )
							$this->_set_ajax_menu_link( $header['MenuSlug'], TSF_EXTENSION_MANAGER_EXTENSION_ADMIN_ROLE );
					endif;

					$html = Extensions::get( 'ajax_get_extension_desc_footer', $slug );

					Extensions::reset();
				endif;

				if ( isset( $html ) ) {
					$data = $html;
					$type = 'success';
				} else {
					$data = '';
					$type = 'error';
				}

				$this->send_json( $data, $type );
			endif;
		endif;

		exit;
	}

	/**
	 * Wraps and returns the account information.
	 *
	 * @since 1.0.0
	 *
	 * @return string The account information wrap.
	 */
	protected function get_account_information() {

		$infos = [];

		if ( $this->is_connected_user() )
			$infos[] = \esc_html__( 'This information is updated every few minutes, infrequently.', 'the-seo-framework-extension-manager' );

		$title = sprintf(
			'<h4 class=tsfem-info-title>%s %s</h4>',
			\esc_html__( 'Account information', 'the-seo-framework-extension-manager' ),
			( $infos
				? HTML::make_inline_question_tooltip( implode( ' ', $infos ), implode( '<br>', $infos ) )
				: ''
			)
		);

		$this->get_verification_codes( $_instance, $bits );

		Layout::initialize( 'list', $_instance, $bits );

		Layout::set_nonces( 'nonce_name', $this->nonce_name );
		Layout::set_nonces( 'request_name', $this->request_name );
		Layout::set_nonces( 'nonce_action', $this->nonce_action );

		$options_instance = $this->get_options_instance_key();
		$options_valid    = $this->are_options_valid();
		$options_hash     = substr( \get_option( "tsfem_i_$options_instance" ), -4 );

		Layout::set_account( $this->get_subscription_status() );
		Layout::set_misc( [
			'options' => [
				'valid'    => $options_valid,
				'instance' => substr( $options_instance, -4 ),
				'hash'     => [
					'expected' => $options_hash,
					'actual'   => $options_valid
						? $options_hash
						: substr( $this->hash_options( \get_option( TSF_EXTENSION_MANAGER_SITE_OPTIONS, [] ) ), -4 ),
				],
			],
		] );

		$output = Layout::get( 'account-information' );

		Layout::reset();

		return sprintf( '<div class="tsfem-account-info tsfem-pane-section">%s%s</div>', $title, $output );
	}

	/**
	 * @TODO make this happen.
	 */
	// phpcs:ignore
	// protected function get_account_extend_form() { }

	/**
	 * Wraps and returns the account upgrade form.
	 *
	 * @since 1.0.0
	 *
	 * @return string The account upgrade form wrap.
	 */
	protected function get_account_upgrade_form() {

		if ( $this->is_auto_activated() ) return '';
		if ( $this->is_connected_user() || ! $this->are_options_valid() ) return '';

		$this->get_verification_codes( $_instance, $bits );

		Layout::initialize( 'form', $_instance, $bits );

		Layout::set_account( $this->get_subscription_status() );

		Layout::set_nonces( 'nonce_name', $this->nonce_name );
		Layout::set_nonces( 'request_name', $this->request_name );
		Layout::set_nonces( 'nonce_action', $this->nonce_action );

		$form = Layout::get( 'account-upgrade' );

		Layout::reset();

		$title = sprintf( '<h4 class=tsfem-form-title>%s</h4>', \esc_html__( 'Upgrade your account', 'the-seo-framework-extension-manager' ) );

		return sprintf( '<div class="tsfem-cp-buttons tsfem-cp-buttons tsfem-pane-section">%s%s</div>', $title, $form );
	}

	/**
	 * Wraps and returns the domain transfer form.
	 *
	 * @since 2.6.1
	 *
	 * @return string The account upgrade form wrap.
	 */
	protected function get_transfer_domain_form() {

		if ( ! $this->get_option( '_requires_domain_transfer' )
		  || ! $this->is_connected_user()
		  || ! $this->are_options_valid()
		) return '';

		$title = sprintf(
			'<h4 class=tsfem-form-title>%s</h4>',
			\esc_html__( 'Transfer domain', 'the-seo-framework-extension-manager' )
		);

		$this->get_verification_codes( $_instance, $bits );
		Layout::initialize( 'form', $_instance, $bits );
		Layout::set_account( $this->get_subscription_status() );
		Layout::set_nonces( 'nonce_name', $this->nonce_name );
		Layout::set_nonces( 'request_name', $this->request_name );
		Layout::set_nonces( 'nonce_action', $this->nonce_action );
		$form = Layout::get( 'transfer-domain-button' );
		Layout::reset();

		return sprintf(
			'<div class="tsfem-domain-transfer tsfem-pane-section tsfem-cp-buttons">%s%s</div>',
			$title,
			$form
		);
	}

	/**
	 * Renders and returns disconnect button.
	 *
	 * @since 1.5.0
	 *
	 * @return string The disconnect button.
	 */
	protected function get_disconnect_button() {

		if ( $this->is_auto_activated() ) return '';

		$infos = [];

		if ( $this->is_connected_user() ) {
			$infos[] = \esc_html__( 'This will free up your site limit.', 'the-seo-framework-extension-manager' );
		} else {
			$infos[] = \esc_html__( 'This will deactivate all extensions.', 'the-seo-framework-extension-manager' );
		}
		$infos[] = \esc_html__( 'No options from extensions will be lost.', 'the-seo-framework-extension-manager' );

		$title = sprintf(
			'<h4 class=tsfem-info-title>%s %s</h4>',
			\esc_html__( 'Disconnect account', 'the-seo-framework-extension-manager' ),
			HTML::make_inline_question_tooltip( implode( ' ', $infos ), implode( '<br>', $infos ) )
		);

		$this->get_verification_codes( $_instance, $bits );
		Layout::initialize( 'form', $_instance, $bits );
		Layout::set_nonces( 'nonce_name', $this->nonce_name );
		Layout::set_nonces( 'request_name', $this->request_name );
		Layout::set_nonces( 'nonce_action', $this->nonce_action );
		$button = Layout::get( 'disconnect-button' );
		Layout::reset();

		return sprintf(
			'<div class="tsfem-account-disconnect tsfem-pane-section">%s%s</div>',
			$title,
			$button
		);
	}

	/**
	 * Renders and returns support buttons.
	 *
	 * @since 1.0.0
	 *
	 * @return string The support buttons.
	 */
	protected function get_support_buttons() {

		$this->get_verification_codes( $_instance, $bits );

		$title = sprintf( '<h4 class=tsfem-support-title>%s</h4>', \esc_html__( 'Get support', 'the-seo-framework-extension-manager' ) );

		Layout::initialize( 'link', $_instance, $bits );

		$buttons     = [];
		$description = [];

		$buttons[1]     = Layout::get( 'public-support-button' );
		$description[1] = \__( 'Inquire your question publicly so more people will benefit from our support.', 'the-seo-framework-extension-manager' );

		$buttons[2]     = Layout::get( 'private-support-button' );
		$description[2] = \__( 'Questions about your account should be inquired via Private Support.', 'the-seo-framework-extension-manager' );

		Layout::reset();

		$content = '';
		foreach ( $buttons as $key => $button ) {
			$content .= sprintf(
				'<div class=tsfem-cp-buttons>%s %s</div>',
				$button,
				HTML::make_inline_question_tooltip( $description[ $key ] )
			);
		}

		return sprintf(
			'<div class="tsfem-account-support tsfem-pane-section">%s%s</div>',
			$title,
			$content
		);
	}
}
