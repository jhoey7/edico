$(document).ready(function () {
	$("input, textarea, select").focus(function () {
		if ($(this).attr('mandatory') == "yes") {
			$(this).removeClass('mandatory');
		}
	});
	FormReady();
});
var applicationName = "INVENT 1";
function signin(form) {
	if (validasi(form)) {
		$.ajax({
			type: 'POST',
			url: $('[name="' + form + '"]').attr('action') + '/ajax',
			data: $('[name="' + form + '"]').serialize(),
			dataType: 'json',
			success: function (data) {
				if (typeof (data) != 'undefined') {
					var arrayDataTemp = data.returnData.split("|");
					if (arrayDataTemp[0] > 0) {
						swalert('success', arrayDataTemp[1]);
						setTimeout(function () { window.location.href = arrayDataTemp[2] }, 1500);
					} else {
						swalert('error', arrayDataTemp[1]);
					}
				}
			}
		});
	} else {
		return false
	}
}

function FormReady() {
	$("form :input:not(input:password,#email,#EMAIL_USER,#EMAIL,#USERNAME)").keyup(function () {
		toUpper(this);
	});
}

function toUpper(obj) {
	var mystring = obj.value;
	newstring = mystring.toUpperCase();
	;
	obj.value = newstring;
	return true;
}

function swalert(type, message, time) {
	if (time != undefined) time = time;
	else time = 2000;
	if (type == "success") {
		swal({
			title: applicationName,
			text: message,
			timer: time,
			type: 'success',
			showConfirmButton: false,
			html: true
		});
	}
	else if (type == "error") {
		swal({
			title: applicationName,
			text: message,
			timer: time,
			type: 'error',
			showConfirmButton: false,
			html: true
		});
	}
}

function notify(message, type) {
	switch (type) {
		case 'success':
			jQuery.gritter.add({
				title: 'Success!!!',
				text: message,
				sticky: false,
				class_name: 'growl-success',
				time: ''
			});
			return false;
			break;
		case 'error':
			jQuery.gritter.add({
				title: 'Error!!!',
				text: message,
				sticky: false,
				class_name: 'growl-danger',
				time: ''
			});
			return false;
			break;
		case 'warning':
			jQuery.gritter.add({
				title: 'Warning!!!',
				text: message,
				sticky: false,
				class_name: 'growl-warning',
				time: ''
			});
			return false;
			break;
			deafault:
			jQuery.gritter.add({
				title: 'Info!',
				text: message,
				sticky: false,
				class_name: 'growl-info',
				time: ''
			});
			return false;
			break;
	}
}

function validasi(form) {
	var notvalid = 0;
	var notnumber = 0;
	var regNumber = /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
	$.each($('#' + form + " input, #" + form + " textarea, #" + form + " select"), function (n, element) {
		if ($(this).attr('mandatory') == "yes") {
			if ($(element).val() == "") {
				$(this).addClass('mandatory');
				notvalid++;
			}
		}
		if ($(this).attr('format') == "number" && (!regNumber.test($(this).val()) && $(this).val() != "")) {
			$(this).addClass('format');
			notnumber++;
		}
	});
	if (notvalid > 0 || notnumber > 0) {
		var errorString = "";
		if (notvalid > 0) {
			errorString += 'Terdapat data yang harus diisi';
		}
		if (notnumber > 0) {
			errorString += 'There are ' + notvalid + ' data is required number';
		}
		swalert('error', errorString);
		return false;
	} else {
		return true;
	}
	return false;
}

function validasi_duplicate(field, divid) {
	if (divid == "" || typeof (divid) == "undefined") {
		var divid = "msg_";
	} else {
		var divid = divid;
	}
	var notduplicate = 0;
	$.each($("input:hidden"), function (n, element) {
		if ($(this).attr('duplicate') == "no" && $('#' + field).val() == $(this).val()) {
			$(this).addClass('duplicate');
			notduplicate++;
		}
	});
	if (notduplicate > 0) {
		var errorString = "Notifikasi!";
		errorString += '<br>Terdapat data yang sama';
		$("." + divid).css('color', 'red');
		noty({ text: errorString, type: 'error' });
		return false;
	} else {
		return true;
	}
	return false;
}

