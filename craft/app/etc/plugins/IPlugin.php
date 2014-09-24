<?php
namespace Craft;

/**
 * Craft by Pixel & Tonic
 *
 * @package   Craft
 * @author    Pixel & Tonic, Inc.
 * @copyright Copyright (c) 2014, Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license Craft License Agreement
 * @link      http://buildwithcraft.com
 */

/**
 * Interface IPlugin
 *
 * @package craft.app.etc.plugins
 */
interface IPlugin extends ISavableComponentType
{
	/**
	 * @return string|null
	 */
	public function getSettingsUrl();
}
