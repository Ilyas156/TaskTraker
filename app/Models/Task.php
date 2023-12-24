<?php

namespace App\Models;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property string $category
 * @property string $status
 * @property DateTime $created_at
 * @mixin Builder
 **/
class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'status',
        'created_at'
    ];

    public static function new(CreateTaskRequest $request)
    {
        return self::create([
            'user_id' => 1,
            'title' => $request['title'],
            'description' => $request['description'],
            'category' => $request['category'],
            'status' => (int)$request['status'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function edit(UpdateTaskRequest $request): void
    {
        $this->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'category' => $request['category'],
            'status' => (int)$request['status'],
        ]);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
