<?php
/**
 * Created by PhpStorm.
 * User: mrren
 * Date: 2019/9/19
 * Time: 3:17 PM
 */

namespace epii\orm;

class Db extends \think\Db
{

    public static function transaction(callable $callback)
    {
        \think\Db::startTrans();
        $result = null;
        try {

            if (is_callable($callback)) {
                $result = call_user_func($callback);
            }

            if ($result) \think\Db::commit();

        } catch (\Exception $e) {


        } catch (\Throwable $e) {


        }
        if (!$result)
            \think\Db::rollback();
        return $result;
    }
}