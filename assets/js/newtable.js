var applicationName = "INVENT 1";
function button_menu(formid, id) {
	var checked = false;
	var url = "";
	var jml = "";
	var met = "";
	var w = "";
	var popup = "";
	var idget = "";
	var getid = "";
	var tb_chk = ""
	chk = $(".tb_chk" + formid + ":checked").length;
	url = $("#" + id).attr('url');
	jml = $("#" + id).attr('jml');
	met = $("#" + id).attr('met');
	div = $("#" + id).attr('div');
	w = $("#" + id).attr('w');
	status = $("#" + id).attr('status');
	popup = $("#" + id).attr('popup');
	idget = $("#" + id).attr('get');
	if (idget != "") getid = $('#' + idget).val();
	if (w == "") w = 60;
	if (url == "") return false;
	if ($("#" + formid + " input:checkbox").serialize()) {
		tb_chk = $("#" + formid + " input:checkbox").serialize();
	} else {
		tb_chk = $("#" + formid + " input:radio").serialize();
	}
	if (chk == 0 && jml != 0) {
		swalert('error', 'Maaf, Data belum dipilih');
		return false;
	}
	if (jml == '1' && chk > 1) {
		swalert('error', 'Pilih salah satu data');
		$("#tb_menu" + formid).val(0);
		return false;
	}
	if (status != "") {
		var valid = $(".tb_chk" + formid + ":checked").attr('validasi');
		if (status == "NOT-NULL") {
			if (valid != "") {
				swalert('error', 'Maaf, Data tidak dapat diproses');
				return false;
			}
		} else {
			var arrstatus = new Array();
			arrstatus = status.split(':');
			if (!inArray(valid, arrstatus)) {
				swalert('error', 'Maaf, Data tidak dapat diproses');
				return false;
			}
		}
	}
	if (met == "GET") {
		var val = $(".tb_chk" + formid + ":checked").val();
		$("#div" + met).remove();
		c_div('#div' + met, '<form name="frm' + formid + '" id="frm' + formid + '"></form>');
		var myform = document.forms['frm' + formid];
		myform.method = 'POST';
		myform.action = url;
		add_hidden(myform, 'action', 'update');
		add_hidden(myform, 'generate', 'formjs');
		add_hidden(myform, 'arrpost', val);
		add_hidden(myform, 'id', val);
		myform.submit();
		if (popup != "") {
			close_popup(popup);
		}
		return false;
	} else if (met == "PREVIEW") {
		jConfirm('Do you want to process data ?', applicationName,
			function (r) {
				if (r == true) {
					if (jml == '0')
						location.href = url;
					else
						location.href = url + '/' + $(".tb_chk" + formid + ":checked").val();
				} else { return false; }
			});
	} else if (met == "POST") {
		swal({
			title: applicationName,
			text: 'Apakah ingin proses data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true
		}, function (r) {
			if (r) {
				$.ajax({
					type: 'POST',
					url: site_url + '/' + url,
					data: tb_chk,
					dataType: "json",
					beforeSend: function () { Loading(true) },
					complete: function () { Loading(false) },
					success: function (result) {
						var format = JSON.stringify(result);
						var data = JSON.parse(format);

						if (Object.keys(data).length > 0) {
							if (data.status == "success") {
								notify(data.message, 'success');
								setTimeout(function () {
									$('#' + div).load(data._url);
								}, 2000);
							} else {
								notify(data.message, 'error');
								return false;
							}
						}
					}
				}).responseJSON;
			} else {
				return false
			}
		});
	} else if (met == "POST_POPUP") {
		swal({
			title: applicationName,
			text: 'Apakah ingin proses data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true
		}, function (r) {
			if (r) {
				var val = $("#" + formid + " input:checkbox").serialize()
				$.ajax({
					type: 'POST',
					url: url,
					data: val,
					beforeSend: function () { Loading(true) },
					complete: function () { Loading(false) },
					success: function (data) {
						if (data.search("MSG") >= 0) {
							arrdata = data.split('#');
							if (arrdata[1] == "OK") {
								if (pop_type != "") {
									if (pop_type == "2") {
										jpopup_closetwo();
									} else {
										jpopup_close();
									}
								}
								notify('success', arrdata[2]);
								var div = arrdata[3].split('~');
								$('#' + div[0]).load(div[1]);
							} else {
								notify('error', arrdata[2]);
								return false;
							}
						}
					}
				});
			} else {
				return false
			}
		});
	} else if (met == "ADD") {
		location.href = url;
	} else if (met == "MODAL") {
		if (jml == 1) {
			var val = $(".tb_chk" + formid + ":checked").val();
			popup_search(url, 'id=' + val, w, 600);
		} else {
			popup_search(url, '', w, 600);
		}
	} else if (met == "EDIT") {
		var val = $(".tb_chk" + formid + ":checked").val().toLowerCase().split("~");
		if (typeof (val[1]) == 'undefined') {
			location.href = url + '/' + val[0];
		}
		else {
			location.href = url + '/' + val[0] + '/' + val[1];
		}
	} else if (met == "EDIT_MODAL_AJAX") {
		$.ajax({
			type: 'POST',
			dataType: "json",
			url: site_url + '/' + url,
			data: tb_chk,
			success: function (result) {
				var format = JSON.stringify(result);
				var data = JSON.parse(format);
				if (Object.keys(data).length > 0) {
					if (data.status == "success") {
						popup_search(url, 'id=' + data.id, w, 600);
					} else {
						swalert('error', data.message);
						return false;
					}
				}
			}
		}).responseJSON;
	} else if (met == "EDIT_AJAX") {
		swal({
			title: applicationName,
			text: 'Do you want to edit data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true,
		}, function (r) {
			if (r == true) {
				$.ajax({
					type: 'POST',
					dataType: "json",
					url: url,
					data: tb_chk,
					success: function (result) {
						var format = JSON.stringify(result);
						var data = JSON.parse(format);
						if (Object.keys(data).length > 0) {
							if (data.status == "success") {
								var val = $(".tb_chk" + formid + ":checked").val();
								$("#div" + met).remove();
								c_div('#div' + met, '<form name="frm' + formid + '" id="frm' + formid + '"></form>');
								var myform = document.forms['frm' + formid];
								myform.method = 'POST';
								myform.action = url;
								add_hidden(myform, 'action', 'update');
								add_hidden(myform, 'generate', 'formjs');
								add_hidden(myform, 'arrpost', val);
								add_hidden(myform, 'id', val);
								myform.submit();
								return false;
							} else {
								swalert('error', data.message);
								return false;
							}
						}
					}
				}).responseJSON();
			} else {
				return false;
			}
		});
	} else if (met == "GET_POST") {
		swal({
			title: applicationName,
			text: 'Apakah ingin proses data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true
		}, function (r) {
			if (r) {
				var val = $("#" + formid + " input:checkbox").serialize();
				$.ajax({
					type: 'POST',
					url: url,
					data: val,
					beforeSend: function () { Loading(true) },
					success: function (data) {
						Loading(false);
						if (data.search("MSG") >= 0) {
							arrdata = data.split('#');
							if (arrdata[1] == "OK") {
								notify('success', arrdata[2]);
								setTimeout(function () { location.href = arrdata[3]; }, 2000);
							} else {
								notify('error', arrdata[2]);
							}
						}
						return false;
					}
				});
			} else {
				return false
			}
		});
	} else if (met == "OPTION") {
		// var val = $("#" + formid + " input:checkbox").serialize();
		$.ajax({
			type: 'POST',
			url: url,
			data: tb_chk,
			dataType: 'json',
			beforeSend: function () { },
			success: function (data) {
				Loading(false);
				var jumdata = data.arrfield.length;
				if (jumdata > 0) {
					for (var a = 0; a < jumdata; a++) {
						$('#' + data.arrfield[a]).val(data.arrvalue[a]);
					}
					if (data.arrajax != "") {
						get_select(data.arrajax, data.arrvalue[0]);
					}
					if (popup != "") {
						close_popup(popup);
					}
				}
				else {
					jAlert('Maaf, Data gagal dipilih', applicationName);
					return false;
				}
			}
		});
	} else if (met == "PRINT") {
		var val = $(".tb_chk" + formid + ":checked").val();
		$("#div" + met).remove();
		c_div('#div' + met, '<form name="frm' + formid + '" id="frm' + formid + '"></form>');
		var myform = document.forms['frm' + formid];
		myform.method = 'POST';
		myform.action = site_url + '/' + url;
		myform.target = '_blank';
		add_hidden(myform, 'action', 'update');
		add_hidden(myform, 'generate', 'formjs');
		add_hidden(myform, 'arrpost', val);
		add_hidden(myform, 'id', val);
		myform.submit();
		return false;
	} else if (met == "PRINTPREVIEW") {
		jConfirm('Apakah anda ingin proses print preview data ?', applicationName,
			function (r) {
				if (r == true) {
					var id = $(".tb_chk" + formid + ":checked").val();
					if (id != "") {
						popup_search(url + '/' + id, id, w, 600);
					}
				} else { return false; }
			});
	} else if (met == "POPUP") {
		var val = $(".tb_chk" + formid + ":checked").val();
		popup_search(url + '/' + val[0], 'id=' + val[0], w, 600);
	} else if (met == "VIEW") {
		jConfirm('Apakah anda ingin proses preview data ?', applicationName,
			function (r) {
				if (r == true) {
					var id = $(".tb_chk" + formid + ":checked").val();
					popup_search(url + '/' + id, id, w, 600);
				} else { return false; }
			});
	} else if (met == "GET_MODAL_AJAX") {//alert ('asaa');
		jConfirm('Do you want to process data ?', applicationName,
			function (r) {
				if (r == true) {
					$.ajax({
						type: 'POST',
						url: site_url + '/' + url,
						data: $("#" + formid + " input:checkbox").serialize(),
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "OK") {
									var val = $(".tb_chk" + formid + ":checked").val().toLowerCase().split(".");
									popup_search(url + '/' + arrdata[2], 'id=' + val[0], w, 600);
								} else {
									notify('error', arrdata[2]);
									return false;
								}
							}
						}
					});
				} else { return false; }
			});
	} else if (met == "EXCEL") {
		swal({
			title: applicationName,
			text: 'Apakah ingin proses data ?',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: true,
			showLoaderOnConfirm: true
		}, function (r) {
			if (r) {
				var val = $("#" + formid).serialize();
				$.ajax({
					type: 'POST',
					url: site_url + '/' + url,
					data: val,
					dataType: 'json',
					beforeSend: function () { Loading(true) },
					complete: function () { Loading(false) },
					success: function (data) {
						window.open(base_url + '/' + data.path, '_blank');
						return false;
					}
				});
			} else {
				return false
			}
		});
	}
	//$("#tb_menu"+formid).val(0);
	return false;

}

