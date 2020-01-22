(function ($) {
	$.alerts = {
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: -0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .2,                // transparency level of overlay
		overlayColor: '#000',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		CloseButton: '&nbsp;Close&nbsp;',
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		alert: function (message, title, callback) {
			if (title == null) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function (result) {
				if (callback) callback(result);
			});
		},
		confirm: function (message, title, callback) {
			if (title == null) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function (result) {
				if (callback) callback(result);
			});
		},
		prompt: function (message, value, title, callback) {
			if (title == null) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function (result) {
				if (callback) callback(result);
			});
		},
		popdialog: function (message, value, title, callback) {
			if (title == null) title = 'Alert';
			$.alerts._show(title, message, value, 'popdialog', function (result) {
				if (callback) callback(result);
			});
		},
		loading: function (message, value, title, callback) {
			if (title == null) title = 'Loading';
			$.alerts._show(title, message, value, 'loading', function (result) {
				if (callback) callback(result);
			});
		},
		_show: function (title, msg, value, type, callback) {
			$.alerts._hide();
			$.alerts._overlay('show');
			$.alerts.horizontalOffset = 0;
			$.alerts.verticalOffset = -75;
			if (type == 'loading') {
				$("BODY").append(
					'<div id="popup_container" class="dialog">' +
					'<div id="popup_content_loading">' +
					'<div id="popup_message_dialog" class="msg"></div>' +
					'</div>' +
					'</div>');
			}
			else {
				$("BODY").append(
					'<div id="popup_container">' +
					'<h1 id="popup_title"></h1>' +
					'<div id="popup_content">' +
					'<div id="popup_message"></div>' +
					'</div>' +
					'</div>');
			}
			if ($.alerts.dialogClass) $("#popup_container").addClass($.alerts.dialogClass);
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6) ? 'absolute' : 'fixed';
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html($("#popup_message").text().replace(/\n/g, '<br />'));

			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth()
			});
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			switch (type) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><button class="btn btn-small btn-primary" type="button" id="popup_ok"><i class="icon-check icon-white"></i>' + $.alerts.okButton + '</button></div>');
					$("#popup_ok").click(function () {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress(function (e) {
						if (e.keyCode == 13 || e.keyCode == 27) $("#popup_ok").trigger('click');
					});
					break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><button class="btn btn-small btn-primary" type="button" id="popup_ok"><i class="icon-check icon-white"></i>' + $.alerts.okButton + '</button>&nbsp;<button class="btn btn-small btn-danger" type="button" id="popup_cancel"><i class="icon-white icon-remove"></i>' + $.alerts.cancelButton + '</button></div>');
					$("#popup_ok").click(function () {
						$.alerts._hide();
						if (callback) callback(true);
					});
					$("#popup_cancel").click(function () {
						$.alerts._hide();
						if (callback) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress(function (e) {
						if (e.keyCode == 13) $("#popup_ok").trigger('click');
						if (e.keyCode == 27) $("#popup_cancel").trigger('click');
					});
					break;
				case 'prompt':
					$("#popup_message").append('<input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width($("#popup_message").width());
					$("#popup_ok").click(function () {
						var val = $("#popup_prompt").val();
						$.alerts._hide();
						if (callback) callback(val);
					});
					$("#popup_cancel").click(function () {
						$.alerts._hide();
						if (callback) callback(null);
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress(function (e) {
						if (e.keyCode == 13) $("#popup_ok").trigger('click');
						if (e.keyCode == 27) $("#popup_cancel").trigger('click');
					});
					if (value) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
					break;
				case 'popdialog':
					$("#popup_message_dialog").html('<img src=\"' + base_url + 'assets/images/loading.gif\"  alt=\"Loading...\" /><br> Loading...');
					$.ajax({
						url: msg,
						data: value,
						success: function (html) {
							$("#popup_message_dialog").html(html);
						}
					});
					$("#popup_message_dialog").after('<div id="popup_panel"><button class="btn btn-small btn-primary" type="button" id="popup_ok"><i class="icon-check icon-white"></i>' + $.alerts.CloseButton + '</button></div>');
					$("#popup_ok").click(function () {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress(function (e) {
						if (e.keyCode == 13 || e.keyCode == 27) $("#popup_ok").trigger('click');
					});
					break;
				case 'loading':
					$("#popup_message_dialog").html('<img src=\"' + base_url + 'assets/images/loading.gif\" alt=\"Loading...\" />');
					break;
				case 'popup':
					$("#popup_content_popup").after('<div id="popup_panel_popup"><button type="button" class="btn btn-small btn-primary" id="popup_close"><span class="cross icon"></span>Close</button></div>');
					$("#popup_close").click(function () {
						$.alerts._hide();
						callback(true);
					});
					break;
			}
			// Make draggable
			if ($.alerts.draggable) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch (e) { /* requires jQuery UI draggables */ }
			}
		},
		_showPopup: function (title, msg, value, type, callback, data, width, height) {
			var add = "Loading...";
			$.alerts._hidePopup();
			$.alerts._overlayPopup('show');
			$.alerts.horizontalOffset = 0;
			$.alerts.verticalOffset = -160;
			$.alerts.draggable = true;
			var heightContent = parseInt(height) - 89;
			var body_append = '';
			body_append = '<div id="popup_container_popup" class="modal fade modal-primary in" style="width:auto" aria-hidden="false" role="dialog" tabindex="-1">';
			body_append += '<div class="modal-dialog">';
			body_append += '	<div class="modal-content">';
			body_append += '		<div class="modal-header">';
			body_append += '			<button type="button" class="close" id="popup_close_popup"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>';
			body_append += '			<h4 class="modal-title" id="popup_title_popup"></h4>';
			body_append += '		</div>';
			body_append += '		<div class="modal-body" id="popup_content_popup"></div>';
			body_append += '	</div>';
			body_append += '</div>';
			$("BODY").append(body_append);
			$('#popup_container_popup').fadeIn('fast');
			$.ajax({
				url: msg,
				type: 'POST',
				data: data,
				beforeSend: function () {
					$("#popup_content_popup").html('<div style="text-align:center;"><img src="' + base_url + 'assets/images/loading.gif" alt="Loading" /><br><b>PLEASE WAIT ...</b></div>');
				},
				success: function (html) {
					$("#popup_content_popup").html(html);
					$("BODY").css({
						overflow: 'visible'
					});
				}
			});

			if ($.alerts.dialogClass) $("#popup_container_popup").addClass($.alerts.dialogClass);
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6) ? 'absolute' : 'fixed';
			$("#popup_container_popup").css({
				position: pos,
				zIndex: 9991,
				padding: 0,
				margin: 0
			});
			$("#popup_content_popup").css({
				overflow: 'auto',
				height: heightContent + 'px',
			});
			$("#popup_title_popup").text(title);
			$("#popup_message_popup").text(msg);
			$("#popup_message_popup").html($("#popup_message_popup").text().replace(/\n/g, '<br />'));
			$("#popup_container_popup").css({
				//minWidth: $("#popup_container_popup").outerWidth(),
				//maxWidth: $("#popup_container_popup").outerWidth()
			});
			$.alerts._repositionPopup();
			$.alerts._maintainPosition(true);
			$("#popup_close_popup").click(function () {
				$('#popup_container_popup').fadeOut('fast',
					function () {
						$.alerts._hidePopup();
					});
				callback(true);
			});
			// Make draggable
			if ($.alerts.draggable) {
				try {
					$("#popup_container_popup").draggable({ handle: $("#popup_title_popup") });
					$("#popup_title_popup").css({ cursor: 'move' });
				} catch (e) { /* requires jQuery UI draggables */ }
			}
		},
		_showPopupTwo: function (title, msg, value, type, callback, data, width, height) {
			var add = "Loading...";
			$.alerts._hidePopupTwo();
			$.alerts._overlayPopupTwo('show');
			$.alerts.horizontalOffset = 0;
			$.alerts.verticalOffset = -160;
			$.alerts.draggable = true;
			var heightContent = parseInt(height) - 89;
			var body_append = '';
			body_append = '<div id="popup_container_popup_two" class="modal fade modal-primary in" style="width:auto" aria-hidden="false" role="dialog" tabindex="-1">';
			body_append += '<div class="modal-dialog">';
			body_append += '	<div class="modal-content">';
			body_append += '		<div class="modal-header">';
			body_append += '			<button type="button" class="close" id="popup_close_popup_two"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>';
			body_append += '			<h4 class="modal-title" id="popup_title_popup_two"></h4>';
			body_append += '		</div>';
			body_append += '		<div class="modal-body" id="popup_content_popup_two"></div>';
			body_append += '	</div>';
			body_append += '</div>';
			$("BODY").append(body_append);
			$('#popup_container_popup_two').fadeIn('fast');
			$.ajax({
				url: msg,
				type: 'POST',
				data: data,
				beforeSend: function () {
					$("#popup_content_popup_two").html('<div style="text-align:center;"><img src="' + base_url + 'assets/images/loading.gif" alt="Loading" /><br><b>PLEASE WAIT ...</b></div>');
				},
				success: function (html) {
					$("#popup_content_popup_two").html(html);
					$("BODY").css({
						overflow: 'visible'
					});
				}
			});

			if ($.alerts.dialogClass) $("#popup_container_popup_two").addClass($.alerts.dialogClass);
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6) ? 'absolute' : 'fixed';
			$("#popup_container_popup_two").css({
				position: pos,
				zIndex: 9992,
				padding: 0,
				margin: 0
			});
			$("#popup_content_popup_two").css({
				overflow: 'auto',
				height: 450 + 'px',
			});
			$("#popup_title_popup_two").text(title);
			$("#popup_message_popup_two").text(msg);
			$("#popup_message_popup_teo").html($("#popup_message_popup_two").text().replace(/\n/g, '<br />'));
			$("#popup_container_popup_two").css({
				//minWidth: $("#popup_container_popup").outerWidth(),
				//maxWidth: $("#popup_container_popup").outerWidth()
			});
			$.alerts._repositionPopupTwo();
			$.alerts._maintainPosition(true);
			$("#popup_close_popup_two").click(function () {
				$('#popup_container_popup_two').fadeOut('fast',
					function () {
						$.alerts._hidePopupTwo();
					});
				callback(true);
			});
			// Make draggable
			if ($.alerts.draggable) {
				try {
					$("#popup_container_popup_two").draggable({ handle: $("#popup_title_popup_two") });
					$("#popup_title_popup_two").css({ cursor: 'move' });
				} catch (e) { /* requires jQuery UI draggables */ }
			}
		},
		_hide: function () {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		_overlay: function (status) {
			switch (status) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99999,
						top: '0px',
						left: '0px',
						width: '100%',
						height: '100%',
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
					break;
				case 'hide':
					$("#popup_overlay").remove();
					break;
			}
		},
		_reposition: function () {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if (top < 0) top = 0;
			if (left < 0) left = 0;
			// IE6 fix
			if ($.browser.msie && parseInt($.browser.version) <= 6) top = top + $(window).scrollTop();
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height($(document).height());
		},
		_repositionPopup: function () {
			var top = (($(window).height() / 2) - ($("#popup_container_popup").outerHeight())) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container_popup").outerWidth())) + $.alerts.horizontalOffset;
			if (top < 0) top = 0;
			if (left < 0) left = 0;
			// IE6 fix
			if ($.browser.msie && parseInt($.browser.version) <= 6) top = top + $(window).scrollTop();
			$("#popup_container_popup").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay_popup").css({
				width: 100 + '%',
				height: $(document).height()
			});
			//$("#popup_overlay_popup").height($(document).height());
		},
		_repositionPopupTwo: function () {
			var top = (($(window).height() / 2) - ($("#popup_container_popup_two").outerHeight())) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container_popup_two").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if (top < 0) top = 0;
			if (left < 0) left = 0;
			// IE6 fix
			if ($.browser.msie && parseInt($.browser.version) <= 6) top = top + $(window).scrollTop();
			$("#popup_container_popup_two").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay_popup_two").height($(document).height());
		},
		_maintainPosition: function (status) {
			if ($.alerts.repositionOnResize) {
				switch (status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
						break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
						break;
				}
			}
		},
		_hideLoading: function () {
			$("#popup_content_loading").remove();
			$.alerts._hide();
		},
		_overlayPopup: function (status) {
			switch (status) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay_popup"></div>');
					$("#popup_overlay_popup").css({
						position: 'absolute',
						zIndex: 9991,
						top: '0px',
						left: '0px',
						width: $(window).width(),
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
					break;
				case 'hide':
					$("#popup_overlay_popup").remove();
					break;
			}
		},
		_overlayPopupTwo: function (status) {
			switch (status) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay_popup_two"></div>');
					$("#popup_overlay_popup_two").css({
						position: 'absolute',
						zIndex: 9992,
						top: '0px',
						left: '0px',
						width: $(window).width(),
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
					break;
				case 'hide':
					$("#popup_overlay_popup_two").remove();
					break;
			}
		},
		_hidePopup: function () {
			// $("BODY").removeAttr('style');
			$("BODY").css({
				overflow: 'visible'
			});
			$("#popup_container_popup").remove();
			$.alerts._overlayPopup('hide');
			$.alerts._maintainPosition(false);
		},
		_hidePopupTwo: function () {
			//$("BODY").removeAttr('style');
			$("BODY").css({
				overflow: 'visible'
			});
			$("#popup_container_popup_two").remove();
			$.alerts._overlayPopupTwo('hide');
			$.alerts._maintainPosition(false);
		},
		popup: function (message, title, callback, data, width, height) {
			if (title == null) title = 'POP UP';
			$.alerts._showPopup(title, message, null, 'popup', function (result) {
				if (callback) callback(result);
			}, data, width, height);
		},
		closepopup: function () {
			$.alerts._hidePopup();
		},
		popuptwo: function (message, title, callback, data, width, height) {
			if (title == null) title = 'POP UP';
			$.alerts._showPopupTwo(title, message, null, 'popup', function (result) {
				if (callback) callback(result);
			}, data, width, height);
		},
		closepopuptwo: function () {
			$.alerts._hidePopupTwo();
		},
	}
	// Shortuct functions
	jAlert = function (message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	jConfirm = function (message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
	jPrompt = function (message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	LoadingOpen = function (message, title, callback) {
		$.alerts.loading(message, title, callback);
	};
	LoadingClose = function (message, title, callback) {
		$.alerts._hideLoading();
	};
	jpopup = function (url, title, data, width, height) {
		var callback = '';
		$.alerts.popup(url, title, callback, data, width, height);
	};
	jpopup_close = function () {
		$.alerts.closepopup();
	};
	jpopuptwo = function (url, title, data, width, height) {
		var callback = '';
		$.alerts.popuptwo(url, title, callback, data, width, height);
	};
	jpopup_closetwo = function () {
		$.alerts.closepopuptwo();
	};

})(jQuery);