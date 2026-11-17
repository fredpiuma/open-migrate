/**
 * Open Migrate: restore a backup that is already in the backups folder.
 *
 * backups.min.js calls OpenMigrate.FreeExtensionRestore(archive, size) when the
 * "Restore" action is clicked. It reuses the Import model from import.min.js and
 * starts the import chain at the default priority, so the upload step is skipped.
 */
( function ( $ ) {
	'use strict';

	OpenMigrate.FreeExtensionRestore = function ( archive, size ) {
		var model = new OpenMigrate.Import();

		model.setParams( [
			{ name: 'storage', value: OpenMigrate.Util.random( 12 ) },
			{ name: 'archive', value: archive },
			{ name: 'openmigrate_manual_restore', value: 1 }
		] );

		model.setStatus( { type: 'info', message: openmigrate_locale.preparing_to_import } );
		model.checkDiskSpace( parseInt( size, 10 ) || 0, function () {
			model.start();
		} );
	};
}( jQuery ) );