function close_popup(type) {
	switch (type) {
		case '1': popup = jpopup_close(); break
		case '2': popup = jpopup_closetwo(); break;
	}
	return popup;
}

function Laporan(formid, divData, page, jenis) {
	if (validasi(formid)) {
		$.ajax({
			type: 'POST',
			url: page,
			data: $('#' + formid).serialize(),
			beforeSend: function () { Loading(true) },
			complete: function () { Loading(false) },
			success: function (data) {
				$("." + divData).html(data);
			}
		})
	} return false;
}

function lap_pagging(action, divid, data, frmid) {
	var formdata = '';
	formdata = $("#" + frmid).serialize();
	$.ajax({
		type: 'POST',
		url: action,
		data: 'ajax=1&hal=' + data + '&' + formdata,
		beforeSend: function () { Loading(true); },
		complete: function () { Loading(false); },
		success: function (html) {
			$("." + divid).html(html);
		}
	});
}

function print_report(tipe, jenis) {
	document.frm_laporan.action = site_url + "/report/proses/" + tipe + "/" + jenis;
	document.frm_laporan.method = "POST";
	document.frm_laporan.target = "_blank";
	document.frm_laporan.submit();
	if (tipe == "pemasukan" || tipe == "pengeluaran") {
		document.frm_laporan.action = site_url + "/report/" + tipe;
	} else {
		document.frm_laporan.action = site_url + "/report/proses/" + tipe;
	}
}

function save_post(form, div) {
	if (validasi(form)) {
		if (validasi(form)) {
			swal({
				title: 'Confirm',
				text: 'Apakah ingin proses data ?',
				type: 'info',
				showCancelButton: true,
				closeOnConfirm: true,
				showLoaderOnConfirm: true,
			}, function (r) {
				if (r) {
					$.ajax({
						type: 'POST',
						dataType: "json",
						url: $('[name="' + form + '"]').attr('action'),
						data: $('[name="' + form + '"]').serialize(),
						beforeSend: function () { Loading(true) },
						complete: function () { Loading(false) },
						success: function (result) {
							var format = JSON.stringify(result);
							var data = JSON.parse(format);

							if (Object.keys(data).length > 0) {
								if (data.status == "success") {
									setTimeout(function () { location.href = data._url; }, 1500);
									notify(data.message, 'success');
									return false;
								} else {
									Loading(false)
									notify(data.message, 'error');
								}
							}
						}
					}).responseJSON;
				} else {
					return false
				}
			});
		}
	}
}

function save_popup(form, div) {
	if (validasi(form)) {
		swal({
			title: 'Confirm',
			text: 'Apakah ingin process data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true,
		}, function (r) {
			if (r) {
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: $('[name="' + form + '"]').attr('action'),
					data: $('[name="' + form + '"]').serialize(),
					beforeSend: function () { Loading(true) },
					complete: function () { Loading(false) },
					success: function (result) {
						var format = JSON.stringify(result);
						var data = JSON.parse(format);

						if (Object.keys(data).length > 0) {
							if (data.status == "success") {
								if (div != "undefined") {
									notify(data.message, 'success');
									setTimeout(function () {
										$('#' + div).load(data._url);
										jpopup_close();
									}, 2000);
								} else {
									setTimeout(function () { location.href = data._url; }, 1500);
									notify(data.message, 'success');
								}
								return false;
							} else {
								Loading(false)
								notify(data.message, 'error');
							}
						}
					}
				}).responseJSON;
			} else {
				return false
			}
		});
	}
}

function cancel(formid) {
	document.getElementById(formid).reset();
	return false;
};

function Loading_Table(boolean) {
	if (boolean) {
		$('#Loading').show();
	}
	else {
		$('#Loading').hide();
	}
}

function save_dialog(formid, msg) {
	if (validasi(msg)) {
		$.ajax({
			type: 'POST',
			url: $(formid).attr('action'),
			data: $(formid).serialize(),
			success: function (data) {
				if (data.search("MSG") >= 0) {
					arrdata = data.split('#');
					if (arrdata[1] == "OK") {
						$("." + msg).css('color', 'green');
						$("." + msg).html(arrdata[2]);
						$("#divtblmohon").load(arrdata[3]);
						closedialog('dialog-tbl');
					} else {
						$("." + msg).css('color', 'red');
						$("." + msg).html(arrdata[2]);
					}
				} else {
					$("." + msg).css('color', 'red');
					$("." + msg).html('Proses Gagal.');
				}
			}
		});
	} return false;
}

