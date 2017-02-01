# vettich.devform

Модуль под Битрикс для отображение форм в административной части сайта. Модуль умеет отображать основные типы input'ов, и совершать действия при отправки формы, в частности сохранять переданные данные в COption, и в произвольных таблицах в бд. Сохранение данных в бд происходит благодаря поддержке ORM.


Рассмотрим ситуацию, когда нам нужно отобразить настройки модуля. Для этого мы создаем файл options.php в корне модуля, и добавляем туда примерно следующий код:

```php
<?
IncludeModuleLangFile(__FILE__);
CModule::IncludeModule('vettich.devform');

(new vettich\devform\AdminForm('devform', array(
	'tabs' => array(
		array(
			'name' => '#MODULE_SETTINGS#',
			'title' => '#MODULE_SETTINGS_TITLE#',
			'params' => array(
				'CO_NAME' => 'text:#YOUR_NAME#:default',
				'CO_IS_ENABLE' => new vettich\devform\types\checkbox('CO_IS_ENABLE', array(
				    'title' => '#SETTINGS_IS_ENABLE#',
				    'params' => array('style' => 'color:red'),
				)),
				'note' => array(
				    'type' => 'note',
				    'title' => '#SETTINGS_NOTE#',
				),
			),
		),
	),
	'buttons' => array(
		'save' => 'buttons.saveSubmit:#SAVE#',
		'apply' => 'buttons.submit:#APPLY#',
	),
	'data' => 'coption:module_id=vettich.devform',
)))->render();
```

Мы создаем объект класса `AdminForm`, и первым параметром передаем `id` этой формы. Вторым параметром в массиве мы перечисляем настройки.

В опции `tabs` так же массивом мы перечисляем вкладки которые будут отображаться. Саму вкладку тоже описываем набором параметров: `name` это название вкладки, `title` это то заголовок вкладки. Можно передавать как обычный текст, так и макросы, которые будут преобразованы в текст из lang'ового файла, если существует текст с соответствующим ключом.
В `params` перечисляем параметры, которые нужно отобразить, например поле ввода, или выпадающий список. Ключ массива является `id` параметра. Параметр можно указать как в виде строки, так и в виде объекта или массива. На мой взгляд проще смотрится, если параметр указать в виде стоки, так как это легче прочитать. В виде строки указывается по следующему правилу: `'type:title:default:other params'`. Разделителем служит двоеточие. Если нужно написать не разделитель а именно двоеточие, то достаточно перед ним поставить обратный слеш.
 - `type` может быть один из типов из папки `/lib/types`, например `text` - текстовое поле ввода, или `select` - выпадающий список, либо кастомный тип, который указывается полностью с `namespace`, который унаследован от `vettich\devform\types\_type`.
 - Дальше указываем название параметра `title`, например `Ваше имя`. Тут так же поддерживаются макросы.
 - `default` - значение по умолчанию, которое будет подставлено в поле ввода. Можно упустить.
 - `other params` - остальные параметры, которые указываются как `ключ=значение`, и разделяются двоеточием.


В `buttons` перечисляем кнопки, которые нужно отобразить для каких либо действий, например для сохранение формы. Формат указания такой же как и у `params` в `tabs`.

В `data` указываем класс реализующий нужное хранение данных. В данном случае это `coption`, с указанной опцией `module_id`. Есть так же возможность вместо `coption` указать `orm` для поддержки произвольных таблиц в бд. 

