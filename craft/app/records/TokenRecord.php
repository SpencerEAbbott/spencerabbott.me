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
 * Token record.
 *
 * @package craft.app.records
 */
class TokenRecord extends BaseRecord
{
	/**
	 * @return string
	 */
	public function getTableName()
	{
		return 'tokens';
	}

	/**
	 * @access protected
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array(
			'token'      => array(AttributeType::String, 'column' => ColumnType::Char, 'length' => 32, 'required' => true),
			'route'      => array(AttributeType::Mixed),
			'usageLimit' => array(AttributeType::Number, 'min' => 0, 'max' => 255),
			'usageCount' => array(AttributeType::Number, 'min' => 0, 'max' => 255),
			'expiryDate' => array(AttributeType::DateTime, 'required' => true),
		);
	}

	/**
	 * @return array
	 */
	public function defineIndexes()
	{
		return array(
			array('columns' => array('token'), 'unique' => true),
			array('columns' => array('expiryDate')),
		);
	}
}
