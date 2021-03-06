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
 * Element criteria model class.
 *
 * @implements \Countable
 * @package craft.app.models
 */
class ElementCriteriaModel extends BaseModel implements \Countable
{
	private $_elementType;

	private $_supportedFieldHandles;

	private $_cachedElements;
	private $_cachedElementsAtOffsets;
	private $_cachedIds;
	private $_cachedTotal;

	/**
	 * Constructor
	 *
	 * @param mixed $attributes
	 * @param BaseElementType $elementType
	 */
	function __construct($attributes, BaseElementType $elementType)
	{
		$this->_elementType = $elementType;
		parent::__construct($attributes);
	}

	/**
	 * @access protected
	 * @return array
	 */
	protected function defineAttributes()
	{
		$attributes = array(
			'ancestorDist'   => AttributeType::Number,
			'ancestorOf'     => AttributeType::Mixed,
			'archived'       => AttributeType::Bool,
			'dateCreated'    => AttributeType::Mixed,
			'dateUpdated'    => AttributeType::Mixed,
			'descendantDist' => AttributeType::Number,
			'descendantOf'   => AttributeType::Mixed,
			'fixedOrder'     => AttributeType::Bool,
			'id'             => AttributeType::Number,
			'indexBy'        => AttributeType::String,
			'level'          => AttributeType::Number,
			'limit'          => array(AttributeType::Number, 'default' => 100),
			'locale'         => AttributeType::Locale,
			'localeEnabled'  => array(AttributeType::Bool, 'default' => true),
			'nextSiblingOf'  => AttributeType::Mixed,
			'offset'         => array(AttributeType::Number, 'default' => 0),
			'order'          => array(AttributeType::String, 'default' => 'elements.dateCreated desc'),
			'prevSiblingOf'  => AttributeType::Mixed,
			'relatedTo'      => AttributeType::Mixed,
			'ref'            => AttributeType::String,
			'search'         => AttributeType::String,
			'siblingOf'      => AttributeType::Mixed,
			'slug'           => AttributeType::String,
			'status'         => array(AttributeType::String, 'default' => BaseElementModel::ENABLED),
			'title'          => AttributeType::String,
			'uri'            => AttributeType::String,
			'kind'           => AttributeType::Mixed,

			// TODO: Deprecated
			'childField'     => AttributeType::String,
			'childOf'        => AttributeType::Mixed,
			'depth'          => AttributeType::Number,
			'parentField'    => AttributeType::String,
			'parentOf'       => AttributeType::Mixed,
		);

		// Mix in any custom attributes defined by the element type
		$elementTypeAttributes = $this->_elementType->defineCriteriaAttributes();
		$attributes = array_merge($attributes, $elementTypeAttributes);

		// Mix in the custom fields
		$this->_supportedFieldHandles = array();

		foreach (craft()->fields->getAllFields() as $field)
		{
			// Make sure the handle doesn't conflict with an existing attribute
			if (!isset($attributes[$field->handle]))
			{
				$this->_supportedFieldHandles[] = $field->handle;
				$attributes[$field->handle] = array(AttributeType::Mixed);
			}
		}

		return $attributes;
	}

	/**
	 * Returns an iterator for traversing over the elements.
	 *
	 * Required by the IteratorAggregate interface.
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->find());
	}

	/**
	 * Returns whether an element exists at a given offset.
	 *
	 * Required by the ArrayAccess interface.
	 *
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		if (is_numeric($offset))
		{
			return ($this->findElementAtOffset($offset) !== null);
		}
		else
		{
			return parent::offsetExists($offset);
		}
	}

	/**
	 * Returns the element at a given offset.
	 *
	 * Required by the ArrayAccess interface.
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		if (is_numeric($offset))
		{
			return $this->findElementAtOffset($offset);
		}
		else
		{
			return parent::offsetGet($offset);
		}
	}

	/**
	 * Sets the element at a given offset.
	 *
	 * Required by the ArrayAccess interface.
	 *
	 * @param mixed $offset
	 * @param mixed $item
	 */
	public function offsetSet($offset, $item)
	{
		if (is_numeric($offset) && $item instanceof BaseElementModel)
		{
			$this->_cachedElementsAtOffsets[$offset] = $item;
		}
		else
		{
			return parent::offsetSet($offset, $item);
		}
	}

	/**
	 * Unsets an element at a given offset.
	 *
	 * Required by the ArrayAccess interface.
	 *
	 * @param mixed $offset
	 */
	public function offsetUnset($offset)
	{
		if (is_numeric($offset))
		{
			unset($this->_cachedElementsAtOffsets[$offset]);
		}
		else
		{
			return parent::offsetUnset($offset);
		}
	}

