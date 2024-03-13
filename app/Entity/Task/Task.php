<?php

namespace App\Entity\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Entity\User\User;
use App\Enums\Task\TaskStatusEnum;
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
final class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $guarded = ['id'];

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'status',
        'created_at'
    ];

    public static function new(CreateTaskDTO $taskDTO): self
    {
        return self::create([
            'user_id' => $taskDTO->userId,
            'title' => $taskDTO->title,
            'description' => $taskDTO->description,
            'category' => $taskDTO->category,
            'status' => TaskStatusEnum::NEW->value,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function edit(UpdateTaskDTO $taskDTO): void
    {
        $this->update([
            'title' => $taskDTO->title,
            'description' => $taskDTO->description,
            'category' => $taskDTO->category,
            'status' => $taskDTO->status->value,
        ]);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
