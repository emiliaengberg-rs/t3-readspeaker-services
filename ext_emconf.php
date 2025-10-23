<?php

$EM_CONF[$_EXTKEY] = [
	"title" => "ReadSpeaker Services for Typo3",
	"description" => "A Typo3 extension for easily integrating ReadSpeaker webReader and docReader into your website. Please note that you need a valid ReadSpeaker license in order to use this extension. Learn more on www.readspeaker.com.",
	"category" => "plugin",
	"author" => "Andreas Stenberg",
	"author_company" => "ReadSpeaker",
	"author_email" => "andreas.stenberg@readspeaker.com",
	"state" => "stable",
	"clearCacheOnLoad" => true,
	"version" => "2.0.0",
	"constraints" => [
		"depends" => [
			"typo3" => "13.0.0-13.9.99"
		],
	],
];
