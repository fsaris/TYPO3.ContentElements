<?php
defined('TYPO3_MODE') or die();


// Used for everything that is an video
$GLOBALS['TCA']['sys_file_reference']['palettes']['videooverlayPalette'] = array(
	'showitem' => '
			title,description,--linebreak--
			',
	'canNotCollapse' => TRUE
);

// Used for everything that is an video
$GLOBALS['TCA']['sys_file_reference']['palettes']['audiooverlayPalette'] = array(
	'showitem' => '
			title,description,--linebreak--
			',
	'canNotCollapse' => TRUE
);