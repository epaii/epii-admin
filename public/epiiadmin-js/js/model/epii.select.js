/**
 * Created by mrren on 2018/8/24.
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals.
        factory(jQuery);
    }
})(function ($) {

var out={
    init:function (selects) {
        selects.each(function () {
           if(! $(this).hasClass("selectpicker"))
           {
               $(this).addClass("selectpicker");
           }
        });

        require(['bootstrap-select',"bootstrap-select-lang"], function () {
            $(".selectpicker").selectpicker();
        });
    }
};
return out;
});