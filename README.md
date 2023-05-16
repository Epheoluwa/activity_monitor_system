
## Cypress Task


[Click here to view the live version](https://zipagro.a10staffing.com/).

Super User Login Details

Email: admin@admin.com
Password: 12345678

## Adding a New Activity

- Click on a day in the calendar that has not reached the maximum number of activities for that day.

- A popup modal will appear, where you need to fill in all the mandatory fields to add the activity.

## Editing/Deleting an Activity:
To edit or delete an activity, follow these steps:

- Click on the specific activity you want to modify.
- A popup modal will appear, allowing you to edit or delete the activity.


## User Page
The user's page displays all the current users and their respective activities. As a super user, you have the following options:

- Add a new activity specifically for a user.
- Delete and update activities associated with a user.

## REST API:

To access the user activities through the API [/activities] and filter them by date range, follow these guidelines:

- Provide the bearer token in the request header. (The token is returned upon successful login or registration.)
- Specify the start and end dates in the request body using the following format

```
{
    "start": "15-5-2023",
    "end": "16-5-2023"
}
```

Please note that these instructions are intended to guide you in performing the mentioned actions for this task.
For Local set up please see the details below.


## Project Setup
```
git clone git@github.com:Epheoluwa/cypress_task.git
cd cypress_task
composer install
cp .env.example .env 
php artisan key:generate
php artisan cache:clear && php artisan config:clear 
```

## Database Setup
Different CRUD request will be performed using local storage so we need to setup our database connection
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=
```

Next up, if you are using the ```MYSQL DATABASE``` or any other database, there is need to create the database which will be grabbed from the ```DB_DATABASE``` environment variable. ```MYSQL``` database query written below
```
mysql;
create database database_name;
exit;
```

Finally, run the code below to make migrations.
```
php artisan migrate
```

### Run the application

```
php artisan serve
```

## Author

Solomon Sunmola
