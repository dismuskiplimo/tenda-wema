# Tenda Wema Website
## About
tendawema.com is a social group where members earn Simba Coins for doing good deeds that positively impact their own local communities. Members can then use the Simba Coins (virtual social currency) earned to buy items donated by members to the Community instead of money. Members advance social levels and maintain their social status in the Community by accumulating Simba Coins earned for performing even more good deeds.

## Prerequisites
- PHP 7 (best if also added to the env path for direct access with the terminal)
- MySQL Server
- Composer
- Text Editor
- MPESA Daraja API credentials

## How to install
The project is very easy to set up once you have all the prerequisites
1. Clone the project into your local machine
2. Navigate into the project folder
3. Rename `.env.example` to become `.env`
4. Open the `.env` file using your favourite text editor. This file contains necessary configuration data for the application to run
5. You need only to edit the `DB` section e.g `DB_DATABASE`,`DB_USERNAME`,`DB_PASSWORD`, for the application to finish installing. You need to make sure the database selected is already created in MySQL server.
6. Open terminal within the project folder and type in the following commands in order
7. `php artisan key:generate` to generate application keys
8. `composer install` to install all the dependencies.
9. `php artisan migrate` to create the tables in MySQL
10. `php artisan db:seed` to populate the database with system configuration data
11. You're done 👍
12. Now, run `php artisan serve` to launch a development server.
13. Navigate to `http://localhost:8000` to view the website

## .env Configuration details
