<?php

namespace App\Components;

/**
 * Class UniqueIdGenerator
 */
class UniqueIdGenerator
{

    /**
     * @param int $length
     * @param string $keyspace
     * @return string
     * @throws \Exception
     */
    public function generateUniqueId(
        $length = 40,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}
