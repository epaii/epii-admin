
    <form action="{url rolelist nav _vendor=1}"
          method="post" data-form="1"
    >



        <ul class="list-group" style="padding: 20px">
            <div  >{foreach $nodes $key=>$value}<?php if ($value['pid'] != 0) { ?>
                    <input type="checkbox"
                           value="{$value.id}"

                           name="nodes[]" {if in_array($value["id"],$node_array) } checked {/if} style="margin-right: 3px"><span style="margin-right: 10px">{$value.name}</span><?php } else { ?></div><div><span style="color: blue;margin-right: 20px">{$value.name}:</span>  {if $value["url"]}<input type="checkbox" value="{$value.id}" name="nodes[]" {if in_array($value["id"],$node_array) } checked {/if} style="margin-right: 3px">{$value.name}{/if}  <?php } ?>{/foreach}
            </div>

        </ul>

            <input type="hidden" name="id" value="{$id}">

        <div class="form-footer">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>

