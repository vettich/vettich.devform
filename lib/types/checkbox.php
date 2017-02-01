<?
namespace vettich\devform\types;

/**
* @author Oleg Lenshin (Vettich)
*/
class checkbox extends _type
{
	public $content = '<input type="hidden" value="N" name="{name}">
		<input type="checkbox" value="Y" name="{name}" id="{id}" {params}> <label for="{id}">{label}</label>';
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
		if($value == 'Y')
			$this->params['checked'] = 'checked';
		else
			unset($this->params['checked']);
		unset($this->params['class']);
		$replaces['{label}'] = $this->label;

		return parent::renderTemplate($template, $replaces);
	}

	public function renderView($value='')
	{
		if($value == 'Y') {
			$value = GetMessage('YES');
		} else {
			$value = GetMessage('NO');
		}
		return parent::renderView($value);
	}

	public function getValueFromPost()
	{
		if($_POST[$this->name] != 'Y')
			return 'N';
		return 'Y';
	}
}