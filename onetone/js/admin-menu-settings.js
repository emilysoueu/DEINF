(function($){

	OnetoneThemeAdmin = {

		init: function()
		{
			this._bind();
		},


		/**
		 * Binds events for the Onetone Theme.
		 *
		 */
		_bind: function()
		{
			$( document ).on('click' , '.onetone-companion-notinstalled', OnetoneThemeAdmin._installNow );
			$( document ).on('click' , '.onetone-companion-inactive', OnetoneThemeAdmin._activatePlugin);
			$( document ).on('wp-plugin-install-success' , OnetoneThemeAdmin._activatePlugin);
			$( document ).on('wp-plugin-installing'      , OnetoneThemeAdmin._pluginInstalling);
			$( document ).on('wp-plugin-install-error'   , OnetoneThemeAdmin._installError);
		},

		/**
		 * Plugin Installation Error.
		 */
		_installError: function( event, response ) {

			var $card = jQuery( '.onetone-companion-notinstalled' );

			$card
				.removeClass( 'button-primary' )
				.addClass( 'disabled' )
				.html( wp.updates.l10n.installFailedShort );
		},

		/**
		 * Installing Plugin
		 */
		_pluginInstalling: function(event, args) {
			event.preventDefault();

			var $card = jQuery( '.onetone-companion-notinstalled' );

			$card.addClass('updating-message');

		},
		/**
		 * Activate Success
		 */
		_activatePlugin: function( event, response ) {

			event.preventDefault();

			var $message = $( '.onetone-companion-notinstalled' );
			if ( 0 === $message.length ) {
				$message = $( '.onetone-companion-inactive' );
			}

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass('updating-message')
				.html( onetone.btnActivating );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax({
					url: onetone.ajaxurl,
					type: 'POST',
					data: {
						'action'            : 'onetone-companion-plugin-activate',
						'init'              : $init,
					},
				})
				.done(function (result) {

					if( result.success ) {
						var output = 'Activate Success'
						$message.removeClass( 'onetone-companion-inactive onetone-companion-notinstalled button button-primary install-now activate-now updating-message' )
							.html( output );
						window.location.href = onetone.onetone_welcome_url;

					} else {

						$message.removeClass( 'updating-message' );

					}

				});

			}, 1200 );

		},

		/**
		 * Install Now
		 */
		_installNow: function(event)
		{
			event.preventDefault();

			var $button 	= jQuery( event.target ),
				$document   = jQuery(document);

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.onetone-companion-notinstalled.updating-message' );

					$message
						.addClass('onetone-companion-inactive')
						.removeClass( 'updating-message onetone-companion-notinstalled' )
						.text( wp.updates.l10n.installNow );

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}

			wp.updates.installPlugin( {
				slug:    $button.data( 'slug' )
			} );
		},
	};

	/**
	 * Initialize OnetoneThemeAdmin
	 */
	$(function(){
		OnetoneThemeAdmin.init();
	});

})(jQuery);