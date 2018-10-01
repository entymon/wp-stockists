<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 23/05/2018
 * Time: 18:41
 */

namespace Entymon\Stockists\App;


class View
{
	public function init()
	{
		add_shortcode('stockists', [$this, 'stockistsShortCode']);
		add_action( 'wp_enqueue_scripts', [$this, 'addingReactStyles']);
		add_action( 'wp_enqueue_scripts', [$this, 'addingReactScript']);
	}

	public function stockistsShortCode()
	{
		return '<div id="js-jolly-stockists-view"></div>';
	}

	public function addingReactScript()
	{
		$pathToFile = plugins_url().'/jolly-stockists/view/build/static/js/main.js';

		wp_register_script('jolly-stockists-react-view', $pathToFile, [],'1.1', true);
		wp_enqueue_script('jolly-stockists-react-view');
	}

	public function addingReactStyles()
	{
		$pathToFile = plugins_url().'/jolly-stockists/view/build/static/css/main.css';

		wp_register_style('jolly-stockists-react-view-style', $pathToFile, [],'1.1', true);
		wp_enqueue_style('jolly-stockists-react-view-style');
	}
}