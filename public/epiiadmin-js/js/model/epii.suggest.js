/**
 * Created by mrren on 2018/8/24.
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery','bootstrap-suggest'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'),require('bootstrap-suggest'));
    } else {
        // Browser globals.
        factory(jQuery);
    }
})(function ($,bootstrapSuggest) {

    var out = {
        init: function (selects) {
            selects.each(function () {
                var data = $(this).data();
                var that = this;
                $(this).bsSuggest({
                    allowNoKeyword: false,   //是否允许无关键字时请求数据。为 false 则无输入时不执行过滤请求
                    multiWord: true,         //以分隔符号分割的多关键字支持
                    separator: ",",          //多关键字支持时的分隔符，默认为空格
                    getDataMethod: "url",    //获取数据的方式，总是从 URL 获取
                    url: data['url'], /*优先从url ajax 请求 json 帮助数据，注意最后一个参数为关键字请求参数*/
                    listAlign:"auto",
                    idField: EpiiAdmin.getTrueValue(data['id-field'],"id"),                    //每组数据的哪个字段作为 data-id，优先级高于 indexId 设置（推荐）

                    keyField: EpiiAdmin.getTrueValue(data['key-field'],"text"),

                    // url 获取数据时，对数据的处理，作为 fnGetData 的回调函数
                    fnProcessData: function (json) {
                        return {value: json};
                    }
                }).on('onDataRequestSuccess', function (e, result) {
                   // console.log('onDataRequestSuccess: ', result);
                }).on('onSetSelectValue', function (e, keyword, data) {
                    console.log('onSetSelectValue: ', keyword, data);


                    for(var item  in data)
                    {

                        var input ="input"+ item.substring(0,1).toUpperCase()+item.substring(1);
                        console.log(input);
                        if ($(that).data(input)) {
                            $("input[name='" + $(that).data(input) + "']").val(data[item]);
                        }
                    }

                }).on('onUnsetSelectValue', function () {
                    console.log("onUnsetSelectValue");
                }).on('onHideDropdown', function (e, data) {
                    console.log('onHideDropdown', e.target.value, data);

                });
            });


        }
    };
    return out;
});