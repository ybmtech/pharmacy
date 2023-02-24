<h4>Kebbi State Apc Situation Room</h4>

<p>Kebbi State Apc Situation Room is a web app in which the Nigerian election will be populated and verify base on level before displaying as actual result in situation room. It also capture the incident of a particular polling unit.</p>

<p>This codebase, therefore, provides the logic for managing and controlling the tech require to scale and deliver these services in a secure and performant means.</p>

<h4>Local Setup</h4>

To contribute, you need to set up your development environment.

step 1: Clone this repository

git clone git@github.com:ybmtech/situation_room.git

Step 2: Install Dependencies

To install the backend dependencies, run composer install.

To install the frontend dependencies, run npm i and then build the assets with npm run build.

Step 3: Configure Environment Variables

Proceed to configure your environment variables by copying the .env.example file to .env. Simply run cp .env.example .env

Now open the copied .env file and edit the values. Notably, the Database connections, mail configurations, app key, etc.

Step 4: Generate App key and start the server

Generate app key with php artisan key:generate and start the server with php artisan serve;

Step 5: Migrate Database

Migrate the database tables and  run the seeders to automatically populate your database with default data: php artisan migrate --seed


Pushing to Github

After cloning and setting up your environment, create your and checkout to your branch with

git checkout -b NAME_OF_YOUR_BRANCH

After committing your work to the new branch you created, you can push to your remote branch with:

git push origin NAME_OF_YOUR_BRANCH

Note that if you're pushing for the first time, you'll need to add the option to create your remote branch if it doesn't exist:

git push origin -u NAME_OF_YOUR_BRANCH


Guidelines

Routing

The routing should be grouped 


