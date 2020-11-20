<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrudUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_can_be_created()
    {
        $this->withOutExceptionHandling();

        $response = $this->post(route('users.store'), [
            'name' => 'Johny',
            'lastname' => 'Prieto',
            'email' => 'johnyprieto001@gmail.com',
            'address' => 'Calle 123 45 - 45',
            'password' => bcrypt('johny2020')
        ]);

        $this->assertCount(1, User::all());

        $user = User::first();
        $this->assertEquals($user->name, 'Johny');
        $this->assertEquals($user->lastname, 'Prieto');
        $this->assertEquals($user->email, 'johnyprieto001@gmail.com');

        $response->assertRedirect(route('users.show', $user->id));

    }

    /** @test */
    function list_of_users_can_be_retrieved(){

        $this->withOutExceptionHandling();

        User::factory()->times(3)->create();

        $response = $this->get(route('users.index'));
        $response->assertOk();
        $users = User::all();
        $response->assertViewIs('users.index');
        $response->assertViewHas('users', $users);

    }

    /** @test */
    function an_user_can_be_retrieved(){

        $this->withOutExceptionHandling();

        User::factory()->times(1)->create();

        $user = User::first();
        $response = $this->get(route('users.show', $user->id));
        $response->assertOk();

        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    function a_provider_can_be_updated(){

        $this->withOutExceptionHandling();

        User::factory()->times(1)->create();

        $user = User::first();
        $response = $this->put(route('users.update', $user->id), [
            'name' => 'Juan',
            'lastname' => 'Perez'
        ]);

        $this->assertCount(1, User::all());

        $user = $user->fresh();
        $this->assertEquals($user->name, 'Juan');
        $this->assertEquals($user->lastname, 'Perez');

        $response->assertRedirect(route('users.show', $user->id));
    }

    /** @test */
    function an_user_can_be_deleted(){

        $this->withOutExceptionHandling();

        User::factory()->times(1)->create();

        $user = User::first();
        $response = $this->delete(route('users.destroy', $user->id));

        $this->assertCount(0, User::all());


        $response->assertRedirect(route('users.index'));
    }
}
