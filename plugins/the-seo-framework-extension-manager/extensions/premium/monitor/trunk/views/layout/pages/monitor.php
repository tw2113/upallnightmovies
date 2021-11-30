<?php
/**
 * @package TSF_Extension_Manager\Extension\Monitor\Admin\Views
 */

// phpcs:disable, VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable -- includes.
// phpcs:disable, WordPress.WP.GlobalVariablesOverride -- This isn't the global scope.

defined( 'TSF_EXTENSION_MANAGER_PRESENT' ) and $_class = TSF_Extension_Manager\Extension\Monitor\get_active_class() and $this instanceof $_class or die;

tsf_extension_manager()->_do_pane_wrap(
	__( 'Common Issues', 'the-seo-framework-extension-manager' ),
	$this->get_issues_overview(),
	[
		'full'     => false,
		'collapse' => true,
		'wide'     => true,
		'move'     => false,
		'push'     => true,
		'pane_id'  => 'tsfem-e-monitor-issues-pane',
		'ajax'     => true,
		'ajax_id'  => 'tsfem-e-monitor-issues-ajax',
	]
);
tsf_extension_manager()->_do_pane_wrap(
	__( 'Control Panel', 'the-seo-framework-extension-manager' ),
	$this->get_cp_overview(),
	[
		'full'     => false,
		'collapse' => true,
		'move'     => false,
		'pane_id'  => 'tsfem-e-monitor-cp-pane',
		'ajax'     => true,
		'ajax_id'  => 'tsfem-e-monitor-cp-ajax',
	]
);
