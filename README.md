# Online Library Management System

## Project Description

The Online Library Management System is a web application designed to facilitate the management of books, users, and loans in a library setting. The application is divided into two modules: **Admin** and **Student**. Each module provides distinct functionalities tailored to the respective user roles.

### Modules

### Admin Module Features

-   **Admin Dashboard**:
    -   Admin can see Borrowed Books, All Books, and All Users.
    -   Admin can add, update, or delete books.
    -   Admin can search for students using their student ID.
    -   Admin can view student details.
    -   Admin can update their own profile.
-   **Authorization**:
    -   Only admins can perform the above tasks.

### Manager Role

-   Managers have full control over both admin and student accounts. They can add and remove admins and perform other management tasks.

### Student Module Features

-   Students can register to the website.
-   Students can view all books and their details.
-   Students can borrow a book.
-   After login, students can view their dashboard (including books borrowed and return dates).
-   Students can update their own profiles.
-   Students can view borrowed books and their return dates.

### Database Structure

The application utilizes the following database tables:

#### Books Table

| Column Name | Data Type    | Constraints              |
| ----------- | ------------ | ------------------------ |
| book_id     | INT          | PRIMARY KEY              |
| title       | VARCHAR(255) | NOT NULL                 |
| author      | VARCHAR(255) | NOT NULL                 |
| genre_id    | INT          | FOREIGN KEY              |
| quantity    | INT          | NOT NULL (quantity >= 0) |

#### Genres Table

| Column Name | Data Type    | Constraints |
| ----------- | ------------ | ----------- |
| genre_id    | INT          | PRIMARY KEY |
| genre_name  | VARCHAR(255) | NOT NULL    |

#### Users Table

| Column Name | Data Type                           | Constraints       |
| ----------- | ----------------------------------- | ----------------- |
| user_id     | INT                                 | PRIMARY KEY       |
| username    | VARCHAR(50)                         | NOT NULL          |
| email       | VARCHAR(255)                        | NOT NULL, UNIQUE  |
| password    | VARCHAR(255)                        | NOT NULL          |
| role        | ENUM('student', 'admin', 'manager') | DEFAULT 'student' |

#### Loans Table

| Column Name | Data Type                  | Constraints      |
| ----------- | -------------------------- | ---------------- |
| loan_id     | INT                        | PRIMARY KEY      |
| user_id     | INT                        | FOREIGN KEY      |
| book_id     | INT                        | FOREIGN KEY      |
| loan_date   | DATE                       | NOT NULL         |
| due_date    | DATE                       | NOT NULL         |
| return_date | DATE                       |                  |
| loan_status | ENUM('active', 'returned') | DEFAULT 'active' |

### Technology Stack

-   **Backend**: Laravel Framework
-   **Frontend**: Client-side packages utilized for enhanced user experience.

### Getting Started

1. Clone the repository:
    ```bash
    git clone https://github.com/goudaabdulhmid2/online-library-management-system.git
    ```
2. Navigate to the project directory:
    ```bash
    cd online-library-management-system
    ```
3. Install dependencies:
    ```bash
    composer install
    ```
4. Set up the environment:

-   Copy .env.example to .env and configure your database settings.

5. Run migrations:

    ```bash
    php artisan migrate
    ```

6. Start the server:
    ```bash
    php artisan serve
    ```
