var Vettich = Vettich || {};
Vettich.Devform = {};

$(document).ready(function(){
	$('.js-vform').show();
	vettich_devform_textarea_choose_show();
	$('select.js-text-option').on('change', vettich_devform_select_text_option);

	var _block = false;
	$('.textarea_select .adm-btn').click(function(){
		var $this = $(this);
		var items;
		if((items = $this.parent().find('.items')).css('display') == 'none') {
			items.css('display', 'block');
		} else {
			items.css('display', 'none');
		}
		_block = true;
	});
	$(document).click(function(event) {
		if(_block) {
			_block = false;
			return;
		}
		if ($(event.target).closest('.textarea_select .items').length) return;
		$('.textarea_select .items').css('display', 'none');
		event.stopPropagation();
	});

	$('.textarea_select .items > div').click(vettich_devform_paste_to_textarea_click);

	$('input[type="submit"]').click(function(e){
		BX.adminPanel.closeWait(this);
	});
})


function vettich_devform_refresh () {
	var _link = window.location.href;
	var show = BX.showWait('adm-workarea');
	var formid = 'TAB_CONTROL_' + vettich_devform_formid;
	$('body').append('<div id="voptions_overlay" class="vettich-devform-overlay"></div>');
	var _linkHash = -1;
	if((_linkHash = _link.indexOf('#')) > 0) {
		_link = _link.substring(0, _linkHash);
	}
	if(_link.indexOf('?') > 0)
		_link += '&ajax=Y';
	else
		_link += '?ajax=Y';
	console.log('ajax to ' + _link);
	var _data = jQuery("#FORM_" + vettich_devform_formid).serialize();
	if(_data.indexOf('_active_tab') < 0)
		_data += '&' + formid + '_active_tab=' + $('#' + formid + '_active_tab').val();
	jQuery.ajax({
		url: _link,
		type: "POST",
		data: _data,
		timeout: 10000,
		success: function(data){
			jdata = $(data);
			sdata = data;
			BX.closeWait('adm-workarea', show);
			$('#voptions_overlay').remove();
			// parser = new DOMParser();
			// _dom = parser.parseFromString(data, 'text/html');

			// if(!_dom || !_dom.getElementById("tabControl_layout"))
			// 	return;

			$('#'+ formid + '_layout').html(data);
			eval(formid + '.PreInit()');
			$('.js-vform').show();
			// $('#tabControl_layout').html(_dom.getElementById("tabControl_layout").outerHTML);
		},
		error: function(response, status) {
			BX.closeWait('adm-workarea', show);
			$('#voptions_overlay').remove();
			new BX.CDialog({
				'title':'Error',
				'content':'<center>Error: ' + status + '</center>',
				'width':400,
				'height':150,
				'buttons':[
					BX.CDialog.prototype.btnClose,
				]
			}).Show();
		}
	});
}

function vettich_devform_select_text_option() {
	var $this = $(this);
	if(!!$this.find('option:selected').data('text-option')) {
		$this.parent().append('<input name="' + $this.attr('name') + '" style="display: block;">');
	} else {
		$this.parent().find('input').remove();
	}
}

function vettich_devform_textarea_choose_show () {
	$('.textarea_select').each(function() {
		var $this = $(this);
		if($this.find('.items').children().length) {
			$this.css('display', 'block');
		}
	})
}

function vettich_devform_paste_to_textarea_click() {
	var $this = $(this);
	var value = $this.data('value');
	var textarea = $this.closest('td').find('textarea')[0];
	var istart = textarea.selectionStart;
	var iend = textarea.selectionEnd;
	var itxt = textarea.value;
	textarea.value = itxt.substr(0, istart) + value + itxt.substr(iend);
	textarea.focus();
	var cursor = value.length + istart;
	textarea.setSelectionRange(cursor, cursor);
}
