<?php

use lithium\action\Dispatcher;
use lithium\net\http\Media;

/**
 * This filter overrides the default `json` media type, only if the response type is `json`.
 * This allows to build custom `json` responses by rendering a template.
 */
Media::applyFilter('render', function($self, $params, $chain) {

	if ($params['response']->type() === 'json') {

		$params['options'] += [
			'view' => 'lithium\template\View',
			'paths' => [
				'layout'   => false,
				'template' => '{:library}/views/{:controller}/{:template}.json.php',
				'element'  => '{:library}/views/elements/{:template}.json.php'
			],
			'cast' => false,
			'encode' => false,
			'decode' => false
		];
	}

	return $chain->next($self, $params, $chain);
});

?>