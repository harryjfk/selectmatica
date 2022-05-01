var MKLib = {
    AjaxUpdate: function (url, divupdate, idform, method, callback) {
        if (typeof method == "undefined")
            method = 'POST';

     //   MKLib.blockScreen();
        var data = '';
        if (idform)
            data = jQuery('#' + idform).serialize();

        try {
            jQuery.ajax({
                url: url,
                data: data,
                type: method,
                dataType: 'text',
                success: function (response) {
                    var divUpdate = jQuery('#' + divupdate);
                    if (divUpdate.html())
                        divUpdate.empty().append(response);
                    //divUpdate.children().fadeOut(50, function(){divUpdate.empty().append(response);});
                    else
                        divUpdate.append(response);

                    if (callback)
                        callback();
                },
                error: function (xhr, status) {
                    alert(xhr.responseText);
                    /*alert('Disculpe, ha ocurrido un problema vuelva a intentarlo.');*/
                },
                complete: function () {
                    jQuery('#blockscreen').hide();
                }
            });
        } catch (ex) {
            jQuery('#blockscreen').hide();
        }

        return false;
    },
    AjaxRequest: function (url, idform, myFn, dataType, method) {
        if (typeof method == "undefined")
            method = 'POST';
       // MKLib.blockScreen();
        var data = '';
        if (idform)
            data = jQuery('#' + idform).serialize();

        try {
            jQuery.ajax({
                url: url,
                data: data,
                type: method,
                dataType: dataType,
                success: function (response) {
                    /*alert(response);*/
                    myFn(response);
                },
                error: function (xhr, status) {
                    alert('Disculpe, ha ocurrido un problema vuelva a intentarlo.' + xhr.responseText);
                    jQuery('#blockscreen').hide();
                },
                complete: function () {
                    return;
                }
            });
        } catch (ex) {
            jQuery('#blockscreen').hide();
            //showMsg('sh-error', ex.message);
        }

        return false;
    },
    AjaxRequestUpload: function (url, idform, myFn, dataType, method) {
        if (typeof method == "undefined")
            method = 'POST';
      //  MKLib.blockScreen();
        var data = '';

        if (idform) {
            data = new FormData(jQuery('#' + idform).get(0));
        }

        try {
            jQuery.ajax({
                url: url,
                data: data,
                type: method,
                dataType: dataType,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    /*alert(response);*/
                    myFn(response);
                },
                error: function (xhr, status) {
                    alert('Disculpe, ha ocurrido un problema vuelva a intentarlo.' + xhr.responseText);
                    jQuery('#blockscreen').hide();
                },
                complete: function () {
                    return;
                }
            });
        } catch (ex) {
            jQuery('#blockscreen').hide();
            //showMsg('sh-error', ex.message);
        }

        return false;
    },
    AjaxSilent: function (url, idform, myFn, dataType, method) {
        if (typeof method == "undefined")
            method = 'POST';
        var data = '';
        if (idform)
            data = jQuery('#' + idform).serialize();

        try {
            jQuery.ajax({
                url: url,
                data: data,
                type: method,
                dataType: dataType,
                success: function (response) {
                    myFn(response);
                },
                error: function (xhr, status) {
                },
                complete: function () {
                    return;
                }
            });
        } catch (ex) {
            //showMsg('sh-error', ex.message);
        }

        return false;
    },
    AjaxJson: function (Json) {
        try {
            switch (parseInt(Json.status)) {
                case 1:
                {
                    if (Json.fn)
                        eval(Json.fn);
                    break;
                }
            }
        } catch (ex) {
            MKLib.showMsg('alert-danger', ex.message + ' ' + Json.fn);
        }
        jQuery('#blockscreen').hide();
    },
    dimPadre: function (ele) {
        var parent = jQuery(document);//ele.parent(); 
        ele.css({
            'width': '100%'/*parent.width()+'%'*/,
            'height': parent.height(),
            'position': 'fixed',
            'z-index': 1050,
            'top': 0
        });
    },
    showMsg: function (cssclass, message, selectorShowIn) {
        if (typeof selectorShowIn == 'undefined')
            selectorShowIn = '.portlet-title:first';

        //var div = jQuery('.alert');

        if (cssclass == 'alert')
            cssclass = '';

        // if (div.get(0))
        //  div.fadeOut(150).remove();

        div = jQuery('<div class="alert ' + cssclass + '">' + message + '</div>');


        div.stop();
        div.insertAfter(selectorShowIn).fadeIn(300).delay(10000).fadeOut(300);
    },
    resetForm: function (id, fn) {
        jQuery('#' + id).get(0).reset();
        if (fn)
            fn();
    },
    blockScreen: function () {
       /* var block = jQuery('#blockscreen');
        if (block.get(0)) {
            MKLib.dimPadre(block);
            block.show();
        } else {
            block = jQuery('<div></div>');
            block.attr('id', 'blockscreen').addClass('opaco_block');
            block.appendTo('body');
            MKLib.dimPadre(block);
            block.append(jQuery('<div class="progress" style="margin:0px;"><div class="indeterminate"></div></div>'));
            block.show();
        }*/
    },
    deleteItem: function (list, fn, prefijo) {
        if (typeof prefijo == "undefined")
            prefijo = '';

        var i = 0;
        for (; i < list.length; i++) {
            jQuery('#' + prefijo + list[i]).fadeOut(250, function () {
                jQuery(this).remove()
            });
        }
        if (fn)
            fn();
    },
    renderErrors: function (jsonerrors, elemHtmlMsg, callback) {
        jQuery('.error').remove();
        jQuery.each(jsonerrors, function (idx, elem) {
            var jQuerythis = jQuery('#' + idx);
            var eleMsg = null;
            jQuery.each(elem, function (index, item) {
                eleMsg = jQuery(elemHtmlMsg).addClass('error');
                eleMsg.html(item);
                eleMsg.insertAfter(jQuerythis);
            });

            eleMsg.insertAfter(jQuerythis);
        });

        if (callback)
            callback();
    },
    checkedCtrl: function (ctrl, selector) {
        jQuery(selector).prop('checked', jQuery(ctrl).is(':checked'));
    },
    cantElem: function (selector) {
        return jQuery(selector).length;
    },
    unlockScreen: function () {
        jQuery('#blockscreen').hide();
    }

};

