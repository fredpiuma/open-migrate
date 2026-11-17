/**
 * Open Migrate: chunked upload of a .wpress file.
 *
 * import.min.js sends the whole file in a single POST, which PHP rejects when the
 * file is larger than post_max_size / upload_max_filesize. When OpenMigrate.
 * FileExtensionUploader is defined, import.min.js uses it instead of its own
 * uploader. This one extends FileUploader and only replaces upload(): the file is
 * sliced in parts (openmigrate_uploader.chunk_size) and each part is written by the
 * server at chunk_offset, so a retried part never corrupts the archive.
 */
( function ( $ ) {
	'use strict';

	var Base = OpenMigrate.FileUploader;
	var MAX_RETRIES = 5;

	var ChunkUploader = function () {
		Base.call( this );
	};

	ChunkUploader.prototype = Object.create( Base.prototype );
	ChunkUploader.prototype.constructor = ChunkUploader;

	ChunkUploader.prototype.upload = function ( file ) {
		var self = this;
		var size = file.size;
		var chunkSize = parseInt( openmigrate_uploader.chunk_size, 10 ) || ( 1024 * 1024 );
		var offset = 0;

		this.xhr = null;

		var fail = function ( jqXHR, textStatus ) {
			if ( jqXHR.status === 0 ) {
				return self.onError( new Error( openmigrate_locale.upload_failed_connection_lost ), true );
			}

			if ( jqXHR.status === 413 ) {
				return self.onError( new Error( openmigrate_locale.file_too_large ), true );
			}

			var json = OpenMigrate.Util.json( jqXHR.responseText );
			if ( json ) {
				var data = JSON.parse( json );
				if ( data.errors && data.errors.length > 0 ) {
					return self.onError( new Error( data.errors[ 0 ].message ), true );
				}
			}

			self.onError( new Error( openmigrate_locale.upload_failed + ' (' + jqXHR.status + '): ' + ( jqXHR.statusText || textStatus ) ), true );
		};

		var send = function ( attempt ) {
			if ( self.stopUpload ) {
				return;
			}

			var end = Math.min( offset + chunkSize, size );
			var data = new FormData();

			data.append( 'upload_file', file.slice( offset, end ), file.name );
			for ( var name in openmigrate_uploader.params ) {
				data.append( name, openmigrate_uploader.params[ name ] );
			}
			data.append( 'chunk_offset', offset );

			$.ajax( {
				url: openmigrate_uploader.url,
				type: 'POST',
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				xhr: function () {
					self.xhr = $.ajaxSettings.xhr();
					if ( self.xhr.upload ) {
						self.xhr.upload.addEventListener( 'progress', function ( event ) {
							var done = size > 0 ? ( ( offset + event.loaded ) / size ) * 100 : 100;
							self.model.setStatus( { type: 'progress', percent: Math.min( done, 100 ).toFixed( 2 ) } );
						} );
					}
					return self.xhr;
				},
				success: function () {
					if ( self.stopUpload ) {
						return;
					}

					offset = end;
					if ( offset >= size ) {
						self.onFileUploaded();
					} else {
						send( 0 );
					}
				},
				error: function ( jqXHR, textStatus ) {
					if ( self.stopUpload || textStatus === 'abort' ) {
						return;
					}

					// Connection drops and server errors are retried: the part is written at a fixed offset.
					if ( ( jqXHR.status === 0 || jqXHR.status >= 500 ) && attempt < MAX_RETRIES ) {
						return setTimeout( function () {
							send( attempt + 1 );
						}, 1000 * ( attempt + 1 ) );
					}

					fail( jqXHR, textStatus );
				}
			} );
		};

		send( 0 );
	};

	OpenMigrate.FileExtensionUploader = ChunkUploader;
}( jQuery ) );
