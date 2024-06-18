<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     type="object",
 *     title="Contact",
 *     required={"name", "phone"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *      @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="integer",
 *         example="1234567890"
 *     ),
 *      @OA\Property(
 *         property="marked",
 *         type="boolean",
 *         example="false"
 *     ),
 * )
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'name',
        'marked',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