var MKAjax = {
    setAjaxUpdateForm: function (idform, url, divupdate, callback) {
        jQuery('#' + idform).bind('submit', function () {
            var jQuerythis = jQuery(this);
            url = url ? url : jQuerythis.attr('action');
            MKLib.AjaxUpdate(url, divupdate, idform, 'POST', callback);
            return false;
        });
        return this;
    },
    setAjaxRequestForm: function (url, idform, myFn, dataType) {
        jQuery('#' + idform).bind('submit', function () {
            var jQuerythis = jQuery(this);
            url = url ? url : jQuerythis.attr('action');
            MKLib.AjaxRequest(url, idform, myFn, dataType);
            return false;
        });
        return this;
    },
    /**
     * Hace que un elemento haga una petición ajax en el evento onclick
     */
    setAjaxUpdateItem: function (selector, idform, url, divupdate) {
        jQuery(selector).bind('click', function () {
            var jQuerythis = jQuery(this);
            url = url ? url : jQuerythis.attr('href');
            MKLib.AjaxUpdate(url, divupdate, idform);
            return false;
        });
        return this;
    },
    loadHtmlSelect: function (url, selectorToSelect, idform, textLoading, callback) {
        var objSelect = jQuery(selectorToSelect);
        var firstOption = objSelect.find('option:first');
        firstOption.html(textLoading);
        firstOption.siblings().remove();

        MKLib.AjaxSilent(url, idform, function (j) {
            objSelect.parent().empty().append(jQuery(j));
            if (callback)
                callback();
        }, 'html');

    },
    paginate: function (selectorLink, idEleUpdate, idform) {
        jQuery(selectorLink).on('click', function (e) {
            e.preventDefault();
            var _this = jQuery(this);
            MKLib.AjaxUpdate(_this.attr('href'), idEleUpdate, idform);
        });
    }

};


