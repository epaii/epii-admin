
    <form role="form" class="epii" method="post" data-form="1" action="{url admin edit _vendor=1}">

        <div class="form-group">
            <label>用戶名：</label>
            <input type="text" class="form-control" name="username" value="{$admin.username}" required
                   placeholder="请输入用戶名">
        </div>
        <div class="form-group">
            <label>用户密码：</label>
            <input type="password" class="form-control" name="password"  placeholder="请输入密码,不修改密码留空
">
        </div>
        <div class="form-group">
            <label>用戶昵称：</label>
            <input type="text" class="form-control" name="group_name" value="{$admin.group_name}" required
                   placeholder="请输入用戶昵称">
        </div>
        <div class="form-group">
            <label for="class">用户状态：</label><br>
            <select class="selectpicker" id="class" name="status">

                <option value="normal" <?php if($admin['status'] == 'normal'){ ?> selected <?php } ?>>正常</option>
                <option value="locked" <?php if($admin['status'] == 'locked'){ ?> selected <?php } ?>>锁定</option>

            </select>
        </div>
        <div class="form-group">
            <label for="class">用户角色：</label><br>
            <select class="selectpicker" id="class" name="role">
                {foreach $roles $k=>$v}
                <option value="{$v.id}">{$v.name}</option>
                {/foreach}
            </select>
        </div>
        <div class="form-group">
            <input type="hidden" name="id" value="{$id}">
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
