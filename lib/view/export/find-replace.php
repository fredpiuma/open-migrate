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
?>

<ul id="openmigrate-queries">
	<li class="openmigrate-query openmigrate-expandable">
		<p>
			<span>
				<strong><?php esc_html_e( 'Search for', 'open-migrate' ); ?></strong>
				<small class="openmigrate-query-find-text openmigrate-tooltip" title="<?php esc_attr_e( 'Search the database for this text', 'open-migrate' ); ?>"> <?php echo esc_html( __( '<text>', 'open-migrate' ) ); ?> </small>
				<strong><?php esc_html_e( 'Replace with', 'open-migrate' ); ?></strong>
				<small class="openmigrate-query-replace-text openmigrate-tooltip" title="<?php esc_attr_e( 'Replace the database with this text', 'open-migrate' ); ?>"> <?php echo esc_html( __( '<another-text>', 'open-migrate' ) ); ?> </small>
				<strong><?php esc_html_e( 'in the database', 'open-migrate' ); ?></strong>
			</span>
			<span class="openmigrate-query-arrow openmigrate-icon-chevron-right"></span>
		</p>
		<div>
			<input class="openmigrate-query-find-input" type="text" placeholder="<?php esc_attr_e( 'Search for', 'open-migrate' ); ?>" name="options[replace][old_value][]" />
			<input class="openmigrate-query-replace-input" type="text" placeholder="<?php esc_attr_e( 'Replace with', 'open-migrate' ); ?>" name="options[replace][new_value][]" />
		</div>
	</li>
</ul>

<button type="button" class="openmigrate-button-gray" id="openmigrate-add-new-replace-button">
	<i class="openmigrate-icon-plus2"></i>
	<?php esc_html_e( 'Add', 'open-migrate' ); ?>
</button>
