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
        <td>
            <img src="https://i.imgur.com/Kp5kTUp.png" />
        </td>
    </tr>
</table> 


## Requirements
You need to have PHP version **8.0** or above. Node.js version **12.0** or above.

## Demo



## Installation

#### Backend
1. Clone the project
2. Go to the project root directory
3. Run `composer install`
4. Set the encryption key by executing php artisan key:generate --ansi
5. Create database
6. Run migrations php artisan migrate --seed
7. Copy `.env.example` into `.env` file and adjust parameters
8. Run `php artisan serve` to start the project at http://localhost:8000

#### Frontend
1. Navigate to `vue` folder using terminal
2. Run `npm install` to install vue.js project dependencies
3. Copy `vue/.env.example` into `vue/.env` and specify API URL
4. Start frontend by running `npm run dev`
5. Open http://localhost:3000


## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
