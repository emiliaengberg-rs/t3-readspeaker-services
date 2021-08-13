<?php

	namespace Readspeaker\ReadspeakerServices\ViewHelpers;

	use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
	use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
	use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
	use TYPO3\CMS\Core\Utility\GeneralUtility;
	use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;	
	use TYPO3\CMS\Core\Page\AssetCollector;
	use TYPO3\CMS\Core\Page\PageRenderer;
	use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

	class WebreaderbuttonViewHelper extends AbstractViewHelper {

		use CompileWithRenderStatic;
		private $ext_config;

		protected $escapeOutput = false;

		public function initializeArguments() {

			$this->ext_config = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get("readspeaker_services");

			// webReader parameters
			$this->registerArgument("scriptUrl", "string", "webReader Script Path", false, $this->ext_config["paths"]["wrScriptUrl"]);
			$this->registerArgument("customerId", "integer", "Customer ID", false, $this->ext_config["configuration"]["wrCustomerId"]);
			$this->registerArgument("readingLang", "string", "Language", false, $this->ext_config["reading"]["wrReadingLang"]);
			$this->registerArgument("autoLang", "string", "Guess Reading Language", false, $this->ext_config["reading"]["wrAutoLang"]);
			$this->registerArgument("voice", "string", "Voice", false, $this->ext_config["reading"]["wrVoice"]);
			$this->registerArgument("readId", "string", "Reading Area ID", false, $this->ext_config["reading"]["wrReadId"]);
			$this->registerArgument("readClass", "string", "Reading Area Class", false, $this->ext_config["reading"]["wrReadClass"]);
			$this->registerArgument("apiUrl", "string", "API URL", false, $this->ext_config["paths"]["wrAPIUrl"]);
			$this->registerArgument("listenLabel", "string", "Label of the Listen Button", false, $this->ext_config["phrases"]["wrListenLabel"]);
			$this->registerArgument("listenAltText", "string", "Alt Text of the Listen Button", false, $this->ext_config["phrases"]["wrListenAltText"]);
			$this->registerArgument("inlineConfig", "string", "Inline Configuration", false, $this->ext_config["configuration"]["wrInlineConfig"]);
			$this->registerArgument("scriptPlacement", "string", "webReader Script Placement", false, $this->ext_config["paths"]["wrScriptPlacement"]);


			// docReader parameters
			$this->registerArgument("drEnable", "boolean", "Add docReader Icons Automatically", false, $this->ext_config["autoadd"]["drEnable"]);
			$this->registerArgument("drCustomerId", "string", "docReader Customer ID", false, $this->ext_config["autoadd"]["drCustomerId"]);
			$this->registerArgument("drReadingLang", "string", "docReader Reading Language", false, $this->ext_config["autoadd"]["drReadingLang"]);
			$this->registerArgument("drAutoLang", "string", "Guess Document Reading Language", false, $this->ext_config["autoadd"]["drAutoLang"]);
			$this->registerArgument("drUseHrefLang", "boolean", "Use hreflang Attribute", false, $this->ext_config["autoadd"]["drUseHrefLang"]);
			$this->registerArgument("drIconPlacement", "string", "docReader Icon Placement", false, $this->ext_config["autoadd"]["drIconPlacement"]);
			$this->registerArgument("drDocClass", "string", "Custom Document Class", false, $this->ext_config["autoadd"]["drDocClass"]);
			$this->registerArgument("drAddedClass", "string", "Icon Added Indicator Class", false, $this->ext_config["autoadd"]["drAddedClass"]);
			$this->registerArgument("drImageUrl", "string", "Icon Image URL", false, $this->ext_config["autoadd"]["drImageUrl"]);
			$this->registerArgument("drImageAlt", "string", "Icon Image Alt Text", false, $this->ext_config["autoadd"]["drImageAlt"]);
		}

		public static function renderStatic(
			array $arguments,
			\Closure $renderChildrenClosure,
			RenderingContextInterface $renderingContext
		) {

			$docreader_script_path = "EXT:readspeaker_services/Resources/Public/JavaScript/ReadSpeaker.docReader.AutoAdd.js";
			$use_docreader = false;

			if (isset($arguments["drEnable"]) && (bool) $arguments["drEnable"] === true) {

				$use_docreader = true;

				// Add docReader configuration
				$dr_configuration = "window.rsDocReaderConf = {" .
									"	cid: '" . htmlentities($arguments["drCustomerId"]) . "'," . 
									"	lang: '" . (isset($arguments["drAutoLang"]) && $arguments["drAutoLang"] === "yes" ? self::_getPhrase("general.autoLangGuess") : htmlentities($arguments["drReadingLang"])) . "'," .
									"	useHrefLang: " . (isset($arguments["drUseHrefLang"]) && (bool) $arguments["drUseHrefLang"] === true ? ($arguments["drUseHrefLang"] ? "true" : "false") : "false") . "," .
									"	drBeforeLink: " . (isset($arguments["drIconPlacement"]) ? ($arguments["drIconPlacement"] === "before" ? "true" : "false") : "false") . "," .
									"	drClass: '" . htmlentities($arguments["drDocClass"]) . "'," .
									"	drAddedClass: '" . htmlentities($arguments["drAddedClass"]) . "'," .
									"	img_href: '" . htmlentities($arguments["drImageUrl"]) . "'," .
									"	img_alt: '" . (isset($arguments["drImageAlt"]) && strlen($arguments["drImageAlt"]) ? htmlentities($arguments["drImageAlt"]) : self::_getPhrase("docreader.icon.altText", false)) . "'" .
									"};";

				$page_renderer = GeneralUtility::makeInstance(PageRenderer::class)
					->addJsInlineCode("dr-config-data", $dr_configuration);

				// If we're using docReader, make sure it loads with webReader.
				$arguments["scriptUrl"] .= "&amp;dload=DocReader.AutoAdd";

			}


			// Insert any inline webReader configuration to the page.
			if (isset($arguments["inlineConfig"]) && strlen($arguments["inlineConfig"])) {

				$page_renderer = GeneralUtility::makeInstance(PageRenderer::class)
					->addJsInlineCode("wr-config-data", "window.rsConf = {$arguments["inlineConfig"]};");
			}

			// Insert the webReader script link in the page. The placement depends on the extension setting wrScriptPlacement.
			switch ($arguments["scriptPlacement"]) {

				case "head" :
					GeneralUtility::makeInstance(AssetCollector::class)
						->addJavaScript('wr-main-script', htmlentities($arguments["scriptUrl"]), [], ['priority' => true]);
					break;			

				default :
					GeneralUtility::makeInstance(PageRenderer::class)
						->addJsFooterLibrary('wr-main-script', htmlentities($arguments["scriptUrl"]));

			}


			// Build the listen button's href attribute.
			$rsent_url = $arguments["apiUrl"];
			$href = $rsent_url .
				"?customerid=" . htmlentities($arguments["customerId"]) .
				"&amp;lang=" . (isset($arguments["autoLang"]) && $arguments["autoLang"] === "yes" ? self::_getPhrase("general.autoLangGuess") : htmlentities($arguments["readingLang"])) .
				(isset($arguments["voice"]) && strlen($arguments["voice"]) ? "&amp;voice=" . htmlentities($arguments["voice"]) : "") .
				(isset($arguments["readId"]) && strlen($arguments["readId"]) ? "&amp;readid=" . htmlentities($arguments["readId"]) : "") .
				(isset($arguments["readClass"]) && strlen($arguments["readClass"]) ? "&amp;readclass=" . htmlentities($arguments["readClass"]) : "");

			// Set the Listen button's label and alt text
			$listen_alt_text = isset($arguments["listenAltText"]) && strlen($arguments["listenAltText"]) ? htmlentities($arguments["listenAltText"]) : self::_getPhrase("webreader.listenButton.altText");
			$listen_label = isset($arguments["listenLabel"]) && strlen($arguments["listenLabel"]) ? htmlentities($arguments["listenLabel"]) : self::_getPhrase("webreader.listenButton.label");

			// Return the listen button's markup
			return 
				"<div id=\"readspeaker_button1\" class=\"rs_skip rsbtn rs_preserve\">" .
				"	<a class=\"rsbtn_play\" accesskey=\"L\" title=\"$listen_alt_text\" href=\"$href\" role=\"button\">" .
				"		<span class=\"rsbtn_left rsimg rspart\"><span class=\"rsbtn_text\"><span>$listen_label</span></span></span>" .
				"		<span class=\"rsbtn_right rsimg rsplay rspart\"></span>" .
				"	</a>" .
				"</div>";
		}

		/**
		 * Fetches a localization phrase from the locallang.xlf (or <lang>.locallang.xlf) file in
		 * EXT:readspeaker_services/Resources/Private/Language).
		 * 
		 * @param  string  $id             The phrase ID.
		 * @param  bool    $encode_phrase  Whether the code should be HTML entity-encoded before returned.
		 * @return String                  The requested phrase in the language that the user has selected.
		 */
		private static function _getPhrase(string $id, bool $encode_phrase = true) {
			$phrase = LocalizationUtility::translate($id, "readspeaker_services");
			return $encode_phrase ? htmlentities($phrase) : $phrase;
		}

	}