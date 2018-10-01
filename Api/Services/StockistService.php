<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 04/07/2018
 * Time: 12:53
 */
namespace Entymon\Stockists\Api\Services;

class StockistService
{
	const EN_OPTION__ORDER_REGION = 'en_order_region';
	const EN_OPTION__ISO_CODE_COUNTRY = 'en_iso_country_code';
	const EN_TERM__IMAGE_URL_COUNTRY = 'category-image-id';

	/**
	 * @param \WP_Post $post
	 * @return array
	 */
	public function getStockistDataByStockistPost(\WP_Post $post)
	{
		$meta = get_post_meta($post->ID);
		return [
			'id' => $post->ID,
			'title' => $post->post_title,
			'email' => ($meta[EN_PREFIX . '_email']) ? $meta[EN_PREFIX . '_email'][0] : '',
			'second_email' => ($meta[EN_PREFIX . '_email_2']) ? $meta[EN_PREFIX . '_email_2'][0] : '',
			'fax' => ($meta[EN_PREFIX . '_fax']) ? $meta[EN_PREFIX . '_fax'][0] : '',
			'phone' => ($meta[EN_PREFIX . '_phone']) ? $meta[EN_PREFIX . '_phone'][0] : '',
			'mobile' => ($meta[EN_PREFIX . '_mobile']) ? $meta[EN_PREFIX . '_mobile'][0] : '',
			'website' => ($meta[EN_PREFIX . '_website']) ? $meta[EN_PREFIX . '_website'][0] : '',
			'town' => ($meta[EN_PREFIX . '_town']) ? $meta[EN_PREFIX . '_town'][0] : '',
			'state' => ($meta[EN_PREFIX . '_state']) ? $meta[EN_PREFIX . '_state'][0] : '',
		];
	}

	public function getRegionByStockistId($id)
	{
		$terms = wp_get_post_terms($id, EN_STOCKIST_REGION_TAXONOMY);
		if (!empty($terms)) {
			return $this->getRegionDataById($terms[0]->term_id);
		}
	}

	public function getCountryByStockistId($id)
	{
		$terms = wp_get_post_terms($id, EN_STOCKIST_COUNTRY_TAXONOMY);
		if (!empty($terms)) {
			return $this->getCountryDataById($terms[0]->term_id);
		}
	}

	public function getRegionDataById($regionId)
	{
		$term = get_term($regionId, EN_STOCKIST_REGION_TAXONOMY);
		$termMeta = get_option("taxonomy_term_$regionId");
		$order = isset($termMeta[self::EN_OPTION__ORDER_REGION]) ? (int)$termMeta[self::EN_OPTION__ORDER_REGION] : 0;

		return [
			'id' => $term->term_id,
			'name' => $term->name,
			'slug' => $term->slug,
			'order' => $order,
		];
	}

	public function getCountryDataById($countryId)
	{
		$country = get_term($countryId, EN_STOCKIST_COUNTRY_TAXONOMY);
		$termMeta = get_option("taxonomy_term_$countryId");
		$isoCode = isset($termMeta[self::EN_OPTION__ISO_CODE_COUNTRY]) ? $termMeta[self::EN_OPTION__ISO_CODE_COUNTRY] : '';

		$imageId = get_term_meta($country->term_id, 'category-image-id', true);

		return [
			'id' => $country->term_id,
			'name' => $country->name,
			'slug' => $country->slug,
			'iso_code' => $isoCode,
			'image_url' => ($imageId) ? wp_get_attachment_image_url($imageId, 'full') : '',
		];
	}

	public function sortByRegion($data)
	{
		$sortedData = [];
		foreach ($data as $stockist) {
			$regionKey = (isset($stockist['region'])) ? $stockist['region']['slug'] : 'other';
			$countryKey = (isset($stockist['country'])) ? $stockist['country']['iso_code'] : 'other';

			if (!array_key_exists($regionKey, $sortedData)) {

				// Add new region array
				$sortedData[$regionKey] = [
					'region_name' => (isset($stockist['region']['name'])) ? $stockist['region']['name'] : '',
					'id' => (isset($stockist['region']['id'])) ? (int) $stockist['region']['id'] : 0,
					'slug' => $regionKey,
					'order' => (isset($stockist['region']['order'])) ? (int) $stockist['region']['order'] : 0,
					'countries' => []
				];
				$sortedData[$regionKey]['countries'][$countryKey] = [
					'id' => (isset($stockist['country']['id'])) ? (int) $stockist['country']['id'] : 0,
					'country_name' => (isset($stockist['country']['name'])) ? $stockist['country']['name'] : '',
					'slug' => (isset($stockist['country']['slug'])) ? $stockist['country']['slug'] : '',
					'iso_code' => $countryKey,
					'image_url' => (isset($stockist['country']['image_url'])) ? $stockist['country']['image_url'] : '',
					'stockists' => []
				];
			} else if (!array_key_exists($countryKey, $sortedData[$regionKey]['countries'])) {

				// Add new country array
				$sortedData[$regionKey]['countries'][$countryKey] = [
					'id' => (isset($stockist['country']['id'])) ? (int) $stockist['country']['id'] : 0,
					'country_name' => (isset($stockist['country']['name'])) ? $stockist['country']['name'] : '',
					'slug' => (isset($stockist['country']['slug'])) ? $stockist['country']['slug'] : '',
					'iso_code' => $countryKey,
					'image_url' => (isset($stockist['country']['image_url'])) ? $stockist['country']['image_url'] : '',
					'stockists' => []
				];
			}

			$sortedData[$regionKey]['countries'][$countryKey]['stockists'][] = $stockist;
		}
		return $sortedData;
	}
}