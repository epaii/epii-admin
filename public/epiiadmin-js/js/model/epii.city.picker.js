define(["ChineseDistricts"], function (ChineseDistricts) {
    var out = {
        init: function (citys) {
            citys.each(function () {
                $(this).parent().css({"position": "relative"});
                $(this).css({"width": "350px"});
                var that = this;
                $(this).on("cp:updated", function (e) {

                    var code_all = $(that).data('citypicker').getCode();
                    if ($(that).data("codeInput")) {
                        $("input[name='" + $(that).data("codeInput") + "']").val(code_all);
                    }
                    if ($(that).data("codeLastInput")) {
                        $("input[name='" + $(that).data("codeLastInput") + "']").val(code_all.split("/").pop());
                    }
                    ["province", "city", "district"].forEach(function (value) {
                        if ($(that).data("code-" + value + "-input")) {
                            $("input[name='" + $(that).data("code-" + value + "-input") + "']").val($(that).data('citypicker').getCode(value));
                        }
                    });


                });
                $(this).attr("data-toggle", "");
            });


            require(['city-picker'], function (citypicker) {

                require(["ChineseDistricts"], function (ChineseDistricts) {

                    citys.each(function () {
                        var that = this, code, find;

                        if (code = ($(that).data("code") || $(that).val())) {
                            code = code + "";
                            var province = "", city = "", district = "";
                            if (find = code.match(/^(\d{2})(\d{2})(\d{2})$/)) {
                                //   console.log(find);
                                if (find[2] == "00" && find[3] == "00") {
                                    province = ChineseDistricts[87][code];
                                } else if (find[2] != "00" && find[3] == "00") {
                                    province = ChineseDistricts[87][find[1] + "0000"];
                                    city = ChineseDistricts[find[1] + "0000"][code];
                                } else {
                                    province = ChineseDistricts[87][find[1] + "0000"];
                                    city = ChineseDistricts[find[1] + "0000"][find[1] + find[2] + "00"];
                                    district = ChineseDistricts[find[1] + find[2] + "00"][code];

                                }
                            }

                            $(that).val("");
                            if (province) {
                                $(that).citypicker({
                                    province: province,
                                    city: city,
                                    district: district

                                });
                                $(that).trigger("cp:updated");
                            } else {
                                $(that).citypicker();
                            }


                        } else {
                            $(that).citypicker();
                        }

                    });
                });


            })
        }
    }
    return out;
});