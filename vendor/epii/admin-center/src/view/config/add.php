
        <form role="form"
              method="post"
              data-form="1"
              class="epii"
              action="{url config add _vendor=1}&addons_id={? $_view.get.addons_id}">

            <div class="form-group">
                <label>属性:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>值:</label>
                <input type="text" class="form-control" name="value" required>
            </div>


            <div class="form-group">
                <label>提示:</label>
                <input type="text" class="form-control" name="tip" required>

            </div>
            <br>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary">提交</button>
                <button type="reset" class="btn btn-default">重置</button>
            </div>
        </form>

