<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 22/05/2018
 * Time: 22:44
 */

namespace Entymon\Stockists\App;

/**
 * Class MetaBox
 *
 * Additional information for stockist
 * @package Entymon\Stockists\Application
 */
class MetaBox
{
	public function init()
	{
		add_action( 'add_meta_boxes', array($this, 'createMetaBox'), 10, 2 );
		add_filter( 'save_post', array($this, 'saveMetaBox'), 10, 2 );
	}

	public function createMetaBox( $post_type, $post ) {
		// http://codex.wordpress.org/Function_Reference/add_meta_box
		add_meta_box(
			'stockist_information_meta_box', // (string) (required) HTML 'id' attribute of the edit screen section
			__( 'Stockist Information', EN_STOCKIST_LANGUAGE_NAMESPACE ), // (string) (required) Title of the edit screen section, visible to user
			array( __NAMESPACE__.'\MetaBox', 'componentFormView' ), // (callback) (required) Function that prints out the HTML for the edit screen section. The function name as a string, or, within a class, an array to call one of the class's methods.
			EN_STOCKIST_POST,
			'normal',
			'high'
		);
	}

	public function componentFormView( $post, $metabox) {
		?>
		<input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
		<?php wp_nonce_field( 'save_stockist_' . $metabox['id'], $metabox['id'] . '_stockist_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th>
					<label for="en-stockist-email"><?php _e( 'Email', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_email"
							type="text"
							id="en-stockist-email"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_email', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-email-2"><?php _e( 'Second Email', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_email_2"
							type="text"
							id="en-stockist-email-2"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_email_2', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-fax"><?php _e( 'Fax Number', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_fax"
							type="text"
							id="en-stockist-fax"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_fax', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-mobile"><?php _e( 'Mobile Number', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_mobile"
							type="text"
							id="en-stockist-mobile"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_mobile', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-phone"><?php _e( 'Phone Number', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_phone"
							type="text"
							id="en-stockist-phone"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_phone', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-website"><?php _e( 'Website', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_website"
							type="text"
							id="en-stockist-website"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_website', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-town"><?php _e( 'Town', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_town"
							type="text"
							id="en-stockist-town"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_town', true); ?>"
							class="regular-text">
				</td>
			</tr>
			<tr>
				<th>
					<label for="en-stockist-state"><?php _e( 'State', EN_STOCKIST_LANGUAGE_NAMESPACE ); ?></label>
				</th>
				<td>
					<input
							name="en_stockist_state"
							type="text"
							id="en-stockist-state"
							value="<?php echo get_post_meta($post->ID, EN_PREFIX.'_state', true); ?>"
							class="regular-text">
				</td>
			</tr>
		</table>

		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_email" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_email_2" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_fax" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_mobile" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_phone" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_website" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_town" />
		<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="en_stockist_state" />
		<?php
	}

	public function saveMetaBox( $post_id, $post ) {

		// Check if this information is being submitted by means of an autosave; if so, then do not process any of the following code
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ return; }

		// Determine if the postback contains any metaboxes that need to be saved
		if ( empty( $_POST['meta_box_ids'] ) ){ return; }

		// Iterate through the registered metaboxes
		foreach( $_POST['meta_box_ids'] as $metabox_id ){
			// Verify thhe request to update this metabox
			if ( ! wp_verify_nonce( $_POST[ $metabox_id . '_stockist_nonce' ], 'save_stockist_' . $metabox_id ) ){ continue; }

			// Determine if the metabox contains any fields that need to be saved
			if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }

			// Iterate through the registered fields
			foreach( $_POST[ $metabox_id . '_fields' ] as $field_id ){
				// Update or create the submitted contents of the fiels as post meta data
				// http://codex.wordpress.org/Function_Reference/update_post_meta
				update_post_meta($post_id, $field_id, $_POST[ $field_id ]);
			}
		}

		return $post;
	}
}