function tb_menu(formid) {
	var checked = false;
	var url = "";
	var jml = "";
	var met = "";
	isi = $("#tb_menu" + formid).val()
	chk = $(".tb_chk" + formid + ":checked").length;
	$("#tb_menu" + formid + " option").each(function () {
		if ($(this).text() == isi) {
			url = $(this).attr('url');
			jml = $(this).attr('jml');
			met = $(this).attr('met');
			div = $(this).attr('div');
		}
	});
	if (url == "") return false;
	if (chk == 0 && jml != '0') {
		jAlert('Maaf, Data Belum Dipilih');
		$("#tb_menu" + formid).val(0);
		return false;
	}
	if (jml == '1' && chk > 1) {
		jAlert('Maaf, Data yang bisa diproses hanya 1 (satu)');
		$("#tb_menu" + formid).val(0);
		return false;
	}
	if (met == "GET") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					if (jml == '0')
						location.href = url;
					else
						location.href = url + '/' + $(".tb_chk" + formid + ":checked").val();
				} else { return false; }
			});
	} else if (met == "GET2") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					if (jml == '0') {
						location.href = url;
					} else {
						var val = $(".tb_chk" + formid + ":checked").val().toLowerCase().split(".");
						if (typeof (val[1]) == 'undefined')
							location.href = url + '/' + val[0];
						else
							location.href = url + '/' + val[0] + '/' + val[1];
					}
				} else { return false; }
			});
	} else if (met == "GETNEW") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					if (jml == '0')
						window.open(url, '_blank')
					else
						window.open(url + '/' + $(".tb_chk" + formid + ":checked").val(), '_blank');
				} else { return false; }
			});
	} else if (met == "GETPOP") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					if (jml == '0')
						window.open(url, '_new')
					else
						window.open(url + '/' + $(".tb_chk" + formid + ":checked").val(), '_new');
				} else { return false; }
			});
	} else if (met == "POST") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					$('#labelload' + formid).fadeIn('Slow');
					$.ajax({
						type: 'POST',
						url: url,
						data: $('#' + formid).serialize(),
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('MSG#');
								arrdata = arrdata[1].split('#');
								jAlert(arrdata[0]);
								if (arrdata.length > 1) location.href = arrdata[1];
							} else {
								jAlert('Proses Gagal.');
							}
							$('#labelload' + formid).fadeOut('Slow');
						}
					});
				} else { return false; }
			});
	} else if (met == "ADDS") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					$('#labelload' + formid).fadeIn('Slow');//alert(jml);return false;
					$.ajax({
						type: 'POST',
						url: url,
						data: 'edit=add',
						success: function (data) {
							$("#" + formid + "_form").html(data);
							$('#labelload' + formid).fadeOut('Slow');
						}
					});
				} else { return false; }
			});
	} else if (met == "EDIT") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					var val = $("#" + formid + " input:checkbox").serialize()
					$('#labelload' + formid).fadeIn('Slow');
					$.ajax({
						type: 'POST',
						url: url,
						data: val + '&edit=edit',
						success: function (data) {
							$("#" + formid + "_form").html(data);
							$('#labelload' + formid).fadeOut('Slow');
						}
					});
				} else { return false; }
			});
	} else if (met == "ADD") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					$('#labelload' + formid).fadeIn('Slow');
					$.ajax({
						type: 'POST',
						url: url,
						data: 'edit=add',
						success: function (data) {
							$("#" + formid + "_form").html(data);
							$('#labelload' + formid).fadeOut('Slow');
						}
					});
				} else { return false; }
			});
	} else if (met == "DEL") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					var val = $("#" + formid + " input:checkbox").serialize()
					$('#labelload' + formid).fadeIn('Slow');
					$.ajax({
						type: 'POST',
						url: url,
						data: val + '&edit=del&act=delete',
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "OK") {
									$('#labelload' + formid).css('color', 'green');
									$('#labelload' + formid).html(arrdata[2]);
									if (div == 'divskep' || div == 'divproduksi') {
										$("#spanview").load(arrdata[3]);
									} else {
										$('#' + formid + "_list").load(arrdata[3]);
									}
								} else {
									$('#labelload' + formid).css('color', 'red');
									$('#labelload' + formid).html(arrdata[2]);
								}
							} else {
								$('#labelload' + formid).css('color', 'red');
								$('#labelload' + formid).html('Proses Gagal.');
							}
							$('#labelload' + formid).fadeOut('Slow');
						}
					});
				} else { return false; }
			});
	} else if (met == "DELETE") {
		jConfirm('Anda yakin akan menghapus data ini?', applicationName,
			function (r) {
				if (r == true) {
					var val = $("#" + formid + " input:checkbox").serialize()
					$.ajax({
						type: 'POST',
						url: url,
						data: val + '&edit=del&act=delete',
						beforeSend: function () { Loading(true) },
						complete: function () { Loading(false) },
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "OK") {
									$('#' + div).load(arrdata[3]);
								} else {
									jAlert(arrdata[2], applicationName);
								}
							} else {
								jAlert("Proses gagal.", applicationName);
							}
						}
					});
				} else { return false; }
			});
	}
	else if (met == "PROCESS") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					var val = $("#" + formid + " input:checkbox").serialize()
					$.ajax({
						type: 'POST',
						url: url,
						data: val + '&act=process',
						beforeSend: function () { Loading(true) },
						complete: function () { Loading(false) },
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "OK") {
									$('#' + div).load(arrdata[3]);
								} else {
									jAlert(arrdata[2], applicationName);
								}
							} else {
								jAlert("Proses gagal.", applicationName);
							}
						}
					});
				} else { return false; }
			});
	}
	else if (met == "COPY") {
		jConfirm('Proses data terpilih sekarang?', applicationName,
			function (r) {
				if (r == true) {
					$('#labelload' + formid).fadeIn('Slow');
					var val = $(".tb_chk" + formid + ":checked").val();
					$.ajax({
						type: 'POST',
						url: url,
						data: "data=" + val,
						success: function (data) {
							if (data.search("MSG") >= 0) {
								arrdata = data.split('#');
								if (arrdata[1] == "OK") {
									$('#labelload' + formid).css('color', 'green');
									$('#labelload' + formid).html(arrdata[2]);
								} else {
									$('#labelload' + formid).css('color', 'red');
									$('#labelload' + formid).html(arrdata[2]);
								}
								if (arrdata.length > 3) {
									setTimeout(function () { location.href = arrdata[3]; }, 2000);
									return false;
								}
							} else {
								$('#labelload' + formid).css('color', 'red');
								$('#labelload' + formid).html('Proses Gagal.');
							}
						}
					});
				} else { return false; }
			});
	}
	$("#tb_menu" + formid).val(0);
	return false;
}

