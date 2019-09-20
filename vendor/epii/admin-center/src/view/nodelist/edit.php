<form role="form" class="epii" method="post" data-form="1" action="{url nodelist edit _vendor=1}">
    <input type="hidden" value="{$id}" name="id">
    <?php if (!isset($_GET["inhome"])) $_GET["inhome"] = 0; ?>
    <input type="hidden" value="{$_GET.inhome}" name="inhome">
    <div class="form-group">
        <label>节点名称：</label>
        <input type="text" class="form-control" name="name" value="{$nodeinfo.name}" placeholder="请输入父节点名称" required>
    </div>
    <div class="form-group">
        <label for="class">父节点：</label>
        <select class="selectpicker" id="class" name="pid">
            <option value="0" <?php if ($nodeinfo['pid'] == 0){ ?>selected="selected"<?php } ?>>无</option>
            {:options,$list,$nodeinfo['pid']}

        </select>
    </div>
    <div class="form-group">
        <label>打开方式：</label>
        <span class="epii-clear"><input type="radio" name="open_type" value="0"
                                        <?php if ($nodeinfo['open_type'] == 0){ ?>checked<?php } ?> >导航栏,<input
                    type="radio" name="open_type" value="1" <?php if ($nodeinfo['open_type'] == 1){ ?>checked<?php } ?>>新窗口</span>
    </div>
    <div class="form-group">
        <label>图标：</label>
        <input type="text" class="form-control" name="icon" id="icon" value="{$nodeinfo.icon}" required
               style="display: block;width: 58%;height: 38px">
        <a class="btn btn-default btn-dialog" data-area="95%,100%" title="图标选择" href="?app=nodelist@icon&_vendor=1"
           style="width: 84px">更多</a>
    </div>
    <div class="form-group">
        <label>右侧badge类：</label>
        <input type="text" class="form-control" name="badge_class" id="badge_class" value="{$nodeinfo.badge_class}"
               placeholder="类全称必须继承epii\admin\center\config\IBadgeInfo">

    </div>

    <div class="form-group">
        <label>链接地址：</label>
        <input type="text" class="form-control" name="url" id="icon" value="{$nodeinfo.url}"
               placeholder="如:?app=config@index&_vendor=1,没有父级不填">
    </div>
    <div class="form-group">
        <label>备注：</label>
        <input type="text" class="form-control" name="remark" value="{$nodeinfo.remark}" placeholder="请输入备注信息">
    </div>
    <div class="form-group">

        <label>状态：</label>
        <select class="selectpicker" name="status" required>
            <option value="0" <?php if ($nodeinfo['status'] == 0){ ?>selected="selected" <?php } ?>>未启用</option>
            <option value="1" <?php if ($nodeinfo['status'] == 1){ ?>selected="selected"<?php } ?>>启用</option>
        </select>
    </div>
    <div class="form-group">
        <label>排序：</label>
        <input type="number" class="form-control" name="sort" value="{$nodeinfo.sort}" placeholder="释: 数字越大越靠后">
    </div>

    <div class="form-footer">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    function set_icon(icon) {
        document.getElementById('icon').value = icon;
    }
</script>