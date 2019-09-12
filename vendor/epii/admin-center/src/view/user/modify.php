<section class="content col-md-8" style="padding: 10px">
    <h3>个人资料</h3>
    <table class="table table-bordered">
        <tr>
            <td>用户头像</td>
            <td> <img src="<?php use think\Db;
                use wangshouwei\session\Session;
                $photo = Db::name('admin')->where('id',Session::get('user_id'))->value('photo');
                echo $photo ?:'http://epii.gitee.io/epiiadmin/img/user2-160x160.jpg'; ?>"
                      style="width: 100px;height: 100px;border-radius: 50%"
                ></td>
            <td><a class="btn btn-default btn-dialog"
                   href="{url user modify_photo _vendor=1}&id={$user.id}"
                   data-area="50%,50%"
                   data-title="修改头像"
                >更换头像</a></td>
        </tr>
        <tr>
            <td>用户名</td>
            <td>{$user.username}</td>
            <td rowspan="5">
                <a class="btn btn-default btn-dialog"
                   href="{url user modify_info _vendor=1}&id={$user.id}"
                   data-area="50%,50%"
                   data-title="更改资料"
                >更改资料</a>
                <a class="btn btn-default btn-dialog"
                   href="{url user modify_pwd _vendor=1}&id={$user.id}"
                   data-area="50%,50%"
                   data-title="更改密码"
                >更改密码</a>
            </td>
        </tr>
        <tr>
            <td>用户昵称</td>
            <td>{$user.group_name}
            </td>
        </tr>

        <tr>
            <td>用户手机号</td>
            <td>{$user.phone}</td>
        </tr>
        <tr>
            <td>用户邮箱</td>
            <td>{$user.email}</td>
        </tr>

        <tr>
            <td>注册时间</td>
            <td><?php echo date('Y-m-d H:i:s',$user['add_time']) ?></td>

        </tr>
    </table>
        </form>

</section>