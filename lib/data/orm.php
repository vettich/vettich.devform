<?
namespace vettich\devform\data;

use vettich\devform\exceptions\DataException;

/**
* @author Oleg Lenshin (Vettich)
*/
class orm extends _data
{
	public $filter = array();
	public $ID = null;

	private $dbClass = null;
	private $arValues = null;

	function __construct($args=array())
	{
		if(isset($args['filter'])) {
			$this->filter = $args['filter'];
		} elseif(!empty($_GET['ID'])) {
			$this->filter = array('ID' => $_GET['ID']);
		}

		if(isset($args['dbClass'])) {
			$this->dbClass = $args['dbClass'];
			if(!$this->isClass()) {
				throw new DataException("\"$this->dbClass\" not found");
			}
		} else {
			throw new DataException("\"dbClass\" param not found");
		}

		parent::__construct($args);
	}

	private function isClass()
	{
		if(class_exists($this->dbClass)) {
			return true;
		}
		if(class_exists($this->dbClass.'Table')) {
			$this->dbClass .= 'Table';
			return true;
		}
		return false;
	}

	public function save(&$arValues=array())
	{
		$isChange = false;
		foreach($arValues as $key => $value) {
			if(!$this->exists($key)) {
				continue;
			}
			if($this->trimPrefix) {
				$key = $this->trim($key);
			}
			/*if($this->arValues[$key] != $value)*/ {
				self::valueTo($this->arValues, $key, $value);
				$isChange = true;
			}
		}
		if($isChange) {
			$cl = $this->dbClass;
			$arV = $this->arValues;
			unset($arV['ID']);
			call_user_func($this->beforeSave, $this, $arValues);
			if($this->arValues['ID'] > 0) {
				$result = $cl::update($this->arValues['ID'], $arV);
			} else {
				$result = $cl::add($arV);
			}
			call_user_func($this->afterSave, $this, $result);
		}
		if(empty($result)) {
			return null;
		}

		$key = 'ID';
		if($this->trimPrefix && !empty($this->paramPrefix)) {
			$key = $this->paramPrefix.'ID';
		}
		$arValues[$key] = $this->arValues['ID'] = $result->getId();
		return $arValues[$key];
	}

	public function getList($params=array()) {
		if(isset($params['select'])) {
			foreach ($params['select'] as $key => $value) {
				if(false !== ($pos = strpos($value, '['))) {
					$params['select'][$key] = substr($value, 0, $pos);
				}
			}
		}
		$cl = $this->dbClass;
		if(is_array($params['filter'])) {
			$params['filter'] = array_merge((array)$this->filter, (array)$params['filter']);
		} else {
			$params['filter'] = $this->filter;
		}
		try {
			return $cl::getList($params);
		} catch(\Exception $e) {}
		return null;
	}

	public function get($name, $default=null)
	{
		if(!$this->exists($name)) {
			return $default;
		}
		return $this->_value($name, $default);
	}

	public function set($name, $val)
	{
		return $this->arValues[$name] = $val;
	}

	public function value($name, $val=null)
	{
		if($val === null) {
			return $this->get($name);
		} else {
			return $this->set($name, $val);
		}
	}

	private function _value($name, $default=null)
	{
		if($this->trimPrefix) {
			$name = $this->trim($name);
		}

		if($this->arValues) {
			// if($name == 'CONDITIONS') {
			// devdebug($name);
			// }
			return self::valueFrom($this->arValues, $name, $default);
		}

		if(!$this->filter['ID']) {
			return $default;
		}

		$cl = $this->dbClass;
		$rs = $cl::getList(array(
			'filter' => $this->filter,
			'limit' => 1,
		));
		if($ar = $rs->fetch())
			$this->arValues = $ar;
		return $this->arValues[$name] ?: $default;
	}

	public function delete($name, $value)
	{
		if(!$this->exists($name))
			return null;

		$cl = $this->dbClass;
		return $cl::delete($value)->isSuccess();
	}
}