function tb_chkall(formid, status) {
	var valtemp = $('#tmpchk' + formid).val();
	$('#newtr').remove();
	if (status == false) {
		$("#" + formid + " input:checkbox:not(#tb_chkall" + formid + ")").parent().parent().removeClass("selected");
		$('input[id^="tb_chk' + formid + '"]').prop("checked", false);
	} else {
		$("#" + formid + " input:checkbox:not(#tb_chkall" + formid + ")").parent().parent().addClass("selected");
		$('input[id^="tb_chk' + formid + '"]').prop("checked", true);
	}
	if (status == true) {
		$('input[id^="tb_chk' + formid + '"]').each(function (i) {
			if (strpos(valtemp, $(this).val()) === false) {
				$('#tmpchk' + formid).val($(this).val() + "*" + $('#tmpchk' + formid).val());
			}
		});
	} else {
		$('input[id^="tb_chk' + formid + '"]').each(function (i) {
			$('#tmpchk' + formid).val($('#tmpchk' + formid).val().replace($(this).val() + '*', ''));
		});
	}
}

function strpos(haystack, needle, offset) {
	var i = (haystack + '').indexOf(needle, (offset || 0));
	return i === -1 ? false : i;
}

function tmp_chk(formid, status, id) {
	var valtemp = $('#tmpchk' + formid).val();
	if (status == true) {
		if (strpos(valtemp, id) === false) {
			$('#tmpchk' + formid).val(id + "*" + $('#tmpchk' + formid).val());
		}
	} else {
		$('#tmpchk' + formid).val($('#tmpchk' + formid).val().replace(id + '*', ''));
	}
}

