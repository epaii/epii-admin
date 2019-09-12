<section class="col-md-12 	col-sm-12 col-xl-12 col-sm-12" style="padding: 10px">
    <form role="form" data-form="1" method="post" action="{url user modify_info _vendor=1}"
          data-before-submit="confirm" data-msg="你确定修改吗?">
        <table class="table">
            <tr>
                <th colspan="2">资料修改</th>
                <th></th>
            </tr>
            <tr>
                <td>用户名</td>
                <td>{$user.username}</td>
            </tr>
            <tr>
                <td>用户昵称</td>
                <td><input type="text" class="form-control" name="group_name" value="{$user.group_name}"
                           required maxlength="50">
                </td>
            </tr>

            <tr>
                <td>用户手机号</td>
                <td><input type="text" class="form-control" name="phone" value="{$user.phone}" id="phone" maxlength="11" v
                           required></td>
            </tr>
            <tr>
                <td>用户邮箱</td>
                <td><input type="text" class="form-control" name="email" value="{$user.email}" id="email" maxlength="50"
                          required></td>
            </tr>

            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i>修改</button>
                    <button type="reset" class="btn btn-sm btn-outline-warning"><i class="fa fa-reply-all"></i>重置
                    </button>
                </td>
                <td></td>
            </tr>

        </table>
    </form>
</section>