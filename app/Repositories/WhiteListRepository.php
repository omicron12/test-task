<?php

namespace App\Repositories;

use App\Models\WhiteLists;

class WhiteListRepository
{
    public static function add(iterable $ids, string $keyHash): void
    {
        foreach ($ids as $id) {
            WhiteLists::create(
                [
                    'article' => $id,
                    'key_hash' => $keyHash,
                ]
            );
        }
    }

    public static function remove(iterable $ids, string $keyHash): void
    {
        foreach ($ids as $id) {
            WhiteLists::article($id, $keyHash)->delete();
        }
    }
}