function tb_chk(formid, status, id) {
	$('input:not(:checked)').parent().parent().removeClass("selected");
	$('input:checked').parent().parent().addClass("selected");
	tmp_chk(formid, status, id);
}

function tr_chk(formid, data) {
	//$(':checkbox', data).trigger('click');
}

function tb_hals(formid, id) {
	form = $("#tb_menu" + formid).attr('formid');
	newhal = $(id).val();
	newhal++;
	redirect_url(newhal, form);
	return false;
}

function td_click(id) {
	$("#detils_bawah").html('<center><img src=\"' + base_url + 'img/_indicator.gif\" alt=\"\" /><br> Loading ...</center>');
	$.ajax({
		type: 'POST',
		url: $(".table #bawah").attr('urldetil') + "/" + id,
		data: 'ajax=1',
		success: function (html) {
			$("#detils_bawah").html(html);
		}
	});
}

function redirect_url(newhal, formid) {
	newlocation = $("#" + formid).attr('action') + '/row/' + $("#tb_view").val() + '/page/' + newhal + '/order/' + $("#orderby").val() + '/' + $("#sortby").val();
	if ($("#tb_cari").val() != "") newlocation += '/search/' + $("#tb_keycari").val() + '/' + $("#tb_cari").val().replace('/', '');
	location.href = newlocation;
}

