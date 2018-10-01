<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 10:51
 */

namespace Entymon\Stockists\App;


class CountryImage
{
	/*
	 * Initialize the class and start calling our hooks and filters
	 * @since 1.0.0
	*/
	public function init()
	{
		add_action(EN_STOCKIST_COUNTRY_TAXONOMY.'_add_form_fields', array($this, 'addImage'), 10, 2);
		add_action('created_'.EN_STOCKIST_COUNTRY_TAXONOMY, array($this, 'saveImage'), 10, 2);
		add_action(EN_STOCKIST_COUNTRY_TAXONOMY.'_edit_form_fields', array($this, 'updateImage'), 10, 2);
		add_action('edited_'.EN_STOCKIST_COUNTRY_TAXONOMY, array($this, 'updatedImage'), 10, 2);

		add_action('admin_enqueue_scripts', array($this, 'loadMedia'));
		add_action('admin_footer', array($this, 'addScript'));

		// Add image to country list of taxonomies
		add_filter('manage_edit-'.EN_STOCKIST_COUNTRY_TAXONOMY.'_columns', array($this, 'addFlagImageColumnToList'), 10, 1);

		// Add to content to column function
		add_filter('manage_'.EN_STOCKIST_COUNTRY_TAXONOMY.'_custom_column', array($this, 'manageContentForColumn'), 10, 3);
	}

	public function loadMedia()
	{
		wp_enqueue_media();
	}

	/*
	 * Add a form field in the new category page
	 * @since 1.0.0
	*/
	public function addImage($taxonomy)
	{ ?>
		<div class="form-field term-group">
			<label for="category-image-id"><?php _e('Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?></label>
			<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
			<div id="category-image-wrapper"></div>
			<p>
				<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button"
							 name="ct_tax_media_button" value="<?php _e('Add Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?>"/>
				<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove"
							 name="ct_tax_media_remove" value="<?php _e('Remove Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?>"/>
			</p>
		</div>
		<?php
	}

	/*
	 * Save the form field
	 * @since 1.0.0
	*/
	public function saveImage($term_id, $tt_id)
	{
		if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
			$image = $_POST['category-image-id'];
			add_term_meta($term_id, 'category-image-id', $image, true);
		}
	}

	/*
	 * Edit the form field
	 * @since 1.0.0
	*/
	public function updateImage($term, $taxonomy)
	{ ?>
		<tr class="form-field term-group-wrap">
			<th scope="row">
				<label for="category-image-id"><?php _e('Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?></label>
			</th>
			<td>
				<?php $image_id = get_term_meta($term->term_id, 'category-image-id', true); ?>
				<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
				<div id="category-image-wrapper">
					<?php if ($image_id) { ?>
						<?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
					<?php } ?>
				</div>
				<p>
					<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button"
								 name="ct_tax_media_button" value="<?php _e('Add Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?>"/>
					<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove"
								 name="ct_tax_media_remove" value="<?php _e('Remove Image', EN_STOCKIST_LANGUAGE_NAMESPACE); ?>"/>
				</p>
			</td>
		</tr>
		<?php
	}

	/*
	 * Update the form field value
	 * @since 1.0.0
	 */
	public function updatedImage($term_id, $tt_id)
	{
		if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
			$image = $_POST['category-image-id'];
			update_term_meta($term_id, 'category-image-id', $image);
		} else {
			update_term_meta($term_id, 'category-image-id', '');
		}
	}

	/*
	 * Add script
	 * @since 1.0.0
	 */
	public function addScript()
	{ ?>
		<script>
			jQuery(document).ready(function ($) {

					function ct_media_upload(button_class) {
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;
						$('body').on('click', button_class, function (e) {
							var button_id = '#' + $(this).attr('id');
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = $(button_id);
							_custom_media = true;
							wp.media.editor.send.attachment = function (props, attachment) {
								if (_custom_media) {
									$('#category-image-id').val(attachment.id);
									$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
									$('#category-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
								} else {
									return _orig_send_attachment.apply(button_id, [props, attachment]);
								}
							};
							wp.media.editor.open(button);
							return false;
						});
					}

					ct_media_upload('.ct_tax_media_button.button');
					$('body').on('click', '.ct_tax_media_remove', function () {
						$('#category-image-id').val('');
						$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
					});

					$(document).ajaxComplete(function (event, xhr, settings) {
						if (settings.data) {
							var queryStringArr = settings.data.split('&');
							if ($.inArray('action=add-tag', queryStringArr) !== -1) {
								var xml = xhr.responseXML;
								$response = $(xml).find('term_id').text();
								if ($response !== '') {
									// Clear the thumb image
									$('#category-image-wrapper').html('');
								}
							}
						}
					});
				});
		</script>
	<?php }

	public function addFlagImageColumnToList($columns) {

		$extendedColumns = [];
		foreach ($columns as $key => $column) {
			if ($key === 'slug') {
				$extendedColumns['country_flag'] = __('Country Flag');
			}
			if ($key !== 'description') {
				$extendedColumns[$key] = $column;
			}
		}
		return $extendedColumns;
	}

	/**
	 * Add content to particular column
	 * @param $out
	 * @param $columnName
	 * @param $termId
	 * @return string
	 */
	public function manageContentForColumn($out, $columnName, $termId)
	{
		$image_id = get_term_meta($termId, 'category-image-id', true);
		switch ($columnName) {
			case 'country_flag':
				if ($image_id) {
					$out .= wp_get_attachment_image($image_id, array('50', '50'));
				} else {
					$out .= '';
				}
				break;

			default:
				break;
		}
		return $out;
	}
}
