<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Translation",
 *     type="object",
 *     required={"key", "content", "locale"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="key", type="string"),
 *     @OA\Property(property="content", type="string"),
 *     @OA\Property(property="locale", type="string"),
 *     @OA\Property(property="tags", type="array", @OA\Items(type="string"))
 * )
 */

class Translation extends Model
{
    use HasFactory;

    protected $fillable = ["key",'locale','content'];
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
