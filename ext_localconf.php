<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

	// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'] = array(
	'contentelements/Configuration/TypoScript/Static/'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PatrickBroens.' . $_EXTKEY,
	'Contentelements',
	array(
		'ContentElement' => 'render'
	),
	array()
);

	// Remove obsolete fields and set some defaults
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:contentelements/Configuration/TypoScript/PageTSconfig/default.ts">'
);

	// Minimum set of fields, recommended for beginners, when showMinimumSetOfFields is set to 1 in Extension Manager
$extensionConfiguration = unserialize($_EXTCONF);
if(is_array($extensionConfiguration)) {
	if ($extensionConfiguration['showMinimumSetOfFields']) {
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
			'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:contentelements/Configuration/TypoScript/PageTSconfig/minimum.ts">'
		);
	}
}

// Add SYS.mediafile_ext when not existing yet
// Should be moved to eXT:core/Configuration/DefaultConfiguration.php
if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] =
		$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ',avi,mp4,mp3,wav';
}