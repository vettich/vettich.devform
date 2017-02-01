<?

// CModule::IncludeModule('perfmon');
// require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/perfmon/prolog.php");
// $page = new CAdminListPage('Test page title', 'my_table_id');
// $page->addColumn(new CAdminListColumn('test_id', ['filter' => 'gagaga filter', 'content' => 'gagaga content']));
// $page->show();
// return;

$cur = 'AdminFormPage';

if($cur == 'AdminListPage') {

CModule::IncludeModule('vettich.autoposting');
CModule::IncludeModule('vettich.devform');
$start = microtime(true);

(new vettich\devform\AdminList('Page title test', 'sTableID', array(
	'data' => array(
		'dbClass' => 'vettich\devform\db',
	),
	'params' => array(
		'ID' => 'string',
		'NAME' => 'string:#NAME#',
		'IS_ENABLE' => 'checkbox:#IS_ENABLE#',
	),
	'hiddenParams' => array('IS_ENABLE'),
	'sortDefault' => ['ID' => 'ASC'],
	'actions' => array(
		'delete' => function () {
			return false;
		}
	),
)))->render();

echo 'Script time: '.(microtime(true) - $start);

} elseif ($cur == 'AdminFormPage') {

CModule::IncludeModule('vettich.autoposting');
CModule::IncludeModule('vettich.devform');
$start = microtime(true);

($gg = new vettich\devform\AdminForm('devform', array(
	'tabs' => array(
		new vettich\devform\Tab(array(
			'name' => 'Примеры опций',
			'title' => 'Примеры',
			'params' => array(
/*				new vettich\devform\types\string('ggg', array(
					'title' => '#FIRST# #SECOND#',
				)),
				'ttt' => array(
					'type' => 'string',
					'title' => '#SECOND# string',
					'actions' => array(
						// array('show', 'cmp', array('#ch', 'Y')),
						array(
							'show',
							['cmp', ['#ggg', '111']],
							array(
								// 'OR',
								'cmp(<, 111, 222)',
								'cmp(#ch,Y)',
							),
						),
						// 'show:cmp(#ch,Y)',
					),
				),*/
				'DB_NAME' => 'text:#NAME#:default', // 'type:title:default:value'
				'DB_IS_ENABLE' => 'checkbox:DB Is enable:N',
				'CO_IS_ENABLE' => 'checkbox:COptions Is enable',
				'CO_note' => 'note:This is note #SECOND#',
			),
		)),
		array(
			'name' => 'Связи опций',
			'params' => array(
				'CO_link' => 'text:#LINK#',
			),
		),
	),
	'buttons' => array(
		'button_id' => 'buttons\saveSubmit:#SAVE#',
		'button_id2' => 'buttons\submit:#APPLY#',
	),
	'data' => /*array(*/
		// new vettich\devform\data\orm(array(
		// 	'class' => 'vettich\devform\db',
		// 	'paramPrefix' => 'DB_',
		// 	'trimPrefix' => true,
		// )),
		// new vettich\devform\data\COption(array(
		// 	'module_id' => 'vettich.devform',
		// 	'paramPrefix' => 'CO_',
		// 	'trimPrefix' => true,
		// )),
		array(
			'class' => 'COption',
			'module_id' => 'vettich.devform',
			'paramPrefix' => 'CO_',
			'trimPrefix' => true,
		// )
	),
)))->render();

echo 'Script time: '.(microtime(true) - $start);

} elseif ($cur == 'devform') {

$start = microtime(true);

$vopt = new VOptions();

$arModuleParams = array(
	'TABS' => array(
		'TAB1' => array(
			'NAME' => 'Tab name',
			'TITLE' => 'Tab title',
		)
	),
	'PARAMS' => array(
		'ggg2' => array(
			'TAB' => 'TAB1',
			'NAME' => 'First param',
			'TYPE' => 'STRING',
		),
		'ttt2' => array(
			'TAB' => 'TAB1',
			'NAME' => 'Second string',
			'TYPE' => 'STRING',
		),
	),
);
$vopt->init();

echo 'Script time: '.(microtime(true) - $start);

}
