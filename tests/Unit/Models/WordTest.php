<?php

namespace Tests\Unit\Models;

use App\Models\Course;
use App\Models\Question;
use App\Models\Role;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $word;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $course = factory(Course::class)->create();
        $this->word = factory(Word::class)->create([
            'course_id' => $course->id,
        ]);
        $role = factory(Role::class)->create();
        $this->user = factory(User::class)->create([
            'role_id' => $role->id,
        ]);
    }

    /**
     * Test table has columns.
     *
     * @return void
     */
    public function test_words_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('words', [
                'id',
                'course_id',
                'name',
                'mean',
            ]),
            1
        );
    }

    /**
     * Test Word mass assignment properties.
     *
     * @return void
     */
    public function test_contains_valid_fillable_properties()
    {
        $this->assertEquals([
            'name',
            'mean',
            'course_id',
        ], $this->word->getFillable());
    }

    public function test_word_belongs_to_course()
    {
        $word = $this->word;

        $this->assertEquals(1, $word->course->count());
        $this->assertInstanceOf(Course::class, $word->course);
    }

    public function test_word_belongs_to_many_users()
    {
        $word = $this->word;

        $this->assertInstanceOf(Collection::class, $word->users);
    }

    public function test_scope_remember_word()
    {
        $word = $this->word;
        $user = $this->user;
        $data = $word->rememberWord($user->id, $word->id)->first();

        // return null if not remember
        $this->assertNull($data);
    }
}