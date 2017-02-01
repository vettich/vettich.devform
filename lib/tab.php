<?
namespace vettich\devform;

use vettich\devform\types\_type;

/**
* show tabs for admin form
*
* @author Oleg Lenshin (Vettich)
* @var string $name
* @var string $title
* @var array $params
* @var boolean $enable
*/
class Tab extends Object
{
	public $name = 'Tab';
	public $title = '';
	public $params = null;
	public $enable = true;
	
	function __construct($args = array())
	{
		if(isset($args['name'])) $this->name = self::mess($args['name']);
		if(isset($args['title'])) $this->title = self::mess($args['title']);
		if(isset($args['params'])) $this->params = $args['params'];
		if(isset($args['enable'])) $this->enable = $args['enable'];
	}

	public function render($data=null)
	{
		echo _type::renderTypes($this->params, $data);
	}
}