function list_tbl(id, divid) {
	jloadings();
	var dok = $("#" + id).val();
	page = $("#" + id).attr("url") + "/" + dok;
	$('#' + divid).load(page, function () {
		Clearjloadings();
		$("#" + id).val(0);
	});
};

function multiReplace(str, match, repl) {
	do {
		str = str.replace(match, repl);
	} while (str.indexOf(match) !== -1);
	return str;
}

function FormatHS(varnohs) {
	if (varnohs != "") {
		varnohs = multiReplace(varnohs, '.', '');
		var varresult = '';
		var varresult = varnohs.substr(0, 4) + "." + varnohs.substr(4, 2) + "." + varnohs.substr(6, 2) + "." + varnohs.substr(8, 2);
		return varresult;
	}
}

function getDataCombo(form, val, get) {
	var getVal = $("#" + form + " #" + val).val();
	$("#" + form + " #" + get).val(getVal);
}

function limitChars(textid, limit, infodiv) {
	var text = $('#' + textid).val();
	var textlength = text.length;
	if (textlength > limit) {
		$('#' + infodiv).html('<font color="red">Tidak bisa lebih dari ' + limit + ' karakter!</font>');
		$('#' + textid).val(text.substr(0, limit));
		return false;
	}
	else {
		$('#' + infodiv).html('<font color="green">' + (limit - textlength) + ' karakter yang tersisa.</font>');
		return true;
	}
}

function intInput(event, keyRE) {
	if (String.fromCharCode(((navigator.appVersion.indexOf('MSIE') != (-1)) ? event.keyCode : event.charCode)).search(keyRE) != (-1)
		|| (navigator.appVersion.indexOf('MSIE') == (-1)
			&& (event.keyCode.toString().search(/^(8|9|13|45|46|35|36|37|39)$/) != (-1)
				|| event.ctrlKey || event.metaKey))) {
		return true;
	} else {
		return false;
	}
}

function autocomplete(divid, url, source) {
	$("#" + divid).autocomplete({
		minLength: 1,
		delay: 0,
		autofocus: true,
		source: function (request, response) {
			$.ajax({
				type: "POST",
				url: site_url + url,
				data: request,
				success: response,
				dataType: 'json'
			});
		},
		select: source
	});
}

function strpos(haystack, needle, offset) {
	var i = (haystack + '').indexOf(needle, (offset || 0));
	return i === -1 ? false : i;
}

function check(id, input) {
	var check = new Array();
	$.each($("input[id='" + id + "']:checked"), function () {
		check.push($(this).val());
	});
	$('#' + input).val(check);
}

function date(className) {
	$("." + className).datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd',
		autoclose: true,
		changeMonth: true,
    	changeYear: true
	});
}

function datetime(className) {
	$('.' + className).datepicker({
		format: "dd-mm-yyyy hh:ii:ss",
		todayBtn: false,
		todayHighlight: true,
		autoclose: true
	});
}

function time(className) {
	$('.' + className).timepicker({
		showMeridian: false
	});
}

function on_detail(id, div, act) {
	var url = site_url + '/' + act + '/' + Math.random();
	$.post(url, { id: id },
		function (data) {
			$('#' + div).html(data);
		}, "html");
}

function Loading(boolean) {
	if (boolean) {
		LoadingOpen();
	}
	else {
		LoadingClose();
	}
}

