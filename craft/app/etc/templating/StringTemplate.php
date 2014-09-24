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
 * Class StringTemplate
 *
 * @package craft.app.etc.templating
 */
class StringTemplate
{
	public $cacheKey;
	public $template;
 
	/**
	 * Constructor
	 *
	 * @param string $cacheKey
	 * @param string $template
	 */
	function __construct($cacheKey = null, $template = null)
	{
		$this->cacheKey = $cacheKey;
		$this->template = $template;
	}
 
	/**
	 * Use the cache key as the string representation.
	 *
	 * @return string
	 */
	function __toString()
	{
		return $this->cacheKey;
	}
}
