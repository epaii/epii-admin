/**
 * Created by mrren on 2018/7/5.
 */
;(function () {
    var windowobject = window;

    function getWindow() {
        return EpiiAdmin.this_window;
    }

    var run = {
        eval: function (c) {
            var cmd = c.__cmd__;
            if (run.hasOwnProperty(cmd)) {

                if (c.__time__) {
                    setTimeout(run[cmd].bind(c), c.__time__ - 0);
                } else {
                    run[cmd].call(c);
                }
            }
        },
        alert: function () {

            EpiiAdmin.alert(this, function () {
                run.eval(this);
            }.bind(this.onOk));
        },
        refresh: function () {


            if (this.keyInTabsUrl) {
                if (getWindow().EpiiAdmin.addtabs) getWindow().EpiiAdmin.addtabs.reload_next(this.keyInTabsUrl);
            }
            var type = this.type;
            var c_window = getWindow();
            for (var i = 1; i <= this.layerNum - 0; i++) {

                if (this.layerStart - i <= 0) {
                    EpiiAdmin.needRefresWhenClose[c_window.this_window_id] = {"type": type, "window": c_window.open_in_window || c_window.parent};
                }

                c_window =c_window.open_in_window || c_window.parent;
                if (!c_window) {
                    break;
                }
            }



            if (this.layerStart - 0 == 0)
                epii_eval.doRefresh(type, getWindow());


        },
        url: function () {

            if (this.openType == "addtab") {
                getWindow().EpiiAdmin.openInTab(this.url, this.title, this.addtab_id);
            } else if (this.openType == "dialog") {
                getWindow().EpiiAdmin.openInDialog(this.url, this.title, this.intop, this.area);
            } else if (this.openType == "_blank") {
                getWindow().open(this.url);
            } else if (this.openType == "location") {
                getWindow().location.href = this.url;
            } else if (this.openType == "ajax") {
                getWindow().EpiiAdmin.ajax(this.url);

            }

        },
        toast: function () {
            EpiiAdmin.toast(this, this.onFinish ? function () {
                run.eval(this);
            }.bind(this.onFinish) : null);
        },
        close: function () {
            var c_window = getWindow();
            for (var i = 0; i < this.closeNum - 0; i++) {

                if (!(c_window.open_in_window || c_window.parent)) {
                    break;
                }
                c_window = c_window.open_in_window || c_window.parent;
            }
            var winid = c_window.this_window_id;
            c_window.open_layer.close(c_window.open_layer_index);

            return winid;

        },
        closeandrefresh: function () {
            this.layerStart = this.layerStart + this.closeNum + 1 - 0;
            this.layerNum = this.layerNum + this.closeNum + 1 - 0;
            run["refresh"].call(this);
            var winid = run["close"].call(this);
            getWindow().EpiiAdmin.whenWindowClose(winid);

        },
        jseval: function () {
            if (this.strings) {
                this.strings.forEach(function (str) {
                    getWindow().eval(str);
                });
            }
            if (this.functions) {
                this.functions.forEach(function (fun) {
                    if (getWindow()[fun[0]]) getWindow()[fun[0]].apply(null, fun[1]);
                });
            }
        }

    };

    function epii_eval(cmds) {

        cmds.forEach(function (cmd) {
            if (cmd.hasOwnProperty("__cmd__")) {
                run.eval(cmd);
            }
        });
    }

    epii_eval.bindWindow = function (obj) {
        windowobject = obj;
    };
    epii_eval.doRefresh = function (type, in_window) {
        console.log(in_window);
        var isdo = false;
        if (type == "both" || type == "table") {
            if (in_window.epii_table) {
                in_window.epii_table.refreshTable("1");
                isdo = true;
            }
        }

        if ((!isdo) && (type == "both" || type == "page")) {

            in_window.location.reload();

        }
    };

    if (typeof module !== 'undefined' && typeof exports === 'object') {
        module.exports = epii_eval;
    } else if (typeof define === 'function' && (define.amd || define.cmd)) {
        define(function () {
            return epii_eval;
        });
    } else {

        this.epii_eval = epii_eval;
    }
}).call(this || (typeof window !== 'undefined' ? window : global));

