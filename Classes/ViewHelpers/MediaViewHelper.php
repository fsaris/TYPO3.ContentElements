<?php
namespace PatrickBroens\Contentelements\ViewHelpers;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Rendering\RendererRegistry;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;


/**
 * Render a given media file with the correct html tag.
 *
 * It asks the RendererRegister for the correct Renderer class and if not found it falls
 * back the the ImageViewhelper as that is the "Renderer" class for images in Fluid context.
 *
 * = Examples =
 * *
 * <code title="Image Object">
 *     <f:media file="{file}" width="400" height="375" />
 * </code>
 * <output>
 *     <img alt="alt set in image record" src="fileadmin/_processed_/323223424.png" width="396" height="375" />
 * </output>
 *
 * <code title="MP4 Video Object">
 *     <f:media file="{file}" width="400" height="375" />
 * </code>
 * <output>
 *     <video width="400" height="375" controls><source src="fileadmin/user_upload/my-video.mp4" type="video/mp4"></video>
 * </output>
 *
 * <code title="MP4 Video Object with loop option set">
 *     <f:media file="{file}" width="400" height="375" />
 * </code>
 * <output>
 *     <video width="400" height="375" controls loop><source src="fileadmin/user_upload/my-video.mp4" type="video/mp4"></video>
 * </output>
 *
 */
class MediaViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper {

	/**
	 * Render a given media file
	 *
	 * @param FileInterface|AbstractFileFolder $file
	 * @param array $additionalConfig
	 * @param string $width This can be a numeric value representing the fixed width of in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @param string $height This can be a numeric value representing the fixed height in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
	 * @return string Rendered tag
	 */
	public function render($file, $additionalConfig = array(), $width = NULL, $height = NULL) {

		// get Resource Object (non ExtBase version)
		if (is_callable(array($file, 'getOriginalResource'))) {
			// We have a domain model, so we need to fetch the FAL resource object from there
			$file = $file->getOriginalResource();
		}

		// Fallback to imageViewHelper when no renderer is found
		if (
			!empty($additionalConfig['forceStaticImage'])
			||
			($fileRenderer = RendererRegistry::getInstance()->getRenderer($file)) === NULL
		) {
			return parent::render(NULL, $width, $height, NULL, NULL, NULL, NULL, FALSE, $file);
		}
		$additionalConfig = array_merge_recursive($this->arguments, $additionalConfig);
		return $fileRenderer->render($file, $width, $height, $additionalConfig);
	}
}