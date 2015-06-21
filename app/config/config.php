<?php
	$parameters = include(__DIR__ . '/./parameters.php');
	$getParameter = function($param, $default) use (&$parameters)
	{
		return isset($parameters[$param]) ? $parameters[$param] : $default;
	};

	return [
		'parameters' => $parameters,
		'debug' => $getParameter('debug', false), // setting to true is equivalent to dev environment
		'bundles' => include(__DIR__.'/./bundles.php'),
		'db' => $getParameter('db', null),
		'twig' => $getParameter('twig', false),
		'assetsVersion' => 'v2',
		'locale' => $getParameter('locale', 'ru'),
		'settings' => [
			'sitename' => [
				'title' => 'Название сайта',
			],
			'sitedescription' => [
				'title' => 'Описание сайта (для RSS, например)',
			],
			'motto' => [
				'title' => 'Девиз сайта',
			],
			'copyright' => [
				'title' => 'Копирайт',
			],
			'counters' => [
				'title' => 'Счётчики',
			],
			'blogAuthor' => [
				'title' => 'Автор блога',
			],
			'webmaster' => [
				'title' => 'Email web-мастера',
			],
			'soc.twitter' => [
				'title' => 'Ссылка на twitter',
			],
			'soc.vk' => [
				'title' => 'Ссылка на VK',
			],
		],
	];