	/**
	 * Returns the total number of elements matched by this criteria.
	 *
	 * Required by the Countable interface.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->find());
	}

	/**
	 * Clears the cached values when a new attribute is set.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return bool
	 */
	public function setAttribute($name, $value)
	{
		if (parent::setAttribute($name, $value))
		{
			$this->_cachedElements = null;
			$this->_cachedElementsAtOffsets = null;
			$this->_cachedIds = null;
			$this->_cachedTotal = null;
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Returns the element type.
	 *
	 * @return BaseElementType
	 */
	public function getElementType()
	{
		return $this->_elementType;
	}

	/**
	 * Returns the field handles that didn't conflict with the main attribute names.
	 *
	 * @return array
	 */
	public function getSupportedFieldHandles()
	{
		return $this->_supportedFieldHandles;
	}

	/**
	 * language => locale
	 */
	public function setLanguage($locale)
	{
		$this->setAttribute('locale', $locale);
		return $this;
	}

	/**
	 * Returns all elements that match the criteria.
	 *
	 * @param array|null $attributes
	 * @return array
	 */
	public function find($attributes = null)
	{
		$this->setAttributes($attributes);

		$this->_includeInTemplateCaches();

		if (!isset($this->_cachedElements))
		{
			$this->_cachedElements = craft()->elements->findElements($this);

			// Cache 'em
			$offset = $this->offset;
			foreach ($this->_cachedElements as $element)
			{
				$this->_cachedElementsAtOffsets[$offset] = $element;
				$offset++;
			}
		}

		return $this->_cachedElements;
	}

	/**
	 * Returns an element at a specific offset.
	 *
	 * @param int $offset
	 * @return BaseElementModel|null
	 */
	public function findElementAtOffset($offset)
	{
		if (!isset($this->_cachedElementsAtOffsets) || !array_key_exists($offset, $this->_cachedElementsAtOffsets))
		{
			$criteria = new ElementCriteriaModel($this->getAttributes(), $this->_elementType);
			$criteria->offset = $offset;
			$criteria->limit = 1;
			$elements = $criteria->find();

			if ($elements)
			{
				$this->_cachedElementsAtOffsets[$offset] = $elements[0];
			}
			else
			{
				$this->_cachedElementsAtOffsets[$offset] = null;
			}
		}

		return $this->_cachedElementsAtOffsets[$offset];
	}

	/**
	 * Returns the first element that matches the criteria.
	 *
	 * @param array|null $attributes
	 * @return BaseElementModel|null
	 */
	public function first($attributes = null)
	{
		$this->setAttributes($attributes);

		return $this->findElementAtOffset(0);
	}

	/**
	 * Returns the last element that matches the criteria.
	 *
	 * @param array|null $attributes
	 * @return BaseElementModel|null
	 */
	public function last($attributes = null)
	{
		$this->setAttributes($attributes);

		$total = $this->total();

		if ($total)
		{
			return $this->findElementAtOffset($total-1);
		}
	}

	/**
	 * Returns all element IDs that match the criteria.
	 *
	 * @param array|null $attributes
	 * @return array
	 */
	public function ids($attributes = null)
	{
		$this->setAttributes($attributes);

		$this->_includeInTemplateCaches();

		if (!isset($this->_cachedIds))
		{
			$this->_cachedIds = craft()->elements->findElements($this, true);
		}

		return $this->_cachedIds;
	}

	/**
	 * Returns the total elements that match the criteria.
	 *
	 * @param array|null $attributes
	 * @return int
	 */
	public function total($attributes = null)
	{
		$this->setAttributes($attributes);

		$this->_includeInTemplateCaches();

		if (!isset($this->_cachedTotal))
		{
			$this->_cachedTotal = craft()->elements->getTotalElements($this);
		}

		return $this->_cachedTotal;
	}

	/**
	 * Returns a copy of this model.
	 *
	 * @return BaseModel
	 */
	public function copy()
	{
		$class = get_class($this);
		return new $class($this->getAttributes(), $this->_elementType);
	}

	/**
	 * Includes
	 *
	 * @access private
	 */
	private function _includeInTemplateCaches()
	{
		$cacheService = craft()->getComponent('templateCache', false);

		if ($cacheService)
		{
			$cacheService->includeCriteriaInTemplateCaches($this);
		}
	}
}
