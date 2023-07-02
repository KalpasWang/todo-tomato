<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;
    public function setUp(): void
    {
        parent::setUp();
        $this->list = $this->createTodoList(['title' => 'test list']);
    }

    public function createTodoList($options = [])
    {
        return TodoList::factory()->create($options);
    }
    /**
     * @test
     */
    public function it_get_all_todo_list(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('todo-list.index'));

        $response->assertOk();
        $this->assertCount(1, $response->json());
        // dd($this->list);
        $this->assertEquals($this->list->title, $response->json()[0]['title']);
    }
}
