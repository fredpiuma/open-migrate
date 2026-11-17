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

<div class="openmigrate-import-messages"></div>

<div class="openmigrate-import-form">
	<div class="hide-if-no-js">
		<div class="openmigrate-drag-drop-area" id="openmigrate-drag-drop-area">
			<div id="openmigrate-import-init">
				<p>
					<i class="openmigrate-icon-cloud-upload"></i><br />
					<?php esc_html_e( 'Drag & Drop a backup to import it', 'open-migrate' ); ?>
				</p>
				<div class="openmigrate-button-group openmigrate-button-import openmigrate-expandable">
					<div class="openmigrate-button-main">
						<span role="list" aria-label="<?php esc_attr_e( 'Import From', 'open-migrate' ); ?>"><?php esc_html_e( 'Import From', 'open-migrate' ); ?></span>
						<span class="ai1mw-lines">
							<span class="openmigrate-line openmigrate-line-first"></span>
							<span class="openmigrate-line openmigrate-line-second"></span>
							<span class="openmigrate-line openmigrate-line-third"></span>
						</span>
					</div>
					<ul class="openmigrate-dropdown-menu openmigrate-import-providers">
						<?php foreach ( apply_filters( 'openmigrate_import_buttons', array() ) as $button ) : ?>
							<li>
								<?php echo wp_kses( $button, openmigrate_allowed_html_tags() ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
