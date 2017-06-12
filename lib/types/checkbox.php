<?
namespace vettich\devform\types;

/**
* @author Oleg Lenshin (Vettich)
*/
class checkbox extends _type
{
	public $content = '<input type="hidden" value="N" name="{name}">
		<input type="checkbox" value="Y" name="{name}" id="{id}" {params}> <label for="{id}">{label}</label>';
	public $content_multiple = '<div id="{id}"> {options} </div>';
	public $option_template = '<input type="checkbox" name="{name}[{value}]" {checked} {params} id="{id}-{value}" value="Y"> <label for="{id}-{value}">{label}</label><br>';
	public $label = '';
	public $multiple = false;
	public $options = null;

	public function __construct($id, $args=array())
	{
		if(isset($args['label'])) {
			$this->label = $args['label'];
		}
		if(isset($args['options'])) {
			$this->options = $args['options'];
		}
		if(isset($args['multiple'])) {
			$this->multiple = $args['multiple'];
			if($args['multiple'] === true) {
				$this->content = $this->content_multiple;
			}
		}
		parent::__construct($id, $args);
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
		if(!$this->multiple) {
			if($value == 'Y') {
				$this->params['checked'] = 'checked';
			} else {
				unset($this->params['checked']);
			}
			unset($this->params['class']);
			$replaces['{label}'] = $this->label;
		} else {
			if(!is_array($value)) {
				$value = unserialize($value);
			}
			$html_options = '';
			foreach ($this->options as $key => $opt) {
				$repls = array(
					'{checked}' => in_array($key, $value) ? 'checked' : '',
					'{label}' => self::mess($opt),
					'{value}' => $key,
					'{params}' => $this->renderParams(),
				);
				$html_options .= str_replace(
					array_keys($repls),
					array_values($repls),
					$this->option_template
				);
			}
			$replaces['{options}'] = $html_options;
			$replaces['{id}'] = $this->id;
			$replaces['{name}'] = $this->name;
		}

		return parent::renderTemplate($template, $replaces);
	}

	public function renderView($value='')
	{
		if(!$this->multiple) {
			if($value == 'Y') {
				$value = GetMessage('YES');
			} else {
				$value = GetMessage('NO');
			}
		} else {
			if(!is_array($value)) {
				$value = unserialize($value);
			}
			$result = array();
			foreach ($value as $key) {
				$result[] = $this->options[$key];
			}
			$value = implode('<br>', $result);
		}
		return parent::renderView($value);
	}

	public function getValueFromPost()
	{
		if(!$this->multiple) {
			$val = self::post($this->name);
			if($val == null) {
				return null;
			}
			if($val != 'Y') {
				return 'N';
			}
			return 'Y';
		}
		$result = array();
		$post = self::post($this->name) ?: array();
		foreach($post as $key => $value) {
			$result[] = $key;
		}
		return $result;
	}
}