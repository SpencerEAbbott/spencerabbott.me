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
 * Class LicenseKeyStatus
 *
 * @abstract
 * @package craft.app.enums
 */
abstract class LicenseKeyStatus extends BaseEnum
{
	const Valid            = 'Valid';
	const Invalid          = 'Invalid';
	const Missing          = 'Missing';
	const Unverified       = 'Unverified';
	const MismatchedDomain = 'MismatchedDomain';
}