function newtable_search(form, div, page, sortby, orderby, toggle) {
	$.ajax({
		type: 'POST',
		url: $("#" + form).attr("action"),
		data: 'ajax=1&page=' + page + '&orderby=' + orderby + '&sortby=' + sortby + '&' + $("#" + form).serialize(),
		beforeSend: function () { Loading(true) },
		complete: function () { Loading(false) },
		success: function (data) {
			$('#' + div).html(data);
		}
	});
}

function td_pilih(id) {
	var arr = id.split("|");
	var formName = arr[0];
	var fIndexEdit = arr[1];
	var inputField = arr[2];
	var input = inputField.split(";");
	var val = fIndexEdit.split(";");
	for (var c = 0; c < (input.length) - 1; c++) {
		if (typeof ($("#" + input[c]).get(0)) == "undefined") {
			jAlert('<b>ERROR:\n</b>Ada Elemen Form (' + input[c] + ') yang tak terdefinisi.\nMohon periksa script codenya.');
			return false;
			break;
		}
		var tipe = $("#" + input[c]).get(0).tagName;
		if (tipe == 'INPUT') {
			$("#" + formName).find("#" + input[c]).val(val[c]);
		}
		else if (tipe == 'TEXTAREA') {
			$("#" + formName).find("#" + input[c]).attr("value", val[c])
		}
		else if (tipe == 'SELECT') {
			//$("#"+formName).find('#'+input[c]+' option:contains("'+val[c]+'")').attr('selected', true);
			$("#" + formName).find('#' + input[c]).val(val[c]);
		}
		else {
			$("#" + formName).find("#" + input[c]).html(val[c]);
		}
	}
	$("#" + input[0]).focus();
	closedialog('Dialog-dok');
}

