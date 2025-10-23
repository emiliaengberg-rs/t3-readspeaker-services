<?php
defined("TYPO3") || die("Access denied.");

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Readspeaker\ReadspeakerServices\Controller\ReadspeakerServicesController;

ExtensionUtility::configurePlugin(
	"ReadspeakerServices",
	"ReadspeakerServices",
	[
		ReadspeakerServicesController::class => "webreader",
	],
	[
		ReadspeakerServicesController::class => "",
	],
	ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
