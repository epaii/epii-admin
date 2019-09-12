


<form role="form" class="epii" method="post" data-form="1" action="{url nodelist add _vendor=1}">

        <div class="form-group">
            <label>节点名称：</label>
            <input type="text" class="form-control" name="name" required placeholder="请输入父节点名称">
        </div>
        <div class="form-group">
        <label for="class">父节点：</label>
        <select class="selectpicker" id="class" name="pid">
            <option value="0">无</option>
            <?php foreach($list as $k=>$v){?>
            <option value="{$v['id']}">{$v['name']}</option>
            <?php }?>
        </select>
        </div>
        <div class="form-group">
            <label>图标：</label>
            <input type="text" class="form-control" name="icon"  id="icon" value="fa fa-circle-o" required style="display: block;width: 58%;height: 38px">
            <a class="btn btn-default btn-dialog"   data-area="95%,100%" title="图标选择" href="?app=nodelist@icon&_vendor=1"  style="width: 84px">更多</a>
        </div>
        <div class="form-group">
            <label>链接地址：</label>
            <input type="text" class="form-control" name="url" placeholder="">
        </div>
        <div class="form-group">
            <label>打开方式：</label>
            <span class="epii-clear"><input type="radio"   name="open_type"  value="0" checked >导航栏,<input type="radio"   name="open_type"  value="1" >新窗口</span>

        </div>
        <div class="form-group">
            <label>备注：</label>
            <input type="text" class="form-control" name="remark" placeholder="请输入备注信息">
        </div>
        <div class="form-group">
            <label>状态：</label>
            <select class="selectpicker"  name="status" required>
                <option value="0">未启用</option>
                <option value="1">启用</option>
            </select>
        </div>
        <div class="form-group">
            <label>排序：</label>
            <input type="number" class="form-control" name="sort" placeholder="释: 数字越大越靠后">
        </div>
        <div class="form-footer">
            <button type="reset" class="btn btn-default">重置</button>
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>


<script>
   function set_icon(icon) {
       document.getElementById('icon').value=icon;
   }
</script>