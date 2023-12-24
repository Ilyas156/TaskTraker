<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 */
class User extends Model
{
    use HasFactory;

    protected $table = 'user';

    public function task()
    {
        return $this->hasMany(Task::class);
    }
}
