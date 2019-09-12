<style>
    body {
        background: url("<?php echo  $bg_imgs[0]; ?>");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -moz-background-size: 100% 100%;
    <?php  if(count($bg_imgs)==4): ?>
        animation-name: myfirst;
    <?php endif; ?>
        animation-duration: 30s;
        /*变换时间*/
        animation-delay: 1s;
        /*动画开始时间*/
        animation-iteration-count: infinite;
        /*下一周期循环播放*/
        animation-play-state: running;
        /*动画开始运行*/
    }
<?php  if(count($bg_imgs)==4): ?>

    @keyframes myfirst {
        0% {
            background: url("<?php  echo $bg_imgs[0]; ?>");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            -moz-background-size: 100% 100%;
        }
        34% {
            background: url("<?php echo  $bg_imgs[1]; ?>");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            -moz-background-size: 100% 100%;
        }
        67% {
            background: url("<?php echo  $bg_imgs[2]; ?>");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            -moz-background-size: 100% 100%;
        }
        100% {
            background: url("<?php echo  $bg_imgs[3]; ?>");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            -moz-background-size: 100% 100%;
        }
    }
    <?php endif; ?>

    .form-bg{
        background: #00b4ef;
    }
    .form-horizontal{
        background: rgba(255,255,255,0.5);
        padding-bottom: 70px;
        border-radius: 15px;
        text-align: center;
        margin-top:80px;
    }
    .form-horizontal .heading{
        display: block;
        font-size: 35px;
        font-weight: 700;
        padding: 35px 0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 30px;
    }
    .form-horizontal .form-group{
        padding: 0 40px;
        margin: 0 0 25px 0;
        position: relative;
    }
    .form-horizontal .form-control{
        background: #f0f0f0;
        border: none;
        border-radius: 20px;
        box-shadow: none;
        padding: 0 20px 0 45px;
        height: 40px;
        transition: all 0.3s ease 0s;
    }
    .form-horizontal .form-control:focus{
        background: #e0e0e0;
        box-shadow: none;
        outline: 0 none;
    }
    .form-horizontal .form-group i{
        position: absolute;
        top: 12px;
        left: 60px;
        font-size: 17px;
        color: #c8c8c8;
        transition : all 0.5s ease 0s;
    }
    .form-horizontal .form-control:focus + i{
        color: #00b4ef;
    }
    .form-horizontal .fa-question-circle{
        display: inline-block;
        position: absolute;
        top: 12px;
        right: 60px;
        font-size: 20px;
        color: #808080;
        transition: all 0.5s ease 0s;
    }
    .form-horizontal .fa-question-circle:hover{
        color: #000;
    }
    .form-horizontal .main-checkbox{
        float: left;
        width: 20px;
        height: 20px;
        background: #11a3fc;
        border-radius: 50%;
        position: relative;
        margin: 5px 0 0 5px;
        border: 1px solid #11a3fc;
    }
    .form-horizontal .main-checkbox label{
        width: 20px;
        height: 20px;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }
    .form-horizontal .main-checkbox label:after{
        content: "";
        width: 10px;
        height: 5px;
        position: absolute;
        top: 5px;
        left: 4px;
        border: 3px solid #fff;
        border-top: none;
        border-right: none;
        background: transparent;
        opacity: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }
    .form-horizontal .main-checkbox input[type=checkbox]{
        visibility: hidden;
    }
    .form-horizontal .main-checkbox input[type=checkbox]:checked + label:after{
        opacity: 1;
    }
    .form-horizontal .text{
        float: left;
        margin-left: 7px;
        line-height: 20px;
        padding-top: 5px;
        text-transform: capitalize;
    }
    .form-horizontal .btn{
        float: right;
        font-size: 18px;
        color: #fff;
        background: #00b4ef;
        border-radius: 30px;
        padding: 10px 25px;
        border: none;
        text-transform: capitalize;
        transition: all 0.5s ease 0s;
    }
    @media only screen and (max-width: 479px){
        .form-horizontal .form-group{
            padding: 0 25px;
        }
        .form-horizontal .form-group i{
            left: 45px;
        }
        .form-horizontal .btn{
            padding: 10px 20px;
        }
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-5 m-auto p5">
            <form class="form-horizontal" data-form="1" method="post">
                <span class="heading"><?php echo $title; ?></span>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="<?php echo $config_value["username_tip"]; ?>" required>
                    <i class="fa fa-user"></i>
                </div>
                <div class="form-group help">
                    <input type="password" class="form-control"  name="password" placeholder="<?php echo $config_value["password_tip"]; ?>" required>
                    <i class="fa fa-lock"></i>
                    <a href="#" class="fa fa-question-circle"></a>
                </div>
                <div class="form-group">

                    <button type="submit" class="btn btn-default"><?php echo $config_value["btn_msg"]; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>