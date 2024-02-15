<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tests\TestCase;

class UserApiTest extends TestCase
{
    //para que pase la prueba se debe tener el registro de: 
    //email:  admin@example.com
    //password: admin123
    //en la tabla users, si no se tiene se debe ejecutar el comando:
    //usa: php artisan db:seed --class=UsersTableSeeder 
    public function testLoginWithValidCredentials()
    {
        // Realiza una solicitud POST a la ruta de inicio de sesión
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        // Verifica que la solicitud fue exitosa (código de estado 200)
        $response->assertStatus(200);
    }
    public function testCreateUserByAdmin()
    {
        // Autenticar un usuario con privilegios de administrador
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true,
        ]);
        $token = JWTAuth::fromUser($admin);

        // Realizar una solicitud POST a la ruta de creación de usuario
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pass1234',
            'is_admin' => 0, // El nuevo usuario no debe tener privilegios de administrador
        ]);

        // Verificar que la solicitud fue exitosa (código de estado 201)
        $response->assertStatus(201);

        // Verificar que el nuevo usuario se haya creado correctamente
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testUpdateUserByAdmin()
    {
        // Autenticar un usuario con privilegios de administrador
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true,
        ]);
        $token = JWTAuth::fromUser($admin);

        // Crear un usuario para ser actualizado
        $userToUpdate = \App\Models\User::factory()->create();

        // Realizar una solicitud PUT a la ruta de actualización de usuario
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/users/' . $userToUpdate->id, [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'password' => 'updatedpass1234',
            'is_admin' => false, // El administrador no debe poder actualizar el estado de isAdmin
        ]);

        // Verificar que la solicitud fue exitosa (código de estado 200)
        $response->assertStatus(200);

        // Verificar que el usuario se haya actualizado correctamente en la base de datos
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated User',
            'email' => 'updated@example.com',
        ]);
    }


}
