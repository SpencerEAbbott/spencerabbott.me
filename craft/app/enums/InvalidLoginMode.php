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
 * Class InvalidLoginMode
 *
 * @abstract
 * @package craft.app.enums
 */
abstract class InvalidLoginMode extends BaseEnum
{
	const Cooldown = 'cooldown';
	const Lockout  = 'lockout';
}
