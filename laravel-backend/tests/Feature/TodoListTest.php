<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    /**
     * @test
     */
    public function it_get_all_todo_list(): void
    {
        $response = $this->getJson(route('todo-list.index'));

        $response->assertStatus(200);
    }
}
