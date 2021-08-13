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

call_user_func(function() {
   $extensionKey = 'ReadspeakerServices';

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
      $extensionKey,
      'setup',
      "@import 'EXT:readspeaker_services/Configuration/TypoScript/setup.typoscript'"
   );
});