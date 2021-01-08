<?php
/**
 * Reveal Media
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2021 Ether Creative
 */

namespace b;

use Craft;
use craft\web\View;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;

/**
 * Class Variable
 *
 * @author  Ether Creative
 * @package b
 */
class Variable
{

	/**
	 * Returns the value from the manifest
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function manifest (string $name): string
	{
		static $manifest;

		if (!$manifest)
		{
			$manifestRaw = file_get_contents(__DIR__ . '/../manifest.json');
			$manifest = json_decode($manifestRaw, true);
		}

		return $manifest[$name];
	}

	/**
	 * Injects critical CSS for given handle
	 *
	 * @param string $handle
	 *
	 * @throws LoaderError
	 * @throws SyntaxError
	 */
	public function critical (string $handle)
	{
		if (getenv('CRITICAL') === 'false')
			return;

		$critical = Craft::$app->view->renderString(
			'{{ source("_critical/' . $handle . '.css", ignore_missing=true) }}'
		);

		Craft::$app->view->registerCss($critical);
	}

	public function isCritical (): bool
	{
		return (
			getenv('ENVIRONMENT') === 'dev'
			&& Craft::$app->getRequest()->getQueryParam('critical') !== null
		);
	}

	/**
	 * @param string $url     - The URL to the JS file
	 * @param array  $options - An array of options to be used as attributes
	 * @param string $pre     - Will link rel="pre${pre}" if not null
	 */
	public function js (string $url, $options = [], $pre = 'connect')
	{
		$view = Craft::$app->view;

		if ($pre)
		{
			$crossOrigin = !$this->_compareUrls(
				$url,
				Craft::$app->sites->currentSite->baseUrl
			);

			$view->registerLinkTag([
				'rel'         => 'pre' . $pre,
				'href'        => $url,
				'as'          => 'script',
				'crossorigin' => $crossOrigin,
			]);
		}

		$view->registerScript(
			'',
			View::POS_END,
			array_merge(
				['src' => $url],
				$options
			),
			md5($url)
		);
	}

	// Helpers
	// =========================================================================

	private function _compareUrls ($a, $b): bool
	{
		$a = parse_url($a, PHP_URL_HOST);
		$b = parse_url($b, PHP_URL_HOST);

		return $this->_trim($a) === $this->_trim($b);
	}

	private function _trim ($str): string
	{
		if (stripos($str, 'www.') === 0)
			return substr($str, 4);

		return $str;
	}

}