/*using by function ThausandSeperator!!*/
function removeCharacter(v, ch) {
	var tempValue = v + "";
	var becontinue = true;
	while (becontinue == true) {
		var point = tempValue.indexOf(ch);
		if (point >= 0) {
			var myLen = tempValue.length;
			tempValue = tempValue.substr(0, point) + tempValue.substr(point + 1, myLen);
			becontinue = true;
		} else {
			becontinue = false;
		}
	}
	return tempValue;
}
function characterControl(value) {
	var tempValue = "";
	var len = value.length;
	for (i = 0; i < len; i++) {
		var chr = value.substr(i, 1);
		if ((chr < '0' || chr > '9') && chr != '.' && chr != ',') {
			chr = '';
		}
		tempValue = tempValue + chr;
	}
	return tempValue;
}
function ThausandSeperator(hidden, value, digit) {
	var thausandSepCh = ",";
	var decimalSepCh = ".";
	var tempValue = "";
	var realValue = value + "";
	var devValue = "";
	if (digit == "") digit = 0;
	realValue = characterControl(realValue);
	var comma = realValue.indexOf(decimalSepCh);
	if (comma != -1) {
		tempValue = realValue.substr(0, comma);
		devValue = realValue.substr(comma);
		devValue = removeCharacter(devValue, thausandSepCh);
		devValue = removeCharacter(devValue, decimalSepCh);
		devValue = decimalSepCh + devValue;
		if (devValue.length > digit) {
			devValue = devValue.substr(0, digit + 1);
		}
	} else {
		tempValue = realValue;
	}
	tempValue = removeCharacter(tempValue, thausandSepCh);
	var result = "";
	var len = tempValue.length;
	while (len > 3) {
		result = thausandSepCh + tempValue.substr(len - 3, 3) + result;
		len -= 3;
	}
	result = tempValue.substr(0, len) + result;
	if (hidden != "") {
		$("#" + hidden).val(tempValue + devValue);
	}
	return result + devValue;
}

function menucheckAll(formid) {
	if ($("#checkAllmenu").attr('checked') == "checked") var checked = "checked";
	else checked = false;
	$("#" + formid).find(':checkbox').attr('checked', checked);
}
function menucheckParent(formid, id) {
	if ($("#checkmenuParent_" + id).attr('checked') == "checked") var checked = true;
	else checked = false;
	$("#" + formid + ' #checkmenuChild_' + id).attr('checked', checked);
}
function menucheckChild(formid, id) {
	var numchecked = 0;
	$(".checkmenuChild_" + id).each(function (index, element) {
		if ($(this).attr('checked') == 'checked') {
			numchecked++;
		}
	});
	if (numchecked > 0) {
		$("#" + formid).find('#checkmenuParent_' + id).attr('checked', true);
	} else {
		$("#" + formid).find('#checkmenuParent_' + id).attr('checked', false);
	}
}

$('.add-warehouse').on('click', function () {
	var $tableBody = $('.tbl-warehouse').find("tbody");
	var $rowCount = $('.tbl-warehouse tbody tr').length;
	var $optCount = $(".tbl-warehouse .tr_first option").size() - 1;

	if (($rowCount + 1) <= $optCount) {
		$trLast = $tableBody.find("tr:last");
		$trNew = $trLast.clone();
		$trNew.attr('class', ($rowCount + 1));
		$trNew.find('select').removeAttr('id').attr('id', ($rowCount + 1));
		$trNew.find('a').removeClass('btn-success add-warehouse').addClass('btn-danger');
		$trNew.find('a').attr('onclick', 'delete_row(\'' + ($rowCount + 1) + '\')');
		$trNew.find('a i').removeClass('fa-plus').addClass('fa-times');

		$trLast.after($trNew);
	}
	return false;
});

function delete_row(id) {
	$('.tbl-warehouse .' + id).remove();
}

function prosesproduksi(url, act, id, tipe) {
	var data = {
		id_barang: $('#id_barang' + id).val(),
		jml_satuan: $('#jml_satuan' + id).val(),
		id_gudang: $('#id_gudang' + id).val(),
		kd_satuan: $('#kd_satuan' + id).val(),
		keterangan: $('#keterangan' + id).val()
	};
	if (act == "add") {
		jpopup(site_url + "/" + url + "/" + act + '/' + tipe, applicationName, data, '', '');
	} else {
		jpopup(site_url + "/" + url + "/" + act + '/' + id + '/' + tipe, applicationName, data, '', '');
	}
}

function GetRandomMath() {
	var Mathrandom = Math.floor(Math.random() * 1001);
	return Mathrandom;
}

