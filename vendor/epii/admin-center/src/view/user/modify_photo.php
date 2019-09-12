<section class="col-md-12 	col-sm-12 col-xl-12 col-sm-12" style="padding: 10px">
    <div>
        <form action="{url user upload_path _vendor=1}" method="post" id="form" data-form="1">
            <input type="hidden" id="id1" value="" name="path">

        <div>
            <small style="color: #c69500">文件格式为.jpg .png .gif,大小限制2M</small>
        </div>
        <div>
            <img src="" id="show1" >
        </div>
        <button class="btn btn-default"
                data-upload="1"
                id="btn1"
                data-input-id="id1"
                data-img-id="show1"
                data-img-style="width:200px;height:200px">选择</button>
            <input type="submit" class="btn btn-success">
        </form>
    </div>

</section>