function popup_checked(url, id, width, height, check) {
	if (status == false) {
		//jpopup(site_url+"/"+url,applicationName,id,width,height);
	}
}

function popup_search(url, id, width, height) {
	jpopup(site_url + "/" + url, applicationName, id, '', '');
	return false;
}

function popup_searchtwo(url, id, width, height) {
	jpopuptwo(site_url + "/" + url, applicationName, id, '', '');
	return false;
}

function popupid(url, id, width, height) {
	if (id != "") {
		var val = '';
		var arrID = id.split("|");
		var banyak = arrID.length;
		for (var a = 0; a < banyak; a++) {
			val += $('#' + arrID[a]).val() + '|';
		}
		var lengthid = val.length;
		valdata = val.substr(0, lengthid - 1);
	}
	jpopup(site_url + "/" + url + "/" + valdata, applicationName, id, width, height);
	return false;
}

function formCari(div) {
	$.ajax({
		type: 'POST',
		url: site_url + "/" + $("#formCari").attr("action"),
		data: 'ajax=1&' + $("#formCari").serialize(),
		beforeSend: function () { Loading(true) },
		complete: function () { Loading(false) },
		success: function (data) {
			$('#' + div).html(data);
		}
	});
}

function FormDiv(div, url, id) {
	$.ajax({
		type: 'POST',
		url: site_url + "/" + url + '/' + id,
		data: 'ajax=1&id=' + id + '&' + $("#FormDiv").serialize(),
		beforeSend: function () { Loading(true) },
		complete: function () { Loading(false) },
		success: function (data) {
			$('#' + div).html(data);
		}
	});
}

