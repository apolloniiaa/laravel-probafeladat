<?php

namespace App\Models;

use Database\Factories\HeroSectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description'])]
class HeroSection extends Model
{
    /** @use HasFactory<HeroSectionFactory> */
    use HasFactory;

    protected $attributes = [
        'title' => 'Tárgyak, amelyek kiállják az idő próbáját',
        'description' => 'Letisztult ipari formatervezés a koncepciótól a sorozatgyártásig — felesleges díszítés nélkül.',
    ];

    public static function current(): self
    {
        return static::query()->firstOrNew();
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->image_path
            ? asset('storage/'.$this->image_path)
            : asset('images/hero.png'));
    }
}
