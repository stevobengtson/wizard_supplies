# Setup

- Install composer on your system 
  - Ubuntu `sudo apt install composer`
- Run `composer install` in the project folder (where composer.json is located)
- Run `php bin/console doctrine:migrations:migrate` to migrate the database
- Run `php bin/console server:run` to run the server


## Tips

- Recreate database
  - `php bin/console doctrine:database:drop --force`
  - `php bin/console doctrine:database:create`
  - `php bin/console doctrine:migrations:migrate`