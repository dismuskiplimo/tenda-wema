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

## Configuration details (.env file)
`APP_NAME` - The application name (any string. If the name has spaces, enclose in "double quotes")
`APP_ENV` - The application environment (acceptable values: local, production)
`APP_KEY` - The application key. Generated automatically using `php artisan key:generate`
`APP_DEBUG` - Whether to display debug messages (acceptable values: true, false)
`APP_URL` - The URL of the application (including http/https) e.g https://tendawema.com (used for sending password reset emails)
`APP_DOMAIN` - The domain name of the application without http/https (e.g. tendawema.com, abc.com)

`APP_CONTACT_EMAIL` - The contact email displayed in the website

`APP_SYSTEM_EMAIL` - Email that the system used to send automated emails. e.g no-reply@tendawema.com

`PUBLIC_PATH` - The path that contains public assets (default: public_html)

`HTTPS` - Deceides whether the website is HTTPS or not (acceptable values: true, false)

`LOG_CHANNEL` - The channel where data is logged (acceptable values: stack, single)

`DB_CONNECTION` - The database driver (acceptable values: mysql, postgres, e.t.c).
`DB_HOST` - The ip/hostname of the Database Server 
`DB_PORT` - Database port
`DB_DATABASE` - Database name. Must have been created before running `php artisan migrate`
`DB_USERNAME` - The username of the database user
`DB_PASSWORD` - Database password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=525600
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

SPARKPOST_SECRET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"


GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT=

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT=


MPESA_MODE=live

MPESA_SHORTCODE_SANDBOX=
MPESA_PASSKEY_SANDBOX=
MPESA_CONSUMER_KEY_SANDBOX=
MPESA_CONSUMER_SECRET_SANDBOX=
MPESA_CALLBACK_URL_SANDBOX=

MPESA_SHORTCODE_LIVE=
MPESA_PASSKEY_LIVE=
MPESA_CONSUMER_KEY_LIVE=
MPESA_CONSUMER_SECRET_LIVE=
MPESA_CALLBACK_URL_LIVE=
