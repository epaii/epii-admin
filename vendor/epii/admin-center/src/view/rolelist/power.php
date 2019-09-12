<form action="{url rolelist power _vendor=1}"
      method="post" data-form="1"
      style="padding: 10px"
      class="epii">


    <div >
        <label>权限方式：</label>
        <span class="epii-field">包含<input style="width: 20px" type="radio"
                                          name="type"
                                          {if $type == 1}
                                          checked
                                          {/if}
               value="1">,
        排除<input type="radio" style="width: 20px"
               name="type"
               {if $type == 2}
               checked
               {/if}
               value="2">  </span>

    </div>

    <ul class="list-group">


        {foreach $list $key=>$value}

        <li class="list-group-item">类名:{$key}

            <input type="checkbox"
                   value="{$key}"
                   disabled="disabled"
                   id="{:str_replace,\\ ,_,$key}"
                <?php
                if (isset($power[$key])) {
                    ?>
                    checked
                    <?php
                }
                ?>
            >
            <br>
            方法名:
            {foreach $value $k=>$v}
            {$v}
            <input type="checkbox"
                   value="{$v}"
                   name="power[{$key}][]"
                <?php
                if (isset($power[$key][$v])) {
                    ?>
                    checked
                    <?php
                }
                ?>
                   pid="{:str_replace,\\ ,_,$key}" onclick="docheck(this);">
            {/foreach}
        </li>

        {/foreach}
    </ul>
    <div class="form-group">
        <input type="hidden" name="id" value="{$id}">
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
</ul>

<script>
    function docheck(obj) {
        var obj = $(obj);
        //if (obj.attr("checked"))


        var pid = obj.attr("pid");
       if( $("input[pid='"+pid+"']:checked").length-0>0){
            $("#"+pid).attr("checked","checked");
       }else{
           $("#"+pid).attr("checked",false);
       }

    }
</script>
