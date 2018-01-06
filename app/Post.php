<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;
    const IS_FEATURED = 1;
    const IS_STANDART = 0;

    protected $fillable = ['title', 'content', 'date'];

    /**
     * Связь с категориями один к одному, у одного поста может быть только одна категория
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * Связь с пользователями один к одному, у одного поста может быть только один автор
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Связь с тегами многие ко многим, у поста может быть много тегов, так и один тег может быть у многих постов
     * связующая таблица post_tags.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        )->withTimestamps();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
    */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Добавлние поста
     *
     * @param $fields
     * @return static
    */
    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    /**
     * Редактирование поста
     * @param $fields
     *
    */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    /**
     * Удаление поста
    */
    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    /**
     * Загрузка картинок
     * @param $image
    */
    public function uploadImage($image)
    {
        if ($image == null){ return; }
        $this->removeImage();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    /**
     * Удалить картинку поста
     */
    public function removeImage()
    {
        if($this->image != null)
        {
            Storage::delete('uploads/' . $this->image);
        }
    }
    /**
     * Получить картинку
     * @return string
     */
    public function getImage()
    {
        if($this->image == null)
        {
            return '/img/no-image.png';
        }
        return '/uploads/' . $this->image;
    }

    /** Установить категорию
     * @param $id
     */
    public function setCategory($id)
    {
        if ($id == null) { return ;}
        $this->category_id = $id;
        $this->save();
    }

    /** Установить теги
     * @param $id
    */
    public function setTags($ids)
    {
        if ($ids == null) { return ;}
        $this->tags()->sync($ids);
        $this->save();
    }

    /**
     * Добавить в черновик
     */
    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    /**
     * Сделать публичным
     */
    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    /**
     * Установить статус статьи переключатель
     * @param $value
     */
    public function toggleStatus($value)
    {
        if($value == null)
        {
           return $this->setDraft();
        }
        else
        {
            return $this->setPublic();
        }
    }

    /**
     * Предложение сделать
     */
    public function setFeatured()
    {
        $this->is_featured = Post::IS_FEATURED;
        $this->save();
    }

    /**
     * Обычная статья
     */
    public function setStandart()
    {
        $this->is_featured = Post::IS_STANDART;
        $this->save();
    }

    /**
     * Предложение статьи переключатель
     * @param $value
     */
    public function toggleFeatured($value)
    {
        if($value == null)
        {
            return $this->setStandart();
        }
        else
        {
            return $this->setFeatured();
        }
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }
}


