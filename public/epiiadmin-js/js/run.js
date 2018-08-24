/**
 * Created by mrren on 2018/6/26.
 */
//环境变量，从应用程序传递过来
console.log(Args);
define("window", window);
define("args", Args);

require.config({
    urlArgs: "v=" + Args.version,
    baseUrl: Args.baseUrl, //资源基础路径
    paths: {
        "jquery": Args.pluginsUrl + "jquery/jquery" + Args.min,
        "bootstrap": Args.pluginsUrl + "bootstrap/js/bootstrap.bundle" + Args.min,
        "addtabs": Args.pluginsUrl + "bootStrap-addTabs/bootstrap.addtabs" + Args.min,
        "adminlte": Args.pluginsUrl + "adminlte/adminlte" + Args.min,
        "epiiadminJs": "model/epiiadmin",
        "layer": Args.pluginsUrl + "layer/layer",
        "validate": Args.pluginsUrl + "jquery-validation-1.17.0/dist/jquery.validate" + Args.min,
        "form": "model/epii.form",
        "table": "model/epii.table",
        "bootstrap-table": Args.pluginsUrl + "bootstrap-table/bootstrap-table" + Args.min,
        "bootstrap-table-lang":Args.pluginsUrl + 'bootstrap-table/bootstrap-table-zh-CN'+ Args.min,
        "inittop": "model/epii.inittop",
        "eval": "model/epii.eval",
        'city-picker': "model/epii.city.picker",
        'city-picker-core': Args.pluginsUrl +'city-picker/dist/js/city-picker'+ Args.min,
        'bootstrap-select':  Args.pluginsUrl + '/bootstrap-select/dist/js/bootstrap-select'+ Args.min,
        'bootstrap-select-lang': Args.pluginsUrl +'bootstrap-select/dist/js/i18n/defaults-zh_CN',
        "epii-select":"model/epii.select"
    },
    shim: {
        'bootstrap': ['jquery'],
        'epiiadminJs': ['jquery', "bootstrap", "layer"],
        'validate': ['jquery'],
        "addtabs": {
            exports: '$.addtabs'
        },
        "bootstrap-table": {
            deps: [
                'bootstrap',
                 "css!"+Args.pluginsUrl + 'bootstrap-table/bootstrap-table.min.css'
            ],
            exports: '$.fn.bootstrapTable'
        },
        "bootstrap-table-lang":["bootstrap-table"],
        "table": ["bootstrap-table-lang"],
        "inittop": ["css!model/epii.inittop.css"],
        "city-picker":['city-picker-core'],
        "city-picker-core": [Args.pluginsUrl +'city-picker/dist/js/city-picker.data',"css!"+Args.pluginsUrl +"city-picker/dist/css/city-picker.css"],
        'bootstrap-select': ["jquery","bootstrap",'css!'+Args.pluginsUrl +'bootstrap-select/dist/css/bootstrap-select.min.css' ],
        'bootstrap-select-lang': ['bootstrap-select']
    },
    map: {
        '*': {
            'css': Args.pluginsUrl +'/require-css/css.min'
        }
    }

});


require(["epiiadminJs", "args"], function (admin, Args) {


    var initfunctions;
    if (initfunctions = window[Args.epiiInitFunctionsName]) {
        initfunctions.forEach(function (call) {
            call.call(null, Args);
        });
    }
    
    function apprun() {
        if (Args.appName) {
            require([Args.appUrl + Args.appName+(Args.appUrl.indexOf("http")===0?".js":"")], function (app) {
                if (app && app.hasOwnProperty("run")) {
                    app.run(Args);
                }
            })
        }
    }
    if (Args.data.isTop) {
        require(["inittop"], function () {
            apprun();
        });

    }else{
        apprun();
    }


});

