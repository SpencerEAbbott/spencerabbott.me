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
 * Field type template variable.
 *
 * @package craft.app.validators
 */
class FieldTypeVariable extends BaseComponentTypeVariable
{
	/**
	 * Returns the field's input HTML.
	 *
	 * @param string $handle
	 * @param mixed $value
	 * @return string
	 */
	public function getInputHtml($handle, $value)
	{
		return $this->component->getInputHtml($handle, $value);
	}

	/**
	 * Returns static HTML for the field's value.
	 *
	 * @param string $value
	 * @return string
	 */
	public function getStaticHtml($value)
	{
		return $this->component->getStaticHtml($value);
	}
}
