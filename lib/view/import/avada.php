<?php
/**
 * Copyright (C) 2014-2025 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Attribution: This code is part of the All-in-One WP Migration plugin, developed by
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

if ( $should_reset_permalinks ) {
	echo wp_kses( __( '» Permalinks are set to default.<br />', 'open-migrate' ), openmigrate_allowed_html_tags() );
} else {
	echo wp_kses(
		/* translators: Url */
		sprintf( __( '» <a class="openmigrate-no-underline" href="%s" target="_blank">Save permalinks structure</a>.<br />', 'open-migrate' ), admin_url( 'options-permalink.php#submit' ) ),
		openmigrate_allowed_html_tags()
	);
}

if ( openmigrate_validate_plugin_basename( 'oxygen/functions.php' ) ) {
	echo wp_kses( __( '» <a class="openmigrate-no-underline" href="https://classic.oxygenbuilder.com/documentation/other/importing-exporting/#resigning" target="_blank">Re-sign Oxygen Builder shortcodes</a>.<br />', 'open-migrate' ), openmigrate_allowed_html_tags() );
}

echo wp_kses( __( '» <a class="openmigrate-no-underline" href="https://theme-fusion.com/documentation/avada/installation-maintenance/important-update-information/#clear-caches" target="_blank">Reset Avada Fusion Builder cache</a>.<br />', 'open-migrate' ), openmigrate_allowed_html_tags() );
