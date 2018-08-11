/**
 * Created by mrren on 2018/6/30.
 */
define(['validate', "jquery"], function (validate, $) {

    function getForm(form) {
        return typeof form === 'object' ? form : $(form);
    }

    function out(form) {
        out.initFroms(form);
        return out;
    }
    out.before = {
        alert:function (submit) {
            EpiiAdmin.alert($(this).data(),submit);
        },
        confirm:function (submit) {
            EpiiAdmin.confirm($(this).data(),submit);
        }
    };

    out.init = {
        validator: function (form) {

            form = getForm(form);
            form.validate({
                submitHandler: function (form) {

                    out.submit($(form));
                }
            });
        }
    };
    out.initFroms = function (forms) {

        forms.each(function () {
            form = getForm($(this));
            out.init.validator(form);
        })

    };
    out.submit = function (form, success, error, submit) {

        var before = form.data("beforeSubmit");
        if (before && before.length > 0) {

            if (out.before.hasOwnProperty(before)) {
                out.before[before].call(form[0], dosubmit);
                return;
            }
            if (window.hasOwnProperty(before)) {
                window[before].call(form[0], dosubmit);
                return;
            }
        }
        dosubmit();
        function dosubmit() {

            if (false === EpiiAdmin.call(submit, form)) {
                return false;
            }


            if (form.data("searchTableId"))
            {
                require(['table'],function (Table) {
                    var d = {};
                    var t = form.serializeArray();
                    $.each(t, function() {
                        d[this.name] = this.value;
                    });
                    Table.search(d,form.data("searchTableId"));
                });
                return;
            }

            var type = form.attr("method").toUpperCase(), url;
            type = type && (type === 'GET' || type === 'POST') ? type : 'GET';
            url = form.attr("action");
            url = url ? url : location.href;
            //修复当存在多选项元素时提交的BUG
            var params = {};
            var multipleList = form.find("[name$='[]']");

            if (multipleList.length > 0) {
                var postFields = form.serializeArray().map(function (obj) {
                    return $(obj).prop("name");
                });
                $.each(multipleList, function (i, j) {
                    if (postFields.indexOf($(this).prop("name")) < 0) {
                        params[$(this).prop("name")] = '';
                    }
                });
            }
            EpiiAdmin.bindWindow(window.this_window_id);
            EpiiAdmin.ajax({
                type: type,
                url: url,
                data: form.serialize() + (Object.keys(params).length > 0 ? '&' + $.param(params) : ''),
                dataType: 'json'
            }, success, error);
        }


    };
    return out;

});