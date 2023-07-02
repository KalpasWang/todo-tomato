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
        $this->list = $this->create2TodoList();
    }

    public function create2TodoList()
    {
        return TodoList::factory()->count(2)->create();
    }

    /**
     * @test
     */
    public function it_get_all_todo_list(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('todo-list.index'));

        $response->assertOk();
        $this->assertCount(2, $response->json());
        $this->assertEquals($this->list[0]->title, $response->json()[0]['title']);
        $this->assertEquals($this->list[1]->title, $response->json()[1]['title']);
    }

    /**
     * @test
     */
    public function it_get_single_todo_list(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('todo-list.show', $this->list[0]->id));

        $response->assertOk();
        $this->assertEquals($this->list[0]->title, $response->json()['title']);
        $this->assertEquals($this->list[0]->id, $response->json()['id']);
    }
}
