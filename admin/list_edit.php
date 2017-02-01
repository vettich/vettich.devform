<?
ini_set('display_errors', true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');

CModule::IncludeModule('vettich.autoposting');
CModule::IncludeModule('vettich.devform');
IncludeModuleLangFile(__FILE__);
$start = microtime(true);

($gg = new vettich\devform\AdminForm('devform', array(
	'pageTitle' => 'Page title test',
	'tabs' => array(
		new vettich\devform\Tab(array(
			'name' => 'Примеры опций',
			'title' => 'Примеры',
			'params' => array(
				'ID' => 'hidden',
				'NAME' => 'text:#NAME#:default',
				'IS_ENABLE' => 'checkbox:DB Is enable:N',
			),
		)),
	),
	'buttons' => array(
		'save' => 'buttons\saveSubmit:#SAVE#',
		'apply' => 'buttons\submit:#APPLY#',
	),
	'headerButtons' => array(
		'link1' => 'buttons\link:Link button:https\://ya.ru',
	),
	'data' => array(
		'class' => 'orm',
		'dbClass' => 'vettich\devform\db',
		// 'paramPrefix' => 'DB_',
		'trimPrefix' => true,
	),
)))->render();

echo 'Script time: '.(microtime(true) - $start);

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
