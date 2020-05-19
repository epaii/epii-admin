 <div class="content">

     <div class="card-body table-responsive" style="padding-top: 0px">
         <table data-table="1" data-url="{url addons ajaxdata _vendor=1}" id="table1" class="table table-hover">
             <thead>
                 <tr>

                     <th data-field="name" data-formatter="epiiFormatter">name</th>
                     <th data-field="title" data-formatter="epiiFormatter">title</th>
                     <th data-field="description" data-formatter="epiiFormatter">说明</th>
                     <th data-field="version" data-formatter="epiiFormatter">版本</th>
                     <th data-field="addtime" data-formatter="epiiFormatter">安装时间</th>
                     <th data-field="status" data-formatter="epiiFormatter.switch" data-align="center"> 开启状态</th>
                     <th data-field="install" data-formatter="epiiFormatter.switch" data-align="center"> 安装状态</th>
                     <th data-field="" data-formatter="install" data-align="center"> 安装</th>
                     <th data-field="" data-formatter="status" data-align="center"> 状态</th>
                   
                     <th data-field="" data-formatter="config"    data-align="center"> 配置</th>
                 </tr>
             </thead>
         </table>
     </div>

 </div>
 <script>
     function install(field_value, row, index, field_name) {
         if (row.install) {
             return "已经安装";
         } else {
             return "<a class='btn btn-outline-info btn-sm btn-confirm' data-ajax='1' data-msg=\"确定安装吗?\"  href='?app=addons@install&_vendor=1&name=" + row.name + "'>安装</a>";
         }
     }
     function config(field_value, row, index, field_name) {
         if (!row.install) {
             return "未安装";
         } else {
             return "<a class='btn btn-outline-info btn-sm btn-dialog' data-area='90%,90%' data-title='配置'   href='?app=config&_vendor=1&addons_id=" + row.__data.id +"'>配置</a>";
         }
     }
     function status(field_value, row, index, field_name) {
        if (!row.install) {
             return "未安装";
         } 
         if (row.status-1==0) {
            return "<a class='btn btn-outline-danger btn-sm btn-confirm' data-ajax='1' data-msg=\"确定关闭吗?\"  href='?app=addons@status&status=0&_vendor=1&name=" + row.name + "'>关闭</a>";
         } else {
             return "<a class='btn btn-outline-info btn-sm btn-confirm' data-ajax='1' data-msg=\"确定开启吗?\"  href='?app=addons@status&status=1&_vendor=1&name=" + row.name + "'>开启</a>";
         }
     }
 </script>