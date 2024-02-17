# User-Management-System
## Develop a simple yet robust web application that allows for managing user accounts. This includes functionalities for user registration, login, viewing, editing, and deleting user profiles.


<table>
    <tr>
        <td>
            <a href="https://laravel.com"><img src="https://i.imgur.com/pBNT1yy.png" /></a>
        </td>
        <td>
            <a href="https://vuejs.org/"><img src="https://i.imgur.com/BxQe48y.png" /></a>
        </td>
    </tr>
</table> 


## Requirements
You need to have PHP version **8.1** or above. Node.js version **12.0** or above.


## Installation

#### Backend
1. Clone the project
2. Go to the project root directory
3. Run `composer install`
4. Set the encryption key by executing php artisan key:generate --ansi
5. Create database named: usersystem
6. Run migrations php artisan migrate --seed  
7. Copy `.env.example` into `.env` file and adjust parameters
8. Run `php artisan serve` to start the project at http://localhost:8000
9. Open new terminal and navigate to the project root directory
10. Run npm install
11. Run npm run dev to start vite server for Laravel frontend


#### Frontend
1. Navigate to `frontend` folder using terminal
2. Run `npm install` to install vue.js project dependencies
3. Copy `frontend/.env.example` into `frontend/.env` and specify API URL
4. Start frontend by running `npm run dev`
5. Open http://localhost:3000

### Run test "Using PhpUnit"
To run tests with PhpUnit, follow these steps:

1. Open a terminal.
2. Navigate to the root directory of Laravel project.
3. Run the following command to run all tests: `php artisan test`
4. The tests in the tests\Feature\Api folder are the ones that are applied in the frontend, which are the ones that are applied for this test.

### Navigate in the Frontend.

1. use `php artisan db:seed --class=UsersTableSeeder` in the root project.
2. Open http://localhost:3000 in your browser.
3. In the login use:  
    email:     admin@example.com  
    password:  admin123
4. Click the "Login" button.
5. You will be redirected to the Dashbopard administration panel.
6. In the sidebar you can go to users.
7. Here you can view, create, update and delete users based on your administrator permissions. Explore the different functionalities available in the panel to manage users.
8. 


## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
