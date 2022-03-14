<?php

defined("TYPO3_MODE") || die("Access denied.");

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	"ReadspeakerServices",
	"ReadspeakerServices",
	[
		\Readspeaker\ReadspeakerServices\Controller\ReadspeakerServicesController::class => "webreader",
	],
	[
		\Readspeaker\ReadspeakerServices\Controller\ReadspeakerServicesController::class => "",
	]
);