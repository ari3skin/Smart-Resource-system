<h1 style="text-align: center;">
    Smart Resource
</h1>

<h2 style="text-align: center;">
    A web-based resource bank system that empowers efficient work force allocation and management
</h2>

The Banking Resource Management System is an innovative platform designed to streamline the allocation of workforce
resources within the banking sector. In light of the current banking landscape, effective employee resource management
is crucial for operational efficiency. Traditional systems, however, are laden with significant challenges leading to a
decline in task completion rates and overall operational efficiency.

The Banking Resource Management System intends to overcome these challenges, providing an optimized, all-encompassing
solution capable of managing employee resources across various facets autonomously. Additionally, the system boasts a
user-friendly interface accessible to all stakeholders, including employees and management.

## Key Features

### 1. Authentication:

- Employers and employees can register using information from the main bank portal
- Registration is facilitated through email verification and password creation
- Users can log in using the regular process or Google Login feature
- Depending on the user type, access to specific dashboards is granted
- If users log in using Google, their Google profile information is utilized

### 2. Employee Functionalities:

- Employees can log in and access their dedicated dashboard
- Viewing and compilation of data according to their department
- **Tasks Module**:
    - Employees can view all tasks individually assigned to them
    - Tasks within their department are viewable
- **Teams Module**:
    - Employees can view their active teams along with other team members

### 3. Employer-as-Manager Functionalities:

- Managers can log in and access their dedicated dashboard
- All tasks assigned to them individually or through a team are viewable
- **Projects Module**:
    - Managers can view all projects for which they are a project manager or a subproject manager
    - They can create a project within their department and assign either a new project manager, assign themselves as a
      project manager, or a subproject manager
- **Tasks Module**:
    - Managers can view all tasks assigned either individually or to a team leader who is responsible for their team
    - They can create a new task and assign it either individually or to a team leader
- **Teams Module**:
    - Managers can view all teams they are a part of, along with the respective members
    - They can create a new team solely within their departments

## 4. Installation Guide and Dependencies

### 4.1 - Guide

1. Clone the repository via GitHub desktop
    - Go to [GitHub's desktop site](https://desktop.github.com/), download the application, install, and login using
      your GitHub account to clone
      <br><br>
2. Open the project from the location where you cloned it in your PC's terminal
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
- [GitHub Desktop](https://desktop.github.com/): An open-source GitHub app
