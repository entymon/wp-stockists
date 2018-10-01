<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 16:10
 */

namespace Entymon\Stockists\Api;

use Entymon\Stockists\Api\Services\StockistService;

class StockistController extends \WP_REST_Controller
{

	/**
	 * @var StockistService
	 */
	private $service;

	public function init()
	{
		$this->service = new StockistService();
		add_action('rest_api_init', [$this, 'registerStockistRoutes']);
	}

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function registerStockistRoutes()
	{
		$version = '1';
		$namespace = 'jolly/v' . $version . '/stockist';

		register_rest_route($namespace, '/stockists', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getStockists'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		// get stockists by country
		register_rest_route($namespace, '/stockists/(?P<id>\d+)', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getStockistsByCountryId'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		register_rest_route($namespace, '/countries', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getCountries'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));

		register_rest_route($namespace, '/regions', array(
			array(
				'methods' => \WP_REST_Server::READABLE,
				'callback' => array($this, 'getRegions'),
				'permission_callback' => array($this, 'getPermissionsCheck'),
				'args' => array(),
			)
		));
	}

	/**
	 * Grab posts
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getStockists(\WP_REST_Request $request)
	{
		$args = array(
			'post_type' => EN_STOCKIST_POST,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);

		$query = new \WP_Query( $args );
		$posts = $query->posts;

		$data = [];
		if (!empty($posts)) {
			foreach ($posts as $post) {

				$region = $this->service->getRegionByStockistId($post->ID);
				$country = $this->service->getCountryByStockistId($post->ID);
				$stockist = $this->service->getStockistDataByStockistPost($post);

				$data[] = [
					'region' => $region,
					'country' => $country,
					'stockist' => $stockist
				];

			}
			$data = $this->service->sortByRegion($data);
		}
		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Grab latest post title by an author!
	 *
	 * @param \WP_REST_Request $request
	 * @return \WP_REST_Response.
	 */
	public function getStockistsByCountryId(\WP_REST_Request $request)
	{
		$parameters = $request->get_url_params();

		$args = array(
			'post_type' => EN_STOCKIST_POST,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => EN_STOCKIST_COUNTRY_TAXONOMY,
					'field' => 'term_id',
					'terms' => [$parameters['id']]
				),
			)
		);

		$query = new \WP_Query( $args );
		$posts = $query->posts;

		$stockists = [];
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$stockists[] = $this->service->getStockistDataByStockistPost($post);
			}
		}

		$data = [
			'country' => $this->service->getCountryDataById($parameters['id']),
			'stockists' => $stockists
		];

		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Get a collection of items
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response
	 */
	public function getCountries($request) {

		$terms = get_terms( EN_STOCKIST_COUNTRY_TAXONOMY, array(
			'hide_empty' => false,
		));

		if ($terms instanceof \WP_Error) {
			return new \WP_REST_Response( $terms, 500 );
		}

		$data = [];
		if (!empty($terms)) {
			foreach ($terms as $term) {

				if (is_object($term)) {
					$termId = $term->term_id;
				} else {
					$termId = $term['term_id'];
				}

				$data[] = $this->service->getCountryDataById($termId);
			}
		}
		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Get a collection of items
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response
	 */
	public function getRegions( $request ) {

		$terms = get_terms( EN_STOCKIST_REGION_TAXONOMY, array(
			'hide_empty' => false,
		));

		if ($terms instanceof \WP_Error) {
			return new \WP_REST_Response( $terms, 500 );
		}

		$data = [];
		if (!empty($terms)) {
			foreach ($terms as $term) {

				if (is_object($term)) {
					$termId = $term->term_id;
				} else {
					$termId = $term['term_id'];
				}

				$data[] = $this->service->getRegionDataById($termId);
			}
		}
		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return bool
	 */
	public function getPermissionsCheck( $request ) {
		return true; // use to make readable by all
	}
}