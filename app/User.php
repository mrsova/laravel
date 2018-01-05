<?php

namespace App;

use function bcrypt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

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
        'name', 'email',
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
     * Сгенерировать пароль пользователя
     * @param $password
     */
    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
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
        $this->save();
    }

    /**
     * Удаление пользователя
     */
    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    /**
     * Загрузить аваатар пользователя
     * @param string $imagesaf
    */
    public function uploadAvatar($image)
    {
        if ($image == null){ return; }
        $this->removeAvatar();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    /**
     * Удалить аватарку пользователя
     */
    public function removeAvatar()
    {
        if($this->avatar != null)
        {
            Storage::delete('uploads/' . $this->avatar);
        }
    }

    /**
     * Получить Аватар
     * @return string
     */
    public function getImage()
    {
        if($this->avatar == null)
        {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->avatar;
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
