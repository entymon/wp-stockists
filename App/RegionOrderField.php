<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 03/07/2018
 * Time: 14:52
 */

namespace Entymon\Stockists\App;


class RegionOrderField
{
	public function init()
	{
		add_action(EN_STOCKIST_REGION_TAXONOMY.'_add_form_fields', array($this, 'orderField'), 10, 2);
		add_action('created_'.EN_STOCKIST_REGION_TAXONOMY, array($this, 'saveOrderField'), 10, 2);
		add_action( EN_STOCKIST_REGION_TAXONOMY.'_edit_form_fields', array($this, 'orderField'), 10, 2 );
		add_action( 'edited_'.EN_STOCKIST_REGION_TAXONOMY, array($this, 'saveOrderField'), 10, 2 );

		// Add column to list of taxonomies
		add_filter('manage_edit-'.EN_STOCKIST_REGION_TAXONOMY.'_columns', array($this, 'addOrderFieldList'), 10, 1);

		// Add to content to column function
		add_filter('manage_'.EN_STOCKIST_REGION_TAXONOMY.'_custom_column', array($this, 'manageContentForColumn'), 10, 3);
	}

	public function orderField($tag) {
		// Check for existing taxonomy meta for the term you're editing
		$t_id = $tag->term_id; // Get the ID of the term you're editing
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
		?>

		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="en_order_region"><?php _e('Order number'); ?></label>
			</th>
			<td>
				<input type="text" name="term_meta[en_order_region]" id="term_meta[en_order_region]" size="25" style="width:60%;" value="<?php echo $term_meta['en_order_region'] ? $term_meta['en_order_region'] : ''; ?>"><br />
				<span class="description"><?php _e('Order number of list of regions. Decides which region is first and which one is next.'); ?></span>
			</td>
		</tr>

		<?php
	}

	// A callback function to save our extra taxonomy field(s)
	public function saveOrderField( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ){
				if ( isset( $_POST['term_meta'][$key] ) ){
					if ($key === 'en_order_region') {
						$term_meta[$key] = (int) $_POST['term_meta'][$key];
					} else {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
			}
			//save the option array
			update_option( "taxonomy_term_$t_id", $term_meta );
		}
	}

	function addOrderFieldList($columns) {
		$extendedColumns = [];
		foreach ($columns as $key => $column) {
			if ($key === 'slug') {
				$extendedColumns['order_filed'] = __('Order Number');
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
		switch ($columnName) {
			case 'order_filed':
				$termMeta = get_option( "taxonomy_term_$termId" );
				if (isset($termMeta['en_order_region'])) {
					$out .= $termMeta['en_order_region'];
				}
				break;

			default:
				break;
		}
		return $out;
	}
}


// Add field: https://sabramedia.com/blog/how-to-add-custom-fields-to-custom-taxonomies