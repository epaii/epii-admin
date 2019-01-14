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
    $.extend($.validator.messages, {
        required: "这是必填字段",
        remote: "请修正此字段",
        email: "请输入有效的电子邮件地址",
        url: "请输入有效的网址",
        date: "请输入有效的日期",
        dateISO: "请输入有效的日期 (YYYY-MM-DD)",
        number: "请输入有效的数字",
        digits: "只能输入数字",
        creditcard: "请输入有效的信用卡号码",
        equalTo: "你的输入不相同",
        extension: "请输入有效的后缀",
        maxlength: $.validator.format("最多可以输入 {0} 个字符"),
        minlength: $.validator.format("最少要输入 {0} 个字符"),
        rangelength: $.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),
        range: $.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),
        max: $.validator.format("请输入不大于 {0} 的数值"),
        min: $.validator.format("请输入不小于 {0} 的数值")
    });


    return out;

});