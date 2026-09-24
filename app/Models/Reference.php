<?php

namespace App\Models;

use Database\Factories\ReferenceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'reference_date'])]
class Reference extends Model
{
    /** @use HasFactory<ReferenceFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reference_date' => 'date',
        ];
    }

    #[Scope]
    protected function newestFirst(Builder $query): void
    {
        $query->orderByDesc('reference_date')->orderByDesc('id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => asset('storage/'.$this->image_path));
    }
}
