<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-31
 * Time: 下午5:54
 */

namespace App\Helpers;


use Illuminate\Support\Arr;

class ArrHelper extends Arr
{
    /**
     * Convert array to tree structure
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function array2Tree(array $array, $key = 'parent')
    {
        $new = [];
        foreach ($array as $item) {
            $new[$item[$key]][] = $item;
        }
        $tree = self::createTree($new, $new[0]);
        return $tree;
    }

    private static function createTree(&$list, $parent)
    {
        $tree = [];
        foreach ($parent as $item) {
            if (isset($list[$item['id']])) {
                $item['children'] = self::createTree($list, $list[$item['id']]);
            }
            $tree[] = $item;
        }
        return $tree;
    }
}