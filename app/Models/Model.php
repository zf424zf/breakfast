<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 6/24/15
 * Time: 3:27 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as baseModel;

/**
 * App\Http\Models\Model
 *
 * @mixin \Eloquent
 */
class Model extends baseModel
{

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        if (!$this->table) {
            $baseNameSpace = 'App\Models\\';
            $class = str_replace($baseNameSpace, '', get_called_class());
            $this->table = strtolower(str_replace('\\', '_', $class));
        }
        $prefix = config('database.connections.mysql.prefix');
        if (starts_with($this->table, $prefix)) {
            $this->table = str_replace($prefix, '', $this->table);
        }
        parent::__construct($attributes);
    }

    /**
     * 指定时间字符
     * @param  DateTime|int $value
     * @return string
     */
    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }

}