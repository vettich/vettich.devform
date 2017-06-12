<?
namespace vettich\devform\types;

/**
* @author Oleg Lenshin (Vettich)
*/
class checkbox extends _type
{
	public $content = '';
	public $label = '';

	public function __construct($id, $args=array())
	{
		parent::__construct($id, $args);
		if(isset($args['label'])) {
			$this->label = $args['label'];
		}
	}

	public function renderTemplate($template='', $replaces=array())
	{
		if(isset($replaces['{value}'])) {
			$value = $replaces['{value}'];
		} else {
			$value = $this->getValue($this->data);
		}
		if(empty($value)) {
			$value = $this->default_value;
		}

		return parent::renderTemplate($template, $replaces);
	}

	public function renderView($value='')
	{
		return parent::renderView($value);
	}

	public function getValueFromPost()
	{
		$result = array();
		return $result;
	}
}