<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    const ALLOW = 1;
    const DISALLOW = 0;

    /**
     * один комментарий может быть только у одного поста , а у поста множество комментариев
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Связь с автором у одного пкомментария может быть только один автор. а автор может оставлять множество комментариев
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Разрешить комментарий
     */
    public function allow()
    {
        $this->status = Comments::ALLOW;
        $this->save();
    }

    /**
     * Запретить комментарий
     */
    public function disAllow()
    {
        $this->status = Comments::DISALLOW;
        $this->save();
    }

    /**
     * Переключатель коментария с активного на неактивный
     */
    public function toggleStatus()
    {
        if($this->status == Comments::DISALLOW)
        {
            return $this->allow();
        }
        return $this->disAllow();
    }

    /**
     * Удалить комментарий
     */
    public function remove()
    {
        $this->delete();
    }

}
