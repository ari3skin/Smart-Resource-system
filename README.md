# Smart Resource

A web-based resource bank system for efficient workforce allocation and management

The Banking Resource Management System is an innovative platform designed to streamline the allocation of workforce
resources within the banking sector. In light of the current banking landscape, effective employee resource management
is crucial for operational efficiency. Traditional systems, however, are laden with significant challenges leading to a
decline in task completion rates and overall operational efficiency.

# Installation Guide and Dependencies

This guide will help you set up the Smart Resource System on your local machine.

## Installation Procedure

1. Before you start, make sure you have these installed:
   - [Git](https://git-scm.com/downloads) CLI
   - [PHP](https://windows.php.net/download#php-8.0) version 8.0
   - [Composer](https://getcomposer.org/download/)
<br><br>
2. Download the <a href="./setup.sh" download>sShell Script</a> file and run it
<br><br>
3. Once inside the root structure within your terminal, execute the following commands separately:
   ```shell
        composer install
      ```
   ```shell
        composer update
   ```
   ```shell
        composer require laravel/socialite
   ```
   ```shell
        copy .env.example .env
   ```
   ```shell
        php artisan key:generate
   ```
   ```shell
        php artisan migrate --seed
   ```
   ```shell
        php artisan serve
   ```


### 4.2 - Dependencies

The following open-source libraries and resources were instrumental in the development of this project:

- [Composer](https://getcomposer.org/): A tool for dependency management in PHP
- [Laravel](https://laravel.com/): A web application framework with expressive, elegant syntax
- [Laravel Socialite](https://laravel.com/docs/socialite): An official Laravel package which provides a streamlined
  OAuth authentication with various providers, in this case, Google.
- [Git CLI](https://git-scm.com/): An open-source GitHub app
