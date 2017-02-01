<?
ini_set('display_errors', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

CModule::IncludeModule('vettich.devform');
IncludeModuleLangFile(__FILE__);
$start = microtime(true);

(new vettich\devform\AdminList('Page title test', 'sTableID', array(
	'dbClass' => 'vettich\devform\db',
	'params' => array(
		'ID' => 'number',
		'NAME' => 'text:#NAME#',
		'IS_ENABLE' => 'checkbox:#IS_ENABLE#',
	),
	'hiddenParams' => array('ID'),
	'sortDefault' => ['ID' => 'ASC'],
	'dontEdit' => array('ID'),
	'actions' => array(
		'delete' => array(
			'TITLE' => 'Delete 2',

		),
	),
	'on doGroupActions' => function ($arID, $action) {
ddebug([$arID, $action]);
	},
	'buttons' => array(
		'link' => 'buttons\link:Link:http\://ya.ru',
	),
)))->render();

echo 'Script time: '.(microtime(true) - $start);

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
