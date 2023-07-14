<h1 style="text-align: center;">
    Smart Resource
</h1>

<h2 style="text-align: center;">
    A web-based resource bank system that empowers efficient work force allocation and management
</h2>

The Banking Resource Management System is an innovative platform developed to optimize the allocation of work force
resources in the banking sector. In the current banking landscape, employee resource management stands as a paramount
aspect of operational efficiency. However, traditional systems face significant challenges leading to reduced task
completion rates and overall operational efficiency.

The Banking Resource Management System aims to address these issues by offering an optimized, comprehensive solution
that can independently manage employee resources across various dimensions. Furthermore, the system provides a
user-friendly interface accessible to all stakeholders, including employees and management.

## Functionalities

### 1. Authentication:

- [x] Employers and employees whose information is sourced from the main bank portal are able to register
- [x] Registration is completed through email verification and password creations
- [x] Login procedures can be carried out
- [x] Google Login feature can be carried out
- [x] Access to exclusive dashboards depending on the current logged-in user type
- [x] Should users login using Google, their Google profile is used

### 2. Employee Functionalities:

- [x] Able to log in appropriately and access their own dashboard
- [x] Data viewing and compilation done as per their department
- [x] Under Tasks Module: <br>
    - Employees are able to view all tasks they have been assigned to individually
    - Employees are able to view tasks within their department
- [x] Under Teams Module: <br>
    - Employees are able to view their assigned active teams, as well as their other team members

### 3. Employer as Manager Functionalities:

- [x] Able to log in appropriately and access their own dashboard
- [x] Able to view all tasks assigned to them either individually or through a team
- [x] Under Projects Module: <br>
    - Managers are able to view all projects they are a project manager and or a subproject manager
    - Managers are able to create a project within their department and assign either a new project manager or be one
      themselves and or be a subproject manager themselves
- [x] Under Tasks Module: <br>
    - Managers are able to view all tasks assigned either individually or to a team leader who is responsible for their
      team
    - Managers are able to create a new task and assign either individually or to a team leader
- [x] Under Teams Module
    - Managers are able to view all teams they are part of alongside the respective members
    - Managers are able to create a new team solely within their departments

### 4. Installation Sources and Guide

#### 4.1 - Guide

1. Clone the repository through the GitHub desktop
    - Click [here](https://desktop.github.com/) to go to GitHub's desktop site to download the application, install and
      login using your GitHub account in order to clone
<br><br>
2. Open the project from where you have cloned it in your pc's terminal
<br><br>
3. Once inside the root structure within your terminal, run the following commands
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
