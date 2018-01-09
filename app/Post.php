<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Post
 * @package App
 */
class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 1;
    const IS_PUBLIC = 0;
    const IS_FEATURED = 1;
    const IS_STANDART = 0;

    protected $fillable = ['title', 'content', 'description', 'date'];

    /**
     * Связь с категориями, принадлежит к одной категории, а категория пренадлежит к множетву постов
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Связь с пользователями, принадлежит к одному автору
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        if ($id == null) {return;}
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
        if(!$value == null)
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

    /**
     * Сет метод меняем формат даты при записи в базу
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    /**
     * get метод меняем формат при выводе из базы
     * @param $value
    */
    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }

    /**
     * Получить категорию поста
     * @return string
     */
    public function getCategoryTitle()
    {
        return ($this->category != null) ? $this->category->title : 'Нет категории';
    }

    /**
     * Получить теги связанные с постом
     * @return string
     */
    public function getTagsTitles()
    {
        return (!$this->tags->isEmpty()) ? implode(', ', $this->tags->pluck('title')->all()) : 'Теги не установлены';
    }

    public function getCategoryID()
    {
        return ($this->category != null) ? $this->category->id : 0;
    }
}


