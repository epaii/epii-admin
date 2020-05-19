<section class="content" style="padding: 10px">
 
    <div class="content">
        <div class="card-body table-responsive" style="padding-top: 0px">
            <a class="btn  btn-outline-primary btn-table-tool btn-dialog" href="{url config add _vendor=1}&addons_id={? $_view.get.addons_id}" data-area="40%,40%" title="新增配置">新增配置</a>
        </div>
        <div class="card-body table-responsive" style="padding-top: 0px">
            <table data-table="1" data-url="{url config ajaxdata _vendor=1}&addons_id={? $_view.get.addons_id}" id="table1" class="table table-hover">
                <thead>
                <tr>
                    <th data-field="name" data-formatter="epiiFormatter">属性</th>
                    <th data-field="value" data-formatter="epiiFormatter">值</th>
                    <th data-field="tip" data-formatter="epiiFormatter">提示</th>
                    <th data-formatter="epiiFormatter.btns"
                        data-btns="edit1,del1"
                    >操作
                    </th>
                </tr>
                </thead>
            </table>

        </div>
    </div>
    <script>
        function edit1(field_value, row, index,field_name) {

            return "<a class='btn btn-outline-info btn-sm btn-dialog'   data-area=\"40%,40%\" data-title='编辑' href='?app=config@edit&_vendor=1&id="+row.id+"+'><i class='fa fa-pencil-square-o' ></i>编辑</a>";
        }
        function del1(field_value, row, index,field_name) {
            if(row.type ==2){
                return "<a class='btn btn-outline-danger btn-sm btn-confirm' data-ajax='1' data-msg=\"确定删除吗?\"  href='?app=config@del&_vendor=1&id="+row.id+"+'><i class='fa fa-trash' ></i>删除</a>";
            }else{
                return "";
            }
        }
    </script>
</section>