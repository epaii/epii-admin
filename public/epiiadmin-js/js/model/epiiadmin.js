/**
 * Created by mrren on 2018/6/29.
 */
define(['args', "jquery", "layer", "eval"], function (Args, $, layer, epii_eval) {

    layer.config({
        path: Args.baseUrl + Args.pluginsUrl + "layer/"
    });

    var epiiAdmin = [];

    var this_window_id = Args.window_id;
    window.this_window_id = this_window_id;
    if (window.top != window.self) {
        epiiAdmin = window.top.EpiiAdmin;
        epiiAdmin.bindWindow(this_window_id, window);

    } else {
        epiiAdmin.windows = [];
        epiiAdmin.bindWindow = function (id, obj) {

            if (!obj) {
                epiiAdmin.this_window = epiiAdmin.windows[id];
                return epiiAdmin;
            } else {
                epiiAdmin.windows[id] = obj;
            }
        };
        epiiAdmin.bindWindow(this_window_id, window);
        epiiAdmin.getTrueValue = function () {
            for (var i = 0; i < arguments.length; i++) {
                if (arguments[i]) {
                    return arguments[i];
                }
            }
            return arguments[0];
        };
        epiiAdmin.call = function (stringOrCallable, data, inobject, obj) {
            if (!stringOrCallable) return null;
            if (typeof  stringOrCallable == "string") {
                if (!inobject) {
                    inobject = window;
                }
                if (inobject[stringOrCallable]) {
                    stringOrCallable = inobject[stringOrCallable];
                }
            }
            if (typeof  stringOrCallable == "function") {
                return stringOrCallable.call(obj == undefined ? null : obj, data == undefined ? null : data);

            }
            return null;
        };

        epiiAdmin.openMenu = function () {

            var isShown = !$("body").hasClass("sidebar-collapse");
            if (!isShown) {
                //  $('[data-widget="pushmenu"]').trigger("click");
                EpiiAdmin.Pushmenu.toggle();
            }

        };
        epiiAdmin.closeMenu = function () {

            var isShown = !$("body").hasClass("sidebar-collapse");
            if (isShown) {
                // $('[data-widget="pushmenu"]').trigger("click");
                EpiiAdmin.Pushmenu.toggle();
            }

        };
        epiiAdmin.openInTab = function (url, title, addtab_id) {

            if (EpiiAdmin.addtabs) {
                var addid = addtab_id ? addtab_id : epiiAdmin.tools.query("addtab_id", url);
                if (!addid) addid = Math.random().toString(36).substring(3, 35);
                title = title ? title : epiiAdmin.tools.query("title", url);
                if (!title) title = "无标题";
                EpiiAdmin.addtabs.add({
                    'id': addid,
                    'title': title ? title : epiiAdmin.tools.query("title", url),

                    'url': url

                });
            } else {
                window.location.href = url;
            }

        };


        epiiAdmin.openDivDialog = function (html, title, intop, area) {

            var mylayer = epiiAdmin.tools.getLayer(intop);
            var index = mylayer.open({
                type: 1,
                title: title,
                shadeClose: true,
                shade: 0.5,
                area: !area ? ['70%', '50%'] : area.split(","),
                content: html,
                mylayer: mylayer,
                in_window: epiiAdmin.this_window


            });


        };


        epiiAdmin.openInDialog = function (url, title, intop, area) {
            intop = intop ? intop : epiiAdmin.tools.query("intop", url);

            title = title ? title : epiiAdmin.tools.query("title", url);
            console.log("rlr0:" + epiiAdmin.this_window.this_window_id);
            var mylayer = epiiAdmin.tools.getLayer(intop);
            var index = mylayer.open({
                type: 2,
                title: title,
                shadeClose: true,
                shade: 0.5,
                area: !area ? ['100%', '100%'] : area.split(","),
                content: url,
                mylayer: mylayer,
                in_window: epiiAdmin.this_window,
                success: function (layero, index) {
                    var openwindow = $(layero).find("iframe")[0].contentWindow;
                    var close_wind_id = openwindow.Args.window_id;
                    openwindow.open_layer = mylayer;
                    openwindow.open_layer_index = index;
                    openwindow.open_in_window = epiiAdmin.this_window;
                    this.close_wind_id = close_wind_id;

                },
                cancel: function (index, layero) {


                    var close_wind_id = this.close_wind_id;


                    this.mylayer.close(index);
                    epiiAdmin.whenWindowClose(close_wind_id);

                    return false;
                }

            })


        };

        epiiAdmin.whenWindowClose = function (close_wind_id) {
            console.log(EpiiAdmin.needRefresWhenClose);
            console.log("rlr1:" + close_wind_id);

            if (close_wind_id && EpiiAdmin.needRefresWhenClose[close_wind_id]) {
                epiiAdmin.eval.doRefresh(EpiiAdmin.needRefresWhenClose[close_wind_id].type, EpiiAdmin.needRefresWhenClose[close_wind_id].window);
                EpiiAdmin.needRefresWhenClose[close_wind_id] = false;
            }

        };


        epiiAdmin.ajax = function (options, success, error) {

            options = typeof options === 'string' ? {url: options} : options;
            var index = layer.load(0, {shade: 0.4});
            options = $.extend({
                type: "POST",
                dataType: "json",
                success: function (ret) {
                    layer.close(index);

                    if (ret.code && ret.code == 1 && ret.data && ret.data.epii_eval == 1) {
                        epiiAdmin.eval(ret.data.cmds);
                    }
                    epiiAdmin.call(success, ret);
                },
                error: function (xhr) {
                    layer.close(index);

                    if (!epiiAdmin.call(error, xhr)) {
                        layer.alert("网络连接失败，请重试");
                    }
                }
            }, options);
            $.ajax(options);
        };

        epiiAdmin.toast = function (data, callback) {
            data = $.extend(
                {
                    icon: 3,
                    msg: "",
                    offset: "50px"
                }, data);

            callback = epiiAdmin.tools.getFunction(callback, data, "onFinish");
            var index = epiiAdmin.tools.getLayer(data).msg(data['msg'], data, function () {
                epiiAdmin.tools.getLayer(data).close(index);
                callback && callback(data['this']);
            });
        };
        epiiAdmin.alert = function (data, callback) {
            data = $.extend(
                {
                    icon: 3,
                    msg: "您确定要操作吗？",
                    offset: "50px"
                }, data);

            if (!data['onOk'])
            {
               data['onOk'] = "tag.a";
            }

            callback = epiiAdmin.tools.getFunction(callback, data, "onOk");
            var index = epiiAdmin.tools.getLayer(data).alert(data['msg'], data, function () {
                epiiAdmin.tools.getLayer(data).close(index);
                callback && callback(data['this']);
            });
        };
        epiiAdmin.confirm = function (data, onOk, onCancel) {
            data = $.extend(
                {
                    icon: 3,
                    msg: "您确定要操作吗？",
                    offset: "50px",
                    btn: [epiiAdmin.getTrueValue(data['btnOk'], "确定"), epiiAdmin.getTrueValue(data['btnCancel'], "取消")]
                }, data);
            if (!data['onOk'])
            {
                data['onOk'] = "tag.a";
            }
            onOk = epiiAdmin.tools.getFunction(onOk, data, "onOk");
            onCancel = epiiAdmin.tools.getFunction(onCancel, data, "onCancel");
            var index = epiiAdmin.tools.getLayer(data).confirm(data['msg'], data, function () {
                epiiAdmin.tools.getLayer(data).close(index);
                if (onOk) onOk(data['this']);
            }, function () {
                epiiAdmin.tools.getLayer(data).close(index);
                if (onCancel) onCancel(data['this']);
            });
        };
        epiiAdmin.prompt = function (data, onOk, onCancel) {
            data = $.extend(
                {
                    formType: 2,
                    title: "请输入",
                    offset: "50px",
                    area: data.area ? data.area.split(",") : ['800px', '350px'],
                    btn: [epiiAdmin.getTrueValue(data['btnOk'], "确定"), epiiAdmin.getTrueValue(data['btnCancel'], "取消")]
                }, data);
            onOk = epiiAdmin.tools.getFunction(onOk, data, "onOk");
            onCancel = epiiAdmin.tools.getFunction(onCancel, data, "onCancel");
            epiiAdmin.tools.getLayer(data).prompt(data, function (value, index, elem) {
                epiiAdmin.tools.getLayer(data).close(index);
                if (onOk) onOk(value);
            });
        };
        epiiAdmin.tag = {
            a: function (dom) {

                var $a = $(dom);
                var data = $a.data();

                var onok = arguments[1];

                var title = data['title'] ? data['title'] : ($a.attr("title") ? $a.attr("title") : null);

                while (true) {
                    console.log(data);
                    if (onok && data['ajax']) {
                        console.log("ajax");
                        epiiAdmin.ajax(epiiAdmin.tools.getUrlInTagA(dom));
                    } else if (onok && data['addtab']) {
                        epiiAdmin.openInTab(epiiAdmin.tools.getUrlInTagA(dom), title, data['addtab']);
                    } else if (onok && data['dialog']) {
                        epiiAdmin.openInDialog(epiiAdmin.tools.getUrlInTagA(dom), title, data['intop'], data['area'])
                    } else if (onok && data['tableTool']) {


                        epiiAdmin.table.do(dom);
                    } else if (data['alert']) {


                        data['callInObject'] = window;
                        data['this'] = dom;
                        epiiAdmin.alert(data);
                    } else if (data['confirm']) {


                        data['callInObject'] = window;
                        data['this'] = dom;
                        epiiAdmin.confirm(data);
                    } else if (data['prompt']) {


                        data['callInObject'] = window;
                        data['this'] = dom;
                        epiiAdmin.prompt(data);


                    } else {
                        if (!onok) {
                            onok = true;
                            continue;
                        }
                        else {
                            window.location.href = epiiAdmin.tools.getUrlInTagA(dom);
                        }

                    }
                    break;
                }


            }
        };

        epiiAdmin.closeWindow = function (window_id) {
            var thiswindow = epiiAdmin.windows[window_id];
            if (thiswindow) {
                thiswindow.close();
            }
        };
        epiiAdmin.eval = epii_eval;
        epiiAdmin.needRefresWhenClose = [];
        epiiAdmin.tools = {
            query: function (name, url) {
                if (!url) {
                    url = window.location.href;
                }
                name = name.replace(/[\[\]]/g, "\\$&");
                var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results)
                    return null;
                if (!results[2])
                    return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            },
            getFunction: function (fun, data, key, obj) {
                if (fun) return fun;

                if (!obj) obj = data['callInObject'];
                if (!obj) obj = window;


                if (data[key] && obj[data[key]]) {
                    if (typeof obj[data[key]] == "function") {
                        return obj[data[key]];
                    }
                    return null;
                }
                if (data[key] && data[key] == "tag.a") {
                    return (function (data) {
                        return function () {
                            epiiAdmin.tag.a(data["this"], true);
                        }
                    })(data)
                }

            },
            getLayer: function (intopOrData) {
                var isobject = intopOrData != null && typeof intopOrData === 'object' && Array.isArray(intopOrData) === false;
                var intop = false;
                if (isobject) {
                    intop = intopOrData['intop'];
                } else {
                    intop = intopOrData;
                }

                return intop ? layer : epiiAdmin.this_window.layer;
            },
            getColumn: function (arr, key) {
                var ret = []
                for (var i = 0, len = arr.length; i < len; i++) {
                    ret.push(arr[i][key])
                }
                return ret
            },
            getUrlInTagA: function (dom) {
                var $a = $(dom);
                var url = epiiAdmin.getTrueValue($a.attr("href"), $a.data("url"));
                if (dom.urlArgs) {
                    if (url.indexOf("?") > 0) {
                        url = url + "&" + dom.urlArgs;
                    } else {
                        url = url + "?" + dom.urlArgs;
                    }
                }
                return url;
            },
            replaceInData: function (url, data) {

                var reg = /\{(.*?)\}/g;
                var url1 = url.replace(reg, function () {
                    return data[arguments[1]] ? data[arguments[1]] : "";
                });
                return url1;
            }


        }

        if (layer)
            epiiAdmin.layer = layer;

    }


//auto form
    var forms, tables, citys;
    if ((forms = $("form[data-form=1]")) && forms.length > 0) {
        require(['form'], function (Form) {
            Form(forms);
        })
    }

    if ((tables = $("table[data-table=1]")) && tables.length > 0) {
        require(['table'], function (Table) {
            Table(tables);
            epiiAdmin.table = Table;
        })
    }

    if (((citys = $('[data-toggle="city-picker"]')) && citys.length > 0) || ((citys = $('[data-city-picker="1"]')) && citys.length > 0)) {
        require(['city-picker'], function (citypicker) {
            citypicker.init(citys);
        })
    }
//auto a or btn


    $("body").on('click', '.btn-addtab', function (e) {

        e.stopPropagation();
        e.preventDefault();

        if (!$(this).data("addtab")) {
            $(this).attr("data-addtab", Math.random().toString(36).substring(3, 35))
        }
        var data = $(this).data();

        EpiiAdmin.tag.a(this);
    });


    $("body").on('click', '.btn-dialog', function (e) {


        e.stopPropagation();
        e.preventDefault();
        var data = $(this).data();
        var title = data['title'] ? data['title'] : ($(this).attr("title") ? $(this).attr("title") : null);
        EpiiAdmin.bindWindow(this_window_id).openInDialog(epiiAdmin.tools.getUrlInTagA(this), title, data['intop'], data['area'])
    });
    $("body").on('click', '.div-dialog', function (e) {

        e.stopPropagation();
        e.preventDefault();
        var data = $(this).data();
        var title = data['title'] ? data['title'] : ($(this).attr("title") ? $(this).attr("title") : null);
        EpiiAdmin.bindWindow(this_window_id).openDivDialog($(this).html(), title, data['intop'], data['area'])
    });
    $("body").on('click', '.btn-alert', function (e) {


        e.stopPropagation();
        e.preventDefault();
        var data = $(this).data();

        data['callInObject'] = window;
        data['this'] = this;
        EpiiAdmin.bindWindow(this_window_id).alert(data);
    });
    $("body").on('click', '.btn-confirm', function (e) {


        e.stopPropagation();
        e.preventDefault();
        var data = $(this).data();

        data['callInObject'] = window;
        data['this'] = this;
        EpiiAdmin.bindWindow(this_window_id).confirm(data);
    });
    $("body").on('click', '.btn-ajax', function (e) {


        e.stopPropagation();
        e.preventDefault();

        $(this).attr("data-ajax", 1)

        EpiiAdmin.bindWindow(this_window_id).tag.a(this, true);
    });
    $("body").on('click', '.btn-prompt', function (e) {


        e.stopPropagation();
        e.preventDefault();
        var data = $(this).data();

        data['callInObject'] = window;
        data['this'] = this;
        EpiiAdmin.bindWindow(this_window_id).prompt(data);
    });
    $("body").on('click', '.btn-table-tool', function (e) {

        e.stopPropagation();
        e.preventDefault();


        epiiAdmin.bindWindow(this_window_id).table.do(this);
    });

    $("body").on('click', '.tag-a', function (e) {
        console.log("click:" + this_window_id);
        e.stopPropagation();
        e.preventDefault();
        if ($(this).data("addtab") == "1") {
            $(this).attr("data-addtab", Math.random().toString(36).substring(3, 35))
        }
        EpiiAdmin.bindWindow(this_window_id).tag.a(this);
    });


    window.EpiiAdmin = epiiAdmin;
    return epiiAdmin;
})
;