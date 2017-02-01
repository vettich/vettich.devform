<?
namespace vettich\devform\types\buttons;

use vettich\devform\types\_type;

/**
* 
*/
class link extends _type
{
	public $template = '<a {params} name="{name}" href="{default_value}">{title}</a>';
	public $params = array('class' => 'adm-btn');
}