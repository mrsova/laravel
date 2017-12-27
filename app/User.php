<?php

namespace App;

use function bcrypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const IS_ADMIN = 1;
    const NOT_ADMIN = 0;
    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Связь с постом один ко многим у одного пользователя может быть много созданных постов
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Сваязь с комментариями один ко многим, один пользователь может оставить множество комментариев
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Добавлние пользователя
     *
     * @param $fields
     * @return static
     */
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();
        return $user;
    }

    /**
     * Редактирование пользователя
     * @param $fields
     *
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    /**
     * Удаление пользователя
     */
    public function remove()
    {
        $this->delete();
    }

    /**
     *
     * @param string $imagesaf
     */
    public function uploadAvatar($image)
    {
        if ($image == null){ return; }
        Storage::delete('uploads/' . $this->image);
        $filename = str_random(10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    /**
     * Получить Аватар
     * @return string
     */
    public function getImage()
    {
        if($this->image == null)
        {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->image;
    }

    /**
     * Дать пользователю доступ в админку
     */
    public function makeAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
    }

    /**
     * Обычный пользователь
     */
    public function makeNormal()
    {
        $this->is_admin = User::NOT_ADMIN;
    }

    /**
     * Переключатель с обычного на админа
     * @param $value
     */
    public function toggleAdmin($value)
    {
        if($value == null)
        {
            return $this->makeNormal();
        }

        return $this->makeAdmin();
    }

    /**
     * Забанить пользователя
     */
    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    /**
     * Разбанить пользователя
     */
    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    /**
     * Переключатель БАНА
     * @param $value
     */
    public function toggleBan($value)
    {
        if($value == null)
        {
            return $this->unban();
        }

        return $this->ban();
    }
}
