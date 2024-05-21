# School Management System (SIIGA)

SIIGA is a school management system designed to facilitate the administration of students, parents, and payments in an educational institution.

## Features

- Student management: allows to register, edit, and delete information of students, including personal data, academic information, and related documents.
- Parent management: enables management of parent information associated with students.
- Payment management: allows to register and manage monthly payments of students, including the association of payment receipts to each student.
- Intuitive user interface: designed to be easy to use by administrators and school staff.

## Technologies Used

- **Laravel**: PHP framework for web application development.
- **Vue.js**: Progressive JavaScript framework for building user interfaces.
- **MySQL**: Relational database management system.

## Installation

1. Clone this repository on your local machine.
2. Configure the `.env` file with your database details.
3. Run `composer install` to install PHP dependencies.
4. Run `npm install` to install Node.js dependencies.
5. Run `php artisan migrate --seed` to migrate the database and populate it with sample data.
6. Run `composer dump-autoload` to optimize the autoloader.

## Usage

Once the server is up and running, you can access the system from your web browser at `http://localhost:8000`. Use the admin credentials provided in the sample data to log in to the system and explore its functionalities.

## Contribution

Contributions are welcome. If you want to contribute to the project, follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/feature-name`).
3. Make your changes and commit (`git commit -am 'Add new feature'`).
4. Push the branch (`git push origin feature/feature-name`).
5. Create a new Pull Request.

## License

This project is licensed under the [MIT License](LICENSE).
