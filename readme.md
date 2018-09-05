## Instructions

Note: If you have a preferred way to run a laravel project, free feel to ignore the instructions below.

1. Open terminal and run:
1. `cp .env.example .env`
1. Update your .env accordingly
1. `composer install`
1. `composer dump-autoload`
1. `docker-compose up`
1. Open another terminal and run:
1. `docker exec -it iphone-photography-school-test-master_web_1 bash`
1. `php artisan migrate`
1. `phpunit`
1. `php artisan db:seed`
1. Open browser:
1. http://0.0.0.0:80/authorize_infusionsoft
1. Follow the link, authenticate and authorize
1. [POST] http://0.0.0.0:80/api/create_customer
1. [POST] http://0.0.0.0:80/api/module_reminder_assigner ['contact_email'=> required]



## Comments

Laravel is one of my favorite frameworks! I've been following it since its infancy. 
This was my first time working in the framework and I very much enjoyed it.    

At first, I decided to build this project using repositories and interfaces. 
However, after reevaluating the scope of this project, I decided against that approach and refactored 
the repository logic into models, as I felt the additional layers were unnecessary given the task at hand.

If I had to create a repository, I perhaps would have created one to refactor some of the controller logic out. 

Though, for easy consumption, I wanted the code to be straight forward and as simplistic as possible, given the time I had. 

I'm usually one to follow suite of a current project design and coding conventions and usually make architectural decisions 
based on team input and approval. 







  