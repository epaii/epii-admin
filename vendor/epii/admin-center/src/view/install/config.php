<form class="form-horizontal epii" data-form="1" style="margin-top: -20px" method="post"  action="?app=install@config">
    <div class="card-body">
        <div class="form-group">
            <label for="hostname" class="control-label">数据库Ip:</label>
            <input type="text" class="form-control" id="hostname" name="hostname" placeholder="hostname" required value="">

        </div>

        <div class="form-group">
            <label for="hostport" class="control-label">端口号:</label>

           <input type="text" class="form-control" style="width: 100px" id="hostport" name="hostport" placeholder="hostport" value="3306" required>

        </div>
        <div class="form-group">
            <label for="username" class="control-label">数据库用户:</label>

            <input type="text" class="form-control" id="username" name="username" placeholder="username" required value="">

        </div>
        <div class="form-group">
            <label for="password" class="control-label">数据库密码:</label>
           <input type="text" class="form-control" id="password"  name="password" placeholder="password" required value="">

        </div>
        <div class="form-group">
            <label for="database" class="control-label">数据库名称:</label>

                <input type="text" class="form-control" id="database" name="database" placeholder="database" required value="">

        </div>
        <div class="form-group">
            <label for="prefix" class="control-label">表前缀:</label>


                <input type="text" class="form-control" id="prefix" name="prefix" placeholder="prefix" value="epii_" required>

        </div>

        <div class="form-group">
            <label class="control-label">管理员账号:</label>

                <input type="text" class="form-control"   name="admin_username" placeholder="管理员账号" required value="admin">

        </div>
        <div class="form-group">
            <label   class="control-label">管理员密码:</label>


                <input type="text" class="form-control"   name="admin_password" placeholder="管理员密码" value="" required>

        </div>
    </div>
    <!-- /.card-body -->
    <div style="text-align: center;">
        <div style="width: 40%;margin: auto"><button type="submit" class="btn btn-block  btn-outline-primary btn-lg"   data-area="50%,70%" data-title="配置">下一步</button></div>


    </div>
    <!-- /.card-footer -->
</form>