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

<div class="openmigrate-feedback">
	<ul class="openmigrate-feedback-types">
		<li>
			<input type="radio" class="openmigrate-flat-radio-button openmigrate-feedback-type" id="openmigrate-feedback-type-1" name="openmigrate_feedback_type" value="suggestions" />
			<a id="openmigrate-feedback-type-link-1" href="https://feedback.wp-migration.com" target="_blank">
				<i></i>
				<span>
					<?php esc_html_e( 'I have an idea', 'open-migrate' ); ?>
					<svg style="width: 14px; position: relative; top: 3px; left: 3px;" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
				</span>
			</a>
		</li>
		<li>
			<input type="radio" class="openmigrate-flat-radio-button openmigrate-feedback-type" id="openmigrate-feedback-type-2" name="openmigrate_feedback_type" value="help-needed" />
			<label for="openmigrate-feedback-type-2">
				<i></i>
				<span><?php esc_html_e( 'I need help', 'open-migrate' ); ?></span>
			</label>
		</li>
	</ul>

	<div class="openmigrate-feedback-form">
		<div class="openmigrate-field">
			<input placeholder="<?php esc_attr_e( 'Email address', 'open-migrate' ); ?>" type="text" id="openmigrate-feedback-email" class="openmigrate-feedback-email" />
		</div>
		<div class="openmigrate-field">
			<textarea rows="3" id="openmigrate-feedback-message" class="openmigrate-feedback-message" placeholder="<?php esc_attr_e( 'Describe your issue or feedback...', 'open-migrate' ); ?>"></textarea>
		</div>
		<div class="openmigrate-field openmigrate-feedback-terms-segment">
			<label for="openmigrate-feedback-terms">
				<input type="checkbox" class="openmigrate-feedback-terms" id="openmigrate-feedback-terms" />
				<?php echo wp_kses( __( 'I agree to let All-in-One WP Migration use my <strong>email</strong> to respond to my request.', 'open-migrate' ), openmigrate_allowed_html_tags() ); ?>
			</label>
		</div>
		<div class="openmigrate-field">
			<div class="openmigrate-buttons">
				<a class="openmigrate-feedback-cancel" id="openmigrate-feedback-cancel" href="#"><?php esc_html_e( 'Cancel', 'open-migrate' ); ?></a>
				<button type="submit" id="openmigrate-feedback-submit" class="openmigrate-button-blue openmigrate-form-submit">
					<i class="openmigrate-icon-paperplane"></i>
					<?php esc_html_e( 'Send', 'open-migrate' ); ?>
				</button>
				<span class="spinner"></span>
				<div class="openmigrate-clear"></div>
			</div>
		</div>
	</div>
</div>
