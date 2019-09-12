<section class="col-md-12 	col-sm-12 col-xl-12 col-sm-12" style="padding: 10px">

    <form role="form"   data-form="1"  method="post"  action="{url user modify_pwd _vendor=1}" >

        <div class="form-group" style="width: 70%">
            <label >原密码</label>
            <input type="password" class="form-control" name="old_password"  autofocus="autofocus" placeholder="请输入原密码" required>
            <div id="old_password"></div>
        </div>
        <div class="form-group" style="width: 70%">
            <label >新密码</label>
            <input type="password" class="form-control" name="new_password"  placeholder="请输入新密码" required>
            <div id="new_password"></div>
        </div>
        <div class="form-group" style="width: 70%">
            <label >确认密码</label>
            <input type="password" class="form-control" name="re_password"  placeholder="请再次输入" required>
            <div id="re_password"></div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-sm btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i>确定</button>
            <button type="reset" class="btn btn-sm btn-outline-warning"><i class="fa fa-reply-all" aria-hidden="true"></i>重置</button>
        </div>

    </form>

    <script>
        function to_login() {
            window.top.location.reload();
        }
    </script>
</section>