var Util = {
    renderErrors: function (err) {
        jQuery('.errorfield').remove();

        if (typeof err == "undefined")
            return;

        if (typeof err.messages == "undefined")
            return;

        if (err.messages.length) {
            var nameForm = err.nameForm;
            var list = {};
            for (var idx in err.messages) {
                var objMessage = err.messages[idx];

                if (typeof list[objMessage.field] == "undefined")
                    list[objMessage.field] = '<div class="errorfield">' + objMessage.msg + '</div>';
                else
                    list[objMessage.field] += '<div class="errorfield">' + objMessage.msg + '</div>';

            }

            for (var idx in list)
                jQuery(list[idx]).insertAfter(jQuery('#' + nameForm + '_' + idx));
        }

        return this;
    },
    removeMsgIfNotErrors: function (err) {
        if (typeof err == "undefined") {
            jQuery('.errorfield').remove();
            return;
        }

        if (typeof err.messages == "undefined")
            jQuery('.errorfield').remove();

        return this;
    },
    ValidaNumber: function (event) {
        var code = event.which || event.keyCode;
        var target = event.target || event.srcElement;
        var bool = true;
        if (code == 46) {
            var filter = /^\d+$/;
            if (filter.test(target.value))
                bool = true;
            else
                bool = false;
        } else {
            if (code == 37 || code == 39 || code == 8)
                bool = true;
            else if (code < 47 || code > 57)
                bool = false;
        }
        return bool;
    },
    addDaysDate: function (days, stringDate) {
        var date = new Date(stringDate);
        var addTime = days * 86400;
        date.setTime(date.getTime() + addTime * 1000);
        return date;
    },
    formatDate: function (date, formatDate) {

        var year = date.getFullYear().toString();
        var yearshort = date.getYear();
        var month = date.getMonth() + 1;
        var month = (month < 10) ? '0' + month : month;
        var day = date.getDate();
        var day = (day < 10) ? '0' + day : day;
        var hour = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
        var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();

        var format = [
            {format: 'yy', value: yearshort},
            {format: 'Y', value: year},
            {format: 'm', value: month},
            {format: 'd', value: day},
            {format: 'H', value: hour},
            {format: 'i', value: minutes}
        ];

        if (typeof formatDate == "undefined") {
            formatDate = 'Y-m-d H:i';
        }

        for (index in format) {
            var obj = format[index];
            formatDate = formatDate.replace(obj.format, obj.value);
        }

        return formatDate;
    },
    diferenciaFecha: function (dateIni, dateEnd, magnitude) {
        var dif = dateEnd - dateIni;
        var mult = 60;//minuto
        switch (magnitude) {
            case 'd':
            {
                mult = mult * 60 * 24;
                break;
            }
        }
        return Math.ceil(dif / (mult * 1000));
    }

};


var DailyParser = {

    parseDailyPosition: function (text) {

        var matches = text.match(/2E\) (.*)\n/);
        //si el buque está navegando tiene 6 valores donde el 5 sería el agua producida y no se toma en cuenta
        //si el buque está en puerto tiene 5 y no existe el agua producida
        try {
            if (typeof matches[1] != "undefined") {
                var parts = matches[1].split('/');
                if (parts.length < 5 || parts.length > 6) {
                    return false;
                }
                var indexFwTtl = (parts.length == 6) ? 5 : 4;
                jQuery('#bandec_northsouthbundle_dailypositionreport_dsfo').val(parts[0].trim());
                jQuery('#bandec_northsouthbundle_dailypositionreport_lsfo').val(parts[1].trim());
                jQuery('#bandec_northsouthbundle_dailypositionreport_mdo').val(parts[2].trim());
                jQuery('#bandec_northsouthbundle_dailypositionreport_mgo').val(parts[3].trim());
                jQuery('#bandec_northsouthbundle_dailypositionreport_fw').val(parts[indexFwTtl].trim());
                return true;
            }
        }
        catch (e) {
            return false;
        }
        return false;
    }

};