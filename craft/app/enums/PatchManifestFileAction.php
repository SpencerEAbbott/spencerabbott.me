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
 * Class PatchManifestFileAction
 *
 * @abstract
 * @package craft.app.enums
 */
abstract class PatchManifestFileAction extends BaseEnum
{
	const Add    = 'Add';
	const Remove = 'Remove';
}
