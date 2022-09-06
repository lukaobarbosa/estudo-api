<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanBeCreated()
    {
        //arrange
        $user = ['name'=> 'marcos', 'email' => 'marcos@gamil.com', 'password' => 'password'];
        //act
        $response = $this->post('/api/user', $user);
        //assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', $user);
    }

    public function testUserCreationFieldMustBeRequired()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/user', compact($user));
        $response->assertSessionHasErrors();
    }

    public function testAllUsersShouldBeRetrieveFromDatabase()
    {
        $user = User::factory()->count(6)->create();
        $response = $this->get('/api/user');
        $response->assertJson(compact($user));
    }

    public function testSingleUserShouldBeRetrieveFromDatabase()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/user/'. $user->id,);
        $response->assertOk();
        $response->assertJson(['name' => $user->name]);
    }

    public function testUserCanBeDeleted()
    {
        $user = User::factory()->create();
        $response = $this->delete('/api/user/'. $user->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', compact($user));
    }

    public function testUserCanBeUpgraded()
    {
        $user = User::factory()->create();
        $response = $this->put('/api/user/'. $user->id, [
            'name' => 'Beto',
            'email' => 'betao@gmail.com'
        ]);
        $response->assertJson(['updated']);
        $this->assertDatabaseHas('users', [
            'name' => 'Beto',
            'email' => 'betao@gmail.com'
        ]);
    }

    public function testUserUpdateFieldsMustBeRequired()
    {
        $user  = User::factory()->create();
        $updatedUser = $user->update(['email' => 'marcao@gmail.com']);
        $response = $this->put('/api/user/'. $user->id, compact($updatedUser));
        $response->assertSessionHasErrors();
    }
}
