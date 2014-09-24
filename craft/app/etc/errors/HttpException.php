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
 * Class HttpException
 *
 * @package craft.app.etc.errors
 */
class HttpException extends \CHttpException
{
	/**
	 * @param      $status
	 * @param null $message
	 * @param int  $code
	 */
	function __construct($status = '', $message = null, $code = 0)
	{
		$status = $status ? $status : '';
		Craft::log(($status ? $status.' - ' : '').$message, LogLevel::Warning);
		parent::__construct($status, $message, $code);
	}
}
