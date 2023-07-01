## FEMHACK CHALLENGE VOL II

Backend category

## What has been achieved.

Implemented a user authentication system with login and registration functionality.
Integrated role-based access control using Spatie Permission package.
Added a second layer of authentication (2FA) for enhanced security.

## Objective analysis of the results obtained.

The user authentication system provides a secure way for users to register, login, and access protected resources.
Role-based access control ensures that users have appropriate permissions based on their assigned roles.
The addition of 2FA adds an extra layer of security to protect user accounts from unauthorized access.

## Final description about the endpoints implemented.
/login: Allows users to authenticate and obtain an access token for accessing protected resources. Supports email and password authentication.
/register: Allows users to create a new account with a unique username, email, and password. Assigns the "user" role to the new user.
/home: Displays a welcome message to the authenticated user, including their name and role. Only accessible to registered users.
/log: Retrieves a list of recent connections from the database. Accessible to users with the "admin" role.

## Future steps.

Enhance error handling and validation to provide more informative error messages to the users.
Implement password recovery functionality, allowing users to reset their passwords.
Explore additional security measures, such as rate limiting and session management, to further protect the application.
Consider implementing more endpoints and features based on the specific requirements of the application and user needs.

## Installation

1. Clone the repo to your computer
```
git clone https://github.com/GabrielaMaureira/FemHack-Challenge-II.git
```
2. Run composer install. (If you don't have composer on your computer, install it: https://getcomposer.org/download/)
```
composer install
```
3. Create a MySQL database on your computer. (If you don't have it, you can install Xampp, which also includes PHP: https://www.apachefriends.org/download.html).
4. Configure the .env file of your project for your system to match the database. Fields that you must match:
```
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```
5. Create an application key
```
php artisan key:generate
```
6. Migrate the database by typing on the terminal:
```
php artisan migrate --seed
```

10. Run passport to generate the clients: 
```
php artisan passport:install
```
11. Run the Laravel server in another terminal: 
```
php artisan serve
```
Use the route returned by the last command to access the app (typically http://127.0.0.1:8000)
