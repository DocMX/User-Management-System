<?php

namespace Tests\Feature\Api;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tests\TestCase;

class UserApiTest extends TestCase
{
    public function testLoginWithValidCredentials()
    {
        // Crear un usuario en la base de datos usando el factory
        $user = User::factory()->create([
            'email' => 'adminTest@example.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);
        // Realiza una solicitud POST a la ruta de inicio de sesión
        $response = $this->postJson('/api/login', [
            'email' => 'adminTest@example.com',
            'password' => 'admin123',
        ]);

        // Verifica que la solicitud fue exitosa (código de estado 200)
        $response->assertStatus(200);
    }
    public function testForgotPassword()
    {
        // Crear un usuario en la base de datos
        $user = \App\Models\User::factory()->create();
    
        // Realiza una solicitud POST a la ruta de olvidar contraseña
        $response = $this->postJson('/api/forgot-password', [
            'email' => $user->email,
        ]);
    
        // Verificar que la solicitud fue exitosa (código de estado 200)
        $response->assertStatus(200);
    
        // Verificar que el correo electrónico fue enviado correctamente
        // Esto puede variar dependiendo de cómo implementaste el envío de correo electrónico en tu lógica de olvidar contraseña
        // Puedes verificar en la respuesta si se devuelve un mensaje o estructura de datos que indique que el correo fue enviado correctamente
        // Por ejemplo:
        $response->assertJson([
            'message' => 'Password reset email sent successfully',
        ]);
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

    public function testDeleteUserByAdmin()
    {
        // Autenticar un usuario con privilegios de administrador
        $admin = \App\Models\User::factory()->create([
            'is_admin' => true,
        ]);
        $token = JWTAuth::fromUser($admin);

        // Crear un usuario para ser eliminado
        $userToDelete = \App\Models\User::factory()->create();

        // Realizar una solicitud DELETE a la ruta de eliminación de usuario
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/users/' . $userToDelete->id);

        // Verificar que la solicitud fue exitosa (código de estado 204)
        $response->assertStatus(204);

        // Verificar que el usuario se haya eliminado correctamente de la base de datos
         $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }
    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });

    }
}
