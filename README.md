# Tenda Wema Project

![tendawema](https://user-images.githubusercontent.com/15145265/173412569-505937cd-e30c-4c97-a68e-371786494313.jpg)

## Table of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Prerequisites](#prerequisites)
* [Getting Started](#getting-started)
* [Installation](#installation)
* [Contributing](#contributing)
* [.env file configurations](#configuration-file)
* [Authors](#authors)
* [Acknowledgements](#acknowledgements)

## About the Project
tendawema.com is a social group where members earn Simba Coins for doing good deeds that positively impact their own local communities. Members can then use the Simba Coins (virtual social currency) earned to buy items donated by members to the Community instead of money. Members advance social levels and maintain their social status in the Community by accumulating Simba Coins earned for performing even more good deeds. <br>


## [Live Demo - Heroku](https://tenda-wema.herokuapp.com/)

## Built With

* PHP
* Laravel
* MySQL Server (any supported RDBMS can be used)

## Prerequisites
- PHP 7.1 or later (best if also added to the env path for direct access with the terminal)
- MySQL Server, PsotgreSQL, or any other RDBMS supported by Laravel
- Composer
- Text Editor - Visual Studio Code recommended
- MPESA Daraja API credentials (https://developer.safaricom.co.ke/)

## Getting Started

* Clone this repo
    ```shell
    git clone https://github.com/dismuskiplimo/tenda-wema.git
    ```

* Navigate to panaqia folder/directory

    ```shell
    cd panaqia
    ```
* Rename `.env.example` to become `.env`
    ```shell
    mv .env.example .env
    ```
* Open the `.env` file using your favourite text editor. This file contains necessary configuration data for the application to run
* You need only to edit the `DB` section e.g `DB_DATABASE`,`DB_USERNAME`,`DB_PASSWORD`, for the initial installation. Ensure that the database selected is already created in your REBMS server (mysql, postgresql, sqlite e.t.c) or the installation will fail.

## Installation

After the `.env` configuration file has been updated, resume to the terminal and type in the following commands

1. Install all the dependencies.
   ```shell
    composer install
   ```
2. Generate the application keys
    ```shell
    php artisan key:generate
    ```
3. Create the tables and migrate them to your DB
    ```shell
    php artisan migrate
    ```
4. Populate the database with necessary system configuration
    ```shell
    php artisan db:seed
    ```
    Yaay, you're done 👍
    
5. Now, Launch the development server.
   ```shell
   php artisan serve
   ```
6. Navigate to `http://localhost:8000` to view the website
7. Once you verify that the website is working, re-open the `.env` file to finish defining the remaining configurations

## Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](../../issues)

  1. Fork the Project
  2. Create your Feature Branch (`git checkout -b feature/newFeature`)
  3. Commit your Changes (`git commit -m 'Add some newFeature'`)
  4. Push to the Branch (`git push -u origin feature/newFeature`)
  5. Open a Pull Request

## Configuration File

The `.env` file located in the root directory contains all the necessary configurations necessary for the application to run

* `APP_NAME` - The application name (any string. If the name has spaces, enclose in "double quotes")
* `APP_ENV` - The application environment (acceptable values: local, production)
* `APP_KEY` - The application key. Generated automatically using `php artisan key:generate`
* `APP_DEBUG` - Whether to display debug messages (acceptable values: true, false)
* `APP_URL` - The URL of the application (including http/https) e.g https://tendawema.com (used for sending password reset emails)
* `APP_DOMAIN` - The domain name of the application without http/https (e.g. tendawema.com, abc.com)
* `APP_CONTACT_EMAIL` - The contact email displayed in the website
* `APP_SYSTEM_EMAIL` - Email that the system used to send automated emails. e.g no-reply@tendawema.com
* `PUBLIC_PATH` - The path that contains public assets (default: public_html)
* `HTTPS` - Whether the website is HTTPS or not (acceptable values: true, false)
* `LOG_CHANNEL` - The channel where data is logged (acceptable values: stack, single)
* `DB_CONNECTION` - The database driver (acceptable values: mysql, postgres, e.t.c).
* `DB_HOST` - The ip/hostname of the Database Server 
* `DB_PORT` - Database port
* `DB_DATABASE` - Database name. Must have been created before running `php artisan migrate`
* `DB_USERNAME` - The username of the database user
* `DB_PASSWORD` - Database password
* `BROADCAST_DRIVER` - 
* `CACHE_DRIVER` - 
* `SESSION_DRIVER` - 
* `SESSION_LIFETIME` - The duration which the session is valid in minutes
* `QUEUE_DRIVER` - 
* `REDIS_HOST` - 
* `REDIS_PASSWORD` - 
* `REDIS_PORT` - 
* `MAIL_DRIVER` - The mail driver (acceptable values: smtp, sparkpost, mailgun)
* `MAIL_HOST=` - The mail host
* `MAIL_PORT` - Mail Port
* `MAIL_USERNAME` - Email username
* `MAIL_PASSWORD` - Email password
* `MAIL_ENCRYPTION` - The type of mail encryption (acceptable values: null, ssl, tls)
* `MAIL_FROM_ADDRESS` - The email address from where the system email originates
* `MAIL_FROM_NAME` - The name displayed when system email is sent
* `SPARKPOST_SECRET` - The secred API code received from sparkpost (https://sparkpost.com)
* PUSHER_APP_ID=
* PUSHER_APP_KEY=
* PUSHER_APP_SECRET=
* PUSHER_APP_CLUSTER=mt1
* MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
* MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
* GOOGLE_CLIENT_ID=
* GOOGLE_CLIENT_SECRET=
* GOOGLE_REDIRECT=
* FACEBOOK_CLIENT_ID=
* FACEBOOK_CLIENT_SECRET=
* FACEBOOK_REDIRECT=
* MPESA_MODE=live
* MPESA_SHORTCODE_SANDBOX=
* MPESA_PASSKEY_SANDBOX=
* MPESA_CONSUMER_KEY_SANDBOX=
* MPESA_CONSUMER_SECRET_SANDBOX=
* MPESA_CALLBACK_URL_SANDBOX=
* MPESA_SHORTCODE_LIVE=
* MPESA_PASSKEY_LIVE=
* MPESA_CONSUMER_KEY_LIVE=
* MPESA_CONSUMER_SECRET_LIVE=
* MPESA_CALLBACK_URL_LIVE=

## Authors

👤 *Dismus Ng'eno*

- GitHub: [@dismuskiplimo](https://github.com/dismuskiplimo)
- Twitter: [@dismus_kiplimo](https://twitter.com/dismus_kiplimo)
- LinkedIn: [Dismus Ng'eno](https://www.linkedin.com/in/dismus-kiplimo)

## Acknowledgements

* [Laravel Team](https://laravel.com/) for the amazing [Documentation](https://laravel.com/docs/master/introduction) on Laravel.
* [Safaricom Developer Team](https://developer.safaricom.co.ke/) for their in-depth [Documentation](https://ldeveloper.safaricom.co.ke) on the MPESA API.

## Show your support

Give a ⭐ if you like this project!
