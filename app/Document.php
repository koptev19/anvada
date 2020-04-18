<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    /**
     * Константа с набором всевозможных статусов документа
     *
     * @const array
     */
	const STATUSES = ['draft' => 'draft', 'published' => 'published'];
    
    /**
     * Обновляемые поля
     *
     * @var array
     */
	protected $fillable = ['payload', 'status'];

    /**
     * Устанавливает отсутствие автоинкриментного поля
     *
     * @return false
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Тип ключевого поля - строка
     *
     * @return 'string'
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Декодирует строку свойства payload из json в объектный вид
     *
     * @param  string  $value
     * @return \stdClass
     */
	public function getPayloadAttribute($value)
	{
		return json_decode($value);
	}

    /**
     * Устанавливает свойство payload в формат json для записи в базу
     *
     * @param \stdClass $value
     * @return string
     */
	public function setPayloadAttribute($value)
	{
		$this->attributes['payload'] = json_encode($value);
	}


}
