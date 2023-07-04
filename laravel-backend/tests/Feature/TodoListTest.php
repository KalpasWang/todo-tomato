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

    /**
     * @test
     */
    public function it_save_new_todo_list(): void
    {
        $this->withoutExceptionHandling();
        $list = TodoList::factory()->make();
        $response = $this->postJson(route('todo-list.store', ['title' => $list->title]));

        $body = $response->assertCreated()->json();
        $this->assertEquals($list->title, $body['title']);
        $this->assertDatabaseHas('todo_lists', ['title' => $list->title]);
    }

    /**
     * @test
     */
    public function it_update_todo_list(): void
    {
        $this->withoutExceptionHandling();
        // 執行
        $response = $this->patchJson(route('todo-list.update', $this->list[0]->id), ['title' => 'new title']);
        // 驗證
        $body = $response->assertOk()->json();
        $list = TodoList::find($body['id']);
        $this->assertEquals($body['title'], 'new title');
        $this->assertDatabaseHas('todo_lists', ['id' => $list->id, 'title' => 'new title']);
    }
}
