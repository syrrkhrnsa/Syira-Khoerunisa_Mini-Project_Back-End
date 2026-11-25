# To-Do List (CodeIgniter 4 mini project)

A small to-do list web app with JSON CRUD endpoints, built with **CodeIgniter 4**.

## Features

- Add, edit, delete tasks
- Mark a task as done with a checkbox
- Task table with search and paging (DataTables)

## Tech stack

PHP 8.1+ · CodeIgniter 4 · MySQL · Bootstrap 4 · jQuery · DataTables

## Routes

| Method | Path | Description |
|---|---|---|
| GET | `/` | Task page |
| GET | `/task/list` | Tasks as JSON |
| POST | `/task/create` | Create a task |
| POST | `/task/update` | Update a task |
| GET | `/task/delete/{id}` | Delete a task |

## Run locally

```bash
git clone https://github.com/syrrkhrnsa/Syira-Khoerunisa_Mini-Project_Back-End.git
cd Syira-Khoerunisa_Mini-Project_Back-End
composer install
# create a .env file in the project root with:
#   CI_ENVIRONMENT = development
#   app.baseURL = 'http://localhost:8080/'
#   database.default.hostname = localhost
#   database.default.database = <your database>
#   database.default.username = <your user>
#   database.default.password = <your password>
#   database.default.DBDriver = MySQLi
```

Create the table (example schema):

```sql
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255) NOT NULL,
  status TINYINT(1) NOT NULL DEFAULT 0
);
```

```bash
php spark serve
```

## Author

Syira Khoerunisa
