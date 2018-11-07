/**
 * Created by mrren on 2018/8/24.
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery', 'bootstrap-suggest'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'), require('bootstrap-suggest'));
    } else {
        // Browser globals.
        factory(jQuery);
    }
})(function ($, bootstrapSuggest) {

    var out = {
        init: function (selects) {
            selects.each(function () {
                var data = $(this).data();
                var that = this;
                var effectiveFieldsAlias = {};

                for (var index in data) {
                    if (index.indexOf("headerFieldName") == 0) {
                        effectiveFieldsAlias[index.substr("headerFieldName".length).toLowerCase()] = data[index];
                    }
                }
                if ($dropdownMenu = $(that).parent().find('ul:eq(0)')) {
                    if ($dropdownMenu.length == 0) {
                        $(that).after('<div class="input-group-btn"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right" role="menu"></ul></div>');
                    }

                }


                $(this).bsSuggest({
                    allowNoKeyword: false,   //是否允许无关键字时请求数据。为 false 则无输入时不执行过滤请求
                    multiWord: true,         //以分隔符号分割的多关键字支持
                    separator: ",",          //多关键字支持时的分隔符，默认为空格
                    getDataMethod: "url",    //获取数据的方式，总是从 URL 获取
                    url: data['url'], /*优先从url ajax 请求 json 帮助数据，注意最后一个参数为关键字请求参数*/
                    listAlign: "auto",
                    idField: EpiiAdmin.getTrueValue(data['idField'], "id"),                    //每组数据的哪个字段作为 data-id，优先级高于 indexId 设置（推荐）

                    keyField: EpiiAdmin.getTrueValue(data['keyField'], "text"),

                    // url 获取数据时，对数据的处理，作为 fnGetData 的回调函数
                    fnProcessData: function (json) {
                        return {value: json};
                    },
                    showHeader: data['showHeader'] === true,
                    effectiveFieldsAlias: effectiveFieldsAlias //showHeader 时，header 别名
                }).on('onDataRequestSuccess', function (e, result) {
                    // console.log('onDataRequestSuccess: ', result);
                }).on('onSetSelectValue', function (e, keyword, data) {
                    // console.log('onSetSelectValue: ', keyword, data);


                    $(that).attr("data-last-select-value", e.target.value);
                    var inputs = [];
                    for (var item  in data) {

                        var input = "input" + item.substring(0, 1).toUpperCase() + item.substring(1);

                        if ($(that).data(input)) {
                            $("input[name='" + $(that).data(input) + "']").val(data[item]);
                            inputs.push($(that).data(input));
                        }
                    }
                    $(that).attr("data-inputs", inputs.join(","));

                    var callback = EpiiAdmin.tools.getFunction(null, $(that).data(), "onSelect", window);

                    callback.apply(this, arguments);
                }).on('onUnsetSelectValue', function () {
                    //console.log("onUnsetSelectValue");
                }).on('onHideDropdown', function (e, data) {
                    // console.log('onHideDropdown', e.target.value, data);
                    if ($(that).attr("data-last-select-value") != e.target.value) {
                        if ($(that).attr("data-inputs")) {
                            var inputs = $(that).attr("data-inputs").split(",");
                            for (var item  in inputs) {


                                $("input[name='" + inputs[item] + "']").val("");


                            }
                        }

                    }

                });
            });


        }
    };
    return out;
});