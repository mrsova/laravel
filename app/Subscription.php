<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * Создать подписчика
     * @param $email
     * @return static
     */
    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->save();
        return $sub;
    }

    public function generateToken()
    {
        $this->token = str_random(100);
        $this->save();
    }

    /**
     * Удалить подписчика
     */
    public function remove()
    {
        $this->delete();
    }
}
