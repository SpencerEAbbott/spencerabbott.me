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
 * Class PluginVersionUpdateStatus
 *
 * @abstract
 * @package craft.app.enums
 */
abstract class PluginVersionUpdateStatus extends BaseEnum
{
	const UpToDate        = 'UpToDate';
	const UpdateAvailable = 'UpdateAvailable';
	const Deleted         = 'Deleted';
	const Active          = 'Active';
	const Unknown         = 'Unknown';
}