function save_produksi(formid, id, tipe) {
	if (validasi(formid)) {
		var detil = "";
		var nilai = $(".tbl-produksi tbody tr").size();
		var Mathrandom = GetRandomMath();
		detil = "<tr id=\"tr_dtl" + Mathrandom + "\" onmouseover=\"$(this).addClass('hilite');\" onmouseout=\"$(this).removeClass('hilite');\"><td class=\"alt\"><span class=\"nop\">" + nilai + "</span></td><td class=\"alt\">" + $("#" + formid + " #kd_brg").val() + "</td><td class=\"alt\">" + $("#" + formid + " #uraian_barang").val() + "</td><td class=\"alt\">" + $("#" + formid + " #jns_brg").val() + "</td><td class=\"alt\">" + $("#" + formid + " #jml_satuan").val() + "</td><td class=\"alt\">" + $("#" + formid + " #kd_satuan").val() + "</td><td class=\"alt\">" + $("#" + formid + " #ur_warehouse").val() + "</td><td class=\"alt\">" + $("#" + formid + " #keterangan").val() + "</td><td class=\"alt\"><a href=\"javascript:void(0);\" class=\"btn btn-success btn-sm\" onclick=\"prosesproduksi('produksi/details','edit','" + Mathrandom + "','" + tipe + "')\"><i class=\"fa fa-pencil\"></i></a>&nbsp;<a href=\"javascript:void(0);\" class=\"btn btn-orange btn-sm\" onclick=\"remove_produksi(" + Mathrandom + ")\"><i class=\"glyphicon glyphicon-trash\"></i></a><input type=\"hidden\" name=\"DETIL[id_barang][]\" id=\"id_barang" + Mathrandom + "\" value=\"" + $("#" + formid + " #id_barang").val() + "\"><input type=\"hidden\" name=\"DETIL[jml_satuan][]\" id=\"jml_satuan" + Mathrandom + "\" value=\"" + $("#" + formid + " #jml_satuan").val() + "\" /><input type=\"hidden\" name=\"DETIL[kd_satuan][]\" id=\"kd_satuan" + Mathrandom + "\" value=\"" + $("#" + formid + " #kd_satuan").val() + "\" /><input type=\"hidden\" name=\"DETIL[id_gudang][]\" id=\"id_gudang" + Mathrandom + "\" value=\"" + $("#" + formid + " #id_warehouse").val() + "\"/><input type=\"hidden\" name=\"DETIL[keterangan][]\" id=\"keterangan" + Mathrandom + "\" value=\"" + $("#" + formid + " #keterangan").attr("value") + "\"/></td></tr>";

		if (id) {
			$(".tbl-produksi tbody #tr_dtl" + id).replaceWith(detil);
			$(".tbl-produksi tbody tr .nop").each(function (index, element) {
				$(this).html(parseFloat(index) + 1);
			});
			notify('Data berhasil dirubah.', 'success');
			setTimeout(function () {
				close_popup('1');
			}, 2000);
		} else {
			if (nilai == 1) {
				$("#tr_detil").remove();
				$(".tbl-produksi tbody:first").append(detil);
			} else {
				$(".tbl-produksi tbody:first").append(detil);
			}
			$(".tbl-produksi tbody tr .nop").each(function (index, element) {
				$(this).html(parseFloat(index) + 1);
			});
			notify('Data berhasil ditambahkan.', 'success');
			setTimeout(function () {
				close_popup('1');
			}, 2000);
		}
	}
}

function remove_produksi(id) {
	$(".tbl-produksi tr[id=tr_dtl" + id + "]").remove();
	var nilai = $(".tbl-produksi tbody tr").size();
	if (nilai == 0) {
		$("#tr_hdr").remove();
		var content = '<tr id="tr_detil"><td align="center" style="background:#FFFFFF" colspan="8">Data Tidak Ditemukan</td></tr>';
		$(".tbl-produksi tbody:first").append(content);
	}
	$(".tbl-produksi tbody tr .nop").each(function (index, element) {
		$(this).html(parseFloat(index) + 1);
	});
}

function mutasi(form) {
	$(".table-laporan").html('');
	$("#" + form + " .btn-search").html('<img src="' + base_url + 'assets/images/loaders/loader1.gif" alt="">&nbsp;Loading...');
	$.ajax({
		type: 'POST',
		url: $('[name="' + form + '"]').attr('action'),
		data: $('[name="' + form + '"]').serialize(),
		success: function (data) {
			$("#" + form + " .btn-search").html('Search');
			$(".table-laporan").html(data);
			$("#" + form + " .btn-search").html('<i class="fa fa-search"></i>&nbsp;Search');
		}
	});
}
/*--*/