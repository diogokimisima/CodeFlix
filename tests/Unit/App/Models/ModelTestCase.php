<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function casts(): array;

    public function testIfUseTraits()
    {
        $traitsNeed = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));

        foreach ($traitsNeed as $trait) {
            $this->assertContains($trait, $traitsUsed);
        }
    }

    public function testFillable()
    {
        $expectedFillable = $this->fillables();

        $fillable = $this->model()->getFillable();

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function testIncrementingIsFalse()
    {
        $model = $this->model();

        $this->assertFalse($model->incrementing);
    }

    public function testHasCasts()
    {
        $expectedCasts = $this->casts();

        $casts = $this->model()->getCasts();

        $this->assertEquals($expectedCasts, $casts);
    }
}
