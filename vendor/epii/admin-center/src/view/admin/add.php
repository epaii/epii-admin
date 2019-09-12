<div class="content" style="padding: 10px">

    <form role="form"  class="epii" method="post" data-form="1" action="{url admin add _vendor=1}">

        <div class="form-group">
            <label>用戶名：</label>
            <input type="text" class="form-control " name="username" required placeholder="请输入用戶名">

        </div>
        <div class="form-group">
            <label>用户密码：</label>
            <input type="password" class="form-control" name="password" required placeholder="请输入秘密">
        </div>
        <div class="form-group">
            <label>用戶昵称：</label>
            <input type="text" class="form-control" name="group_name" required placeholder="请输入用戶昵称">
        </div>

        <div class="form-group">
            <label for="class">用户状态：</label>
            <select class="selectpicker" id="class" name="status">
                <option value="normal">正常</option>
                <option value="locked">锁定</option>
            </select>
        </div>
        <div class="form-group">
            <label for="class">用户角色：</label>
            <select class="selectpicker" id="class" name="role">
                {foreach $roles $k=>$v}
                <option value="{$v.id}">{$v.name}</option>
                {/foreach}
            </select>
        </div>
        <div class="form-footer">
            <button type="reset" class="btn btn-default">重置</button>
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>

</div>