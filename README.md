# Introduction 
Article Management Application created with laravel 10 (under the MIT License).

# Getting Started
To Install & run the system, please follow the below commands:
1.	Installation steps:

    git clone https://github.com/ahmed-el-khoribi/namaa-solutions.git
    
    composer install
    
    cp .env.example .env    

    npm install     
    
    npm run build

    php artisan migrate

    php artisan db:seed --class AppBootSeeder

    php artisan serve    


2.	Admins & Normal Users Credintials

    # For Admin User:
    Username: admin@mail.com
    
    Password: 123456

    # For Normal User:
    Username: normal@mail.com
    
    Password: 123456


3.	To Run Queue (After setting up connection with qee server either database or redis)

    php artisan queue:work


4.  To Access Articles API:

    {hostname}/api/v1/articles

    {hostname}/api/v1/articles?page=2

5.  In case of adding new Routes to the system, we need to sync new routes with permissions model, to do so run below command:

    php artisan app:sync-permissions

6.  To Configure Scout Driver (Full text Search feature) please add below line to .env file:

    SCOUT_DRIVER=database

7.  Model Caching is applied on "Article" Model, to enable it on any other model use the below trait:

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;

    use Cachable;

# System Feature List:
    -   Multi Roles & Permission Based system with fully customizations (Roles are based on routes).
    -   Inpendent File Manager Model Which can be injected in any other Model with few lines of code.
    -   Image Rezing Feature.
    -   Fully Article Management.
    -   Hierarchical comments system (Comments and replies to infinite level of depth).
    -   Secure Against CSRF.
    -   Notifcation Mail to admins when new article is created.
    -   API for articles with pagination.
    -   Full Text Search for articles module in admin portal using (title, brief, or content).
    -   Advanced Model Caching
