<?php

use lithium\action\Dispatcher;
use lithium\net\http\Media;

/**
 * DISCLAIMER: This is the dumbest idea ever, but get things done at the moment.
 * This filter overrides the default `json` registered media type, only if the request type is `json`.
 * This allows to build custom `json` responses by rendering a template,
 * and still use the default `json` type when rendering a response isn't necessary (`$coll->to('json')`)
 */
Dispatcher::applyFilter('_callable', function($self, $params, $chain) {

	if ($params['request']->type() == 'json') {

		Media::type('json', 'application/json', array(
			'view' => 'lithium\template\View',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
				'layout'   => false,
				'element'  => '{:library}/views/elements/{:template}.{:type}.php'
			),
			'conditions' => array('type' => true)
		));

	}

	return $chain->next($self, $params, $chain);

});

?>