function td_detil_priview(id, thisid) {
	var obj = $(thisid).next().attr("id");
	if (obj == "newtr") {
		$('#newtr').remove();
	} else {
		if ($(thisid).attr('urldetil')) {
			if ($(thisid).attr('urldetil') != "") {
				$('#newtr').remove();
				var jmltd = $('td', $(thisid)).length;
				var addtd = '';
				if ($(".table input:checkbox").length > 0) {
					addtd = '<td></td>';
					jmltd--;
				}
				$(thisid).after('<tr id="newtr">' + addtd + '<td id="filltd" colspan="' + jmltd + '"></td></tr>');
				$('#filltd').html('<img src=\"' + base_url + 'img/loading.gif\" alt=\"\" />  Loading...');
				$('#filltd').load($(thisid).attr('urldetil'));
			}
		}
		return false;
	}
}

function add_hidden(formname, key, value) {
	var input = document.createElement('input');
	input.type = 'hidden';
	input.name = key;
	'name-as-seen-at-the-server';
	input.value = value;
	formname.appendChild(input);
}

function c_div(id, inner) {
	div = document.createElement("div");
	div.innerHTML = '<div id="' + id + '" style="display: none;">' + inner + '</div>';
	document.body.appendChild(div);
}

function get_detail(id) {
	var met = $(id).attr('type');
	var url = $(id).attr('url');
	var formid = $(id).attr('formdata');
	var val = $(id).attr('value');
	if (met == "GET") {
		$("#div" + met).remove();
		c_div('#div' + met, '<form name="frm' + formid + '" id="frm' + formid + '"></form>');
		var myform = document.forms['frm' + formid];
		myform.method = 'POST';
		myform.action = url;
		add_hidden(myform, 'action', 'update');
		add_hidden(myform, 'generate', 'formjs');
		add_hidden(myform, 'arrpost', val);
		add_hidden(myform, 'id', val);
		myform.submit();
		return false;
	} else if (met == "POPUP") {
		popup_search($(id).attr('url'), 'id=' + val, 80, 600);
	}
}

function get_select(param, id) {
	if (param != "") {
		var arrdata = param.split("|");
		var div = arrdata[0];
		var url = arrdata[1];
		$.ajax({
			type: "POST",
			url: site_url + '/' + url,
			data: 'ajax=1&id=' + id,
			beforeSend: function () { Loading(true) },
			complete: function () { Loading(false) },
			success: function (data) {
				$("#" + div).html(data);
			}
		});
	}
	return false;
}

function inArray(needle, haystack) {
	var length = haystack.length;
	for (var i = 0; i < length; i++) {
		if (haystack[i] == needle) return true;
	}
	return false;
}

function td_detil_priview_bottom(id,thisid){ 
	if ($(thisid).attr('btnname')=="expand") {
		if($(thisid).attr('title')=='Expand'){
			$(thisid).attr('title','Collapse');$(thisid).attr('src',base_url+'assets/images/nolines_minus.gif');	
		}else{			
			$(thisid).attr('title','Expand');$(thisid).attr('src',base_url+'assets/images/nolines_plus.gif');	
		}
	    thisid = "#"+$(thisid).parent().parent().attr('id');
	} else {
		if($(thisid).find('img').attr('title')=='Expand'){
			$(thisid).find('img').attr('title','Collapse');$(thisid).find('img').attr('src',base_url+'assets/images/nolines_minus.gif');	
		}else{			
			$(thisid).find('img').attr('title','Expand');$(thisid).find('img').attr('src',base_url+'assets/images/nolines_plus.gif');	
		}
	}
	$("tr").removeClass("selected");
 	$(thisid).addClass("selected");
	var obj = $(thisid).next().attr("id");	
	if(obj=="newtr"){ 
		$('#newtr').remove();	
		$(thisid).removeClass("selected");
	}else{
		if($(thisid).attr('urldetil')){
			if($(thisid).attr('urldetil')!=""){
				$('#newtr').remove();
				var jmltd = $('td', $(thisid)).length;
				$(thisid).after('<tr id="newtr"><td id="filltd" colspan="' + jmltd + '"></td></tr>');
				$('#filltd').html('Loading..');
				$('#filltd').load($(thisid).attr('urldetil')+"/ajax", {id: $(thisid).attr('value')});
			}
		}
		return false;
	}
}	
