/**
 * Website: http://git.oschina.net/hbbcs/bootStrap-addTabs
 *
 * Version : 2.1
 *
 * Created by joe on 2016-2-4.Update 2017-10-24
 */

(function ($) {

    var settings = {
        /**
         * 直接指定所有页面TABS内容
         * @type {String}
         */
        content: '',
        /**
         * 是否可以关闭
         * @type {Boolean}
         */
        close: true,
        /**
         * 监视的区域
         * @type {String}
         */
        monitor: 'body',
        /**
         * 默认使用iframe还是ajax,true 是iframe,false是ajax
         * @type {Boolean}
         */
        iframe: false,
        /**
         * 固定TAB中IFRAME高度,根据需要自己修改
         * @type {Number}
         */
        height: $(window).height() - 118,
        /**
         * 目标
         * @type {String}
         */
        target: '.nav-tabs',
        /**
         * 显示加载条
         * @type {Boolean}
         */
        loadbar: true,
        /**
         * 是否使用右键菜单
         * @type {Boolean}
         */
        contextmenu: true,
        /**
         * 将打开的tab页记录到本地中，刷新页面时自动打开，默认不使用
         * @type {Boolean}
         */
        store: true,
        /**
         * 保存的项目名称，为了区分项目
         * @type {String}
         */
        storeName: 'ws',
        /**
         * 内容样式表
         * @type {String}
         */
        contentStyle: 'content',
        /**
         * ajax 的参数
         * @type {Object}
         */
        ajax: {
            'async': true,
            'dataType': 'html',
            'type': 'get'
        },
        /**
         *
         * @type {Object}
         */
        local: {
            'refreshLabel': '刷新此标签',
            'closeThisLabel': '关闭此标签',
            'closeOtherLabel': '关闭其他标签',
            'closeLeftLabel': '关闭左侧标签',
            'closeRightLabel': '关闭右侧标签',
            'loadbar': '正在加载内容，请稍候．．．'
        },


        /**
         * 关闭tab回调函数
         * @return {[type]} [description]
         */
        callback: function () {
        }
    };

    var target, reload_next = [], tab_list = [];

    _store = function () {
        if (typeof (arguments[0]) == 'object') {
            tab_list = arguments[0];
            // arguments[0].each(function (name, val) {
            //     localStorage.setItem(name, val);
            // })
        } else if (arguments[1]) {
            tab_list[arguments[0]] = arguments[1];
            //localStorage.setItem(arguments[0], arguments[1]);
        } else {
            // return localStorage.getItem(arguments[0]);
            return tab_list[arguments[0]];
        }
    }

    _click = function (obj) {
        var a_obj, a_target;

        a_obj = (typeof obj.data('addtab') == 'object') ? obj.data('addtab') : obj.data();

        if (!a_obj.id && !a_obj.addtab) {
            a_obj.id = Math.random().toString(36).substring(3, 35);
            obj.data('id', a_obj.id);
        }

        $.addtabs.add({
            'target': a_obj.target ? a_obj.target : target,
            'id': a_obj.id ? a_obj.id : a_obj.addtab,
            'title': a_obj.title ? a_obj.title : obj.html(),
            'content': settings.content ? settings.content : a_obj.content,
            'url': a_obj.url ? a_obj.url : obj.attr('href'),
            'ajax': a_obj.ajax ? a_obj.ajax : false
        });
    };

    _createMenu = function (right, icon, text) {
        return $('<a>', {
            'href': 'javascript:void(0);',
            'class': "list-group-item",
            'data-right': right
        }).append(
            $('<i>', {
                'class': 'glyphicon ' + icon
            })
        ).append(text);
    }

    _pop = function (id, e, mouse) {
        $('body').find('#popMenu').remove();
        var refresh = e.attr('id') ? _createMenu('refresh', 'glyphicon-refresh', settings.local.refreshLabel) : '';
        var remove = e.attr('id') ? _createMenu('remove', 'glyphicon-remove', settings.local.closeThisLabel) : '';
        var left = e.prev('li').attr('id') ? _createMenu('remove-left', 'glyphicon-chevron-left', settings.local.closeLeftLabel) : '';
        var right = e.next('li').attr('id') ? _createMenu('remove-right', 'glyphicon-chevron-right', settings.local.closeRightLabel) : '';
        var popHtml = $('<ul>', {
            'aria-controls': id,
            'class': 'rightMenu list-group',
            id: 'popMenu',
            'aria-url': e.attr('aria-url'),
            'aria-ajax': e.attr('aria-ajax')
        }).append(refresh)
            .append(remove)
            .append(_createMenu('remove-circle', 'glyphicon-remove-circle', settings.local.closeOtherLabel))
            .append(left)
            .append(right);

        popHtml.css({
            'top': mouse.pageY,
            'left': mouse.pageX
        });
        popHtml.appendTo($('body')).fadeIn('slow');
        //刷新页面
        $('ul.rightMenu a[data-right=refresh]').on('click', function () {
            var id = $(this).parent('ul').attr("aria-controls").substring(4);
            var url = $(this).parent('ul').attr('aria-url');
            var ajax = $(this).parent('ul').attr('aria-ajax');
            $.addtabs.add({
                'id': id,
                'url': url,
                'refresh': true,
                'ajax': ajax
            });
        });

        //关闭自身
        $('ul.rightMenu a[data-right=remove]').on('click', function () {
            var id = $(this).parent("ul").attr("aria-controls");
            if (id.substring(0, 4) != 'tab_') return;
            $.addtabs.close({
                "id": id
            });
            $.addtabs.drop();
        });

        //关闭其他
        $('ul.rightMenu a[data-right=remove-circle]').on('click', function () {
            var tab_id = $(this).parent('ul').attr("aria-controls");
            target.find('li').each(function () {
                var id = $(this).attr('id');
                if (id && id != 'tab_' + tab_id) {
                    $.addtabs.close({
                        "id": $(this).children('a').attr('aria-controls')
                    });
                }
            });
            $.addtabs.drop();
        });

        //关闭左侧
        $('ul.rightMenu a[data-right=remove-left]').on('click', function () {
            var tab_id = $(this).parent('ul').attr("aria-controls");
            $('#tab_' + tab_id).prevUntil().each(function () {
                var id = $(this).attr('id');
                if (id && id != 'tab_' + tab_id) {
                    $.addtabs.close({
                        "id": $(this).children('a').attr('aria-controls')
                    });
                }
            });
            $.addtabs.drop();
        });

        //关闭右侧
        $('ul.rightMenu a[data-right=remove-right]').on('click', function () {

            var tab_id = $(this).parent('ul').attr("aria-controls");
            $('#tab_' + tab_id).nextUntil().each(function () {
                var id = $(this).attr('id');
                if (id && id != 'tab_' + tab_id) {
                    $.addtabs.close({
                        "id": $(this).children('a').attr('aria-controls')
                    });
                }
            });
            $.addtabs.drop();
        });
        popHtml.mouseleave(function () {
            $(this).fadeOut('slow');
        });
        $('body').click(function () {
            popHtml.fadeOut('slow');
        })
    };

    _listen = function () {
        $(settings.monitor).on('click', '[data-addtab]', function () {
            _click($(this));
            $.addtabs.drop();
        });

        $('body').on('click', '.close-tab', function (e) {
            e.stopPropagation();
            var id = $(this).parent("a").attr("aria-controls");
            $.addtabs.close({
                'id': id
            });
            $.addtabs.drop();

        });

        $('body').on('mouseover', 'li[role = "presentation"]', function () {
            $(this).find('.close-tab').show();
        });

        $('body').on('mouseleave', 'li[role = "presentation"]', function () {
            $(this).find('.close-tab').hide();
        });

        if (settings.contextmenu) {
            //obj上禁用右键菜单
            $('body').on('contextmenu', 'li[role=presentation]', function (e) {
                var id = $(this).children('a').attr('aria-controls');
                _pop(id, $(this), e);
                return false;
            });
        }

        var el;
        $('body').on('dragstart.h5s', settings.target + ' li', function (e) {
            el = $(this);
            //清除拖动操作携带的数据，否者在部分浏览器上会打开新页面
            if (e.originalEvent && e.originalEvent.dataTransfer
                && 'function' == typeof e.originalEvent.dataTransfer.clearData) {
                e.originalEvent.dataTransfer.clearData();
            }
        }).on('dragover.h5s dragenter.h5s drop.h5s', settings.target + ' li', function (e) {
            if (el == $(this)) return;
            $('.dragBack').removeClass('dragBack');
            $(this).addClass('dragBack');
            //支持前后调整标签顺序
            if (el.index() < $(this).index()) {
                el.insertAfter($(this))
            } else {
                $(this).insertAfter(el)
            }
        }).on('dragend.h5s', settings.target + ' li', function () {
            $('.dragBack').removeClass('dragBack');
        });

        $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function () {
            var id = $(this).parent('li').attr('id');
            id = id ? id.substring(8) : '';
            if (settings.store) {
                var tabs = $.parseJSON(_store('addtabs' + settings.storeName));
                $.each(tabs, function (k, t) {
                    (t.id == id) ? (t.active = 'true') : (delete t.active);
                });
                tabs = JSON.stringify(tabs);
                _store('addtabs' + settings.storeName, tabs);
            }
        });

        //浏览器大小改变时自动收放tab
        $(window).on('resize', function () {
            $.addtabs.drop();
        });
    };

    $.addtabs = function (options) {
        $.addtabs.set(options);
        _listen();
        if (settings.store) {
            var tabs = _store('addtabs' + settings.storeName) ? $.parseJSON(_store('addtabs' + settings.storeName)) : {};
            var active;
            $.each(tabs, function (k, t) {
                if (t.active) active = k;
                $.addtabs.add(t);
            });
            if (active) {
                target.children('.active').removeClass('active');
                $('#tab_' + active).addClass('active');
                target.next('.tab-content').children('.active').removeClass('active');
                $('#' + active).addClass('active');
            }
        }
    };

    $.addtabs.set = function () {
        if (arguments[0]) {
            if (typeof arguments[0] == 'object') {
                settings = $.extend(settings, arguments[0] || {});
            } else {
                settings[arguments[0]] = arguments[1];
            }
        }
        if (typeof settings.target == 'object') {
            target = settings.target;
        } else {
            target = $('body').find(settings.target).length > 0 ? $(settings.target).first() : $('body').find(settings.target).first();
        }
    }

    $.addtabs.add = function (opts) {
        var a_target, content;
        opts.id = opts.id ? opts.id : Math.random().toString(36).substring(3, 35);
        if (typeof opts.target == 'object') {
            a_target = opts.target;
        } else if (typeof opts.target == 'string') {
            a_target = $('body').find(opts.target).first();
        } else {
            a_target = target;
        }

        var id = opts.tabid ? opts.tabid : 'tab_' + opts.id;
        opts.tabid = id;
        $.addtabs.current_id=  id;
        var tab_li = a_target;
        //写入cookie
        if (settings.store) {
            var tabs = _store('addtabs' + settings.storeName) ? $.parseJSON(_store('addtabs' + settings.storeName)) : {};
            tabs[id] = opts;
            tabs[id].target = (typeof tabs[id].target == 'object') ? settings.target : tabs[id].target;
            var old_re = opts.refresh;
            $.each(tabs, function (k, t) {
                delete t.active;
                delete t.refresh;
            });
            tabs[id].active = 'true';
            tabs = JSON.stringify(tabs);
            _store('addtabs' + settings.storeName, tabs);
            opts.refresh= old_re;
        }

        var tab_content = $(settings.tab_content);

        tab_li.children('li[role = "presentation"].active').removeClass('active');
        tab_content.children('div[role = "tabpanel"].active').addClass('hidden');
        tab_content.children('div[role = "tabpanel"].active').removeClass('active');
        tab_content.children('a.active').removeClass('active');

        if (reload_next[opts['id']]) {
            opts.refresh = true;

        }
        if (opts.refresh) {
            reload_next[opts['id']] = false;
        }

        //如果TAB不存在，创建一个新的TAB
        if (tab_li.find('#tab_' + id).length < 1) {
            var cover = $('<div>', {
                'id': 'tabCover',
                'class': 'tab-cover'
            });
            var atag = $('<a>', {
                'href': '#' + id,
                'aria-controls': id,
                'role': 'tab',
                'data-toggle': 'tab',
                'class': settings.tab_title_a_class,
                "data-tabid": opts.id
            }).html(opts.title);
            atag.dblclick(function () {
                opts.refresh = true;
                $.addtabs.add(opts);
            });
            //创建新TAB的title
            var title = $('<li>', {
                'role': 'presentation',
                'id': 'tab_' + id,
                'aria-url': opts.url,
                'aria-ajax': opts.ajax ? true : false,
                'class': settings.tab_title_li_class
            }).append(
                atag
            );

            //是否允许关闭
            if (settings.close) {
                atag.append(
                    $('<i>', {
                        'class': 'close-tab fa fa-remove hidden',
                        'style': "display:none"
                    })
                );
            }
            //创建新TAB的内容
            var content = $('<div>', {
                'class': 'tab-pane ' + settings.contentStyle,
                'id': id,
                'height': settings.height - 5,
                'role': 'tabpanel'
            });

            //加入TABS
            tab_li.append(title);
            tab_content.append(content.append(cover));
        } else if (!opts.refresh) {
            $('#tab_' + id).addClass('active');
            $('#' + id).addClass('active');
            return;
        } else {
            content = $('#' + id);
            content.html('');
        }
        //加载条
        if (settings.loadbar) {
            content.html($('<div>', {
                'class': ''
            }).append(
                $('<div>', {
                    'class': 'progress-bar progress-bar-striped progress-bar-success active',
                    'role': 'progressbar',
                    'aria-valuenow': '100',
                    'aria-valuemin': '0',
                    'aria-valuemax': '100',
                    'style': 'width:100%'
                }).append('<span class="sr-only">100% Complete</span>')
                    .append('<span>' + settings.local.loadbar + '</span>')
            ));
        }


        //是否指定TAB内容
        if (opts.content) {
            content.html(opts.content);
        } else if (settings.iframe == true && (opts.ajax == 'false' || !opts.ajax)) { //没有内容，使用IFRAME打开链接


            content.html(
                $('<iframe>', {
                    'class': 'iframeClass',
                    'height': settings.height,
                    'frameborder': "no",
                    'border': "0",
                    'src': opts.url,

                })
            );
        } else {
            var ajaxOption = $.extend(settings.ajax, opts.ajax || {});
            ajaxOption.url = opts.url;
            ajaxOption.error = function (XMLHttpRequest, textStatus) {
                content.html(XMLHttpRequest.responseText);
            };
            ajaxOption.success = function (result) {
                content.html(result);
            }
            $.ajax(ajaxOption);
        }

        //激活TAB

        tab_li.find('#tab_' + id).addClass('active');
        tab_content.find('#' + id).addClass('active');
        tab_content.find('#' + id).find('#tabCover').remove();

    };

    $.addtabs.close = function (opts) {
        //如果关闭的是当前激活的TAB，激活他的前一个TAB
        if ($("#tab_" + opts.id).hasClass('active')) {
            if ($('#tab_' + opts.id).parents('li.tabdrop').length > 0 && !$('#tab_' + opts.id).parents('li.tabdrop').hasClass('hide')) {
                $('#tab_' + opts.id).parents(settings.target).find('li').last().tab('show');
            } else {
                $("#tab_" + opts.id).prev('li').tab('show');
            }
            $("#" + opts.id).prev().addClass('active');
        }

        $("#tab_" + opts.id).remove();
        $("#" + opts.id).remove();
        if (settings.store) {
            var tabs = $.parseJSON(_store('addtabs' + settings.storeName));
            delete tabs[opts.id];
            tabs = JSON.stringify(tabs);
            _store('addtabs' + settings.storeName, tabs);
        }
        $.addtabs.drop();
        settings.callback();
    };

    $.addtabs.closeAll = function (target) {
        if (typeof target == 'string') {
            target = $('body').find(target);
        }
        $.each(target.find('li[id]'), function () {
            var id = $(this).children('a').attr('aria-controls');
            $("#tab_" + id).remove();
            $("#" + id).remove();
        });
        target.find('li[role = "presentation"]').first().addClass('active');
        var firstID = target.find('li[role = "presentation"]').first().children('a').attr('aria-controls');
        $('#' + firstID).addClass('active');
        $.addtabs.drop();
    };

    $.addtabs.drop = function () {
        return;
        //创建下拉标签
        var dropdown = $('<li>', {
            'class': 'dropdown pull-right hide tabdrop tab-drop'
        }).append(
            $('<a>', {
                'class': 'dropdown-toggle',
                'data-toggle': 'dropdown',
                'href': '#'
            }).append(
                $('<i>', {
                    'class': "glyphicon glyphicon-align-justify"
                })
            ).append(
                $('<b>', {
                    'class': 'caret'
                })
            )
        ).append(
            $('<ul>', {
                'class': "dropdown-menu"
            })
        )


        $('body').find(settings.target).each(function () {
            var element = $(this);
            //检测是否已增加
            if (element.find('.tabdrop').length < 1) {
                dropdown.prependTo(element);
            } else {
                dropdown = element.find('.tabdrop');
            }
            //检测是否有下拉样式
            if (element.parent().is('.tabs-below')) {
                dropdown.addClass('dropup');
            }
            var collection = 0;

            //检查超过一行的标签页
            element.append(dropdown.find('li'))
                .find('>li')
                .not('.tabdrop')
                .each(function () {
                    if (this.offsetTop > 0 || element.width() - $(this).position().left - $(this).width() < 83) {
                        dropdown.find('ul').prepend($(this));
                        collection++;
                    }
                });

            //如果有超出的，显示下拉标签
            if (collection > 0) {
                dropdown.removeClass('hide');
                if (dropdown.find('.active').length == 1) {
                    dropdown.addClass('active');
                } else {
                    dropdown.removeClass('active');
                }
            } else {
                dropdown.addClass('hide');
            }
        })

    };


    $.addtabs.reload_next = function (key_in_url) {
        var tabs = _store('addtabs' + settings.storeName) ? $.parseJSON(_store('addtabs' + settings.storeName)) : {};
        if (tabs) {
            for (var index in tabs) {

                if (tabs[index]['url'].indexOf(key_in_url) > -1) {
                    reload_next[tabs[index]["id"]] = true;
                    if (tabs[index]['active'] == 'true') {
                        $("[data-tabid=" + tabs[index]["id"] + "]").eq(0).dblclick();
                    }
                }
            }
        }


    };
    $.addtabs.reload_check = function (id) {
        return reload_next[id];
    };
    $.addtabs.addById = function (id) {
        var tabs = _store('addtabs' + settings.storeName) ? $.parseJSON(_store('addtabs' + settings.storeName)) : {};

        $.addtabs.add(tabs[id]);


    };
    $.addtabs.reloadById = function (id) {
        var tabs = _store('addtabs' + settings.storeName) ? $.parseJSON(_store('addtabs' + settings.storeName)) : {};

        tabs[id].refresh = true;
        $.addtabs.add(tabs[id]);


    };

    $.addtabs.addDom = function (dom) {
        _click($(dom));
        $.addtabs.drop();
    };


})(jQuery);

$(function () {
    $.addtabs();
})
