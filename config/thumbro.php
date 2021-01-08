<?php
/**
 * Rosemary Shrager
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2020 Ether Creative
 */

return [
	'domain' => getenv('DEFAULT_SITE_URL') . '/thumbor',
	'securityKey' => getenv('SECURITY_KEY'),
	'thumborUrlModifier' => function ($url) {
		return str_replace(getenv('DEFAULT_SITE_URL') . '/thumbor', 'http://thumbor', $url);
	},
];