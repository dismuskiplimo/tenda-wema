# Tenda Wema Website
## About
tendawema.com is a social group where members earn Simba Coins for doing good deeds that positively impact their own local communities. Members can then use the Simba Coins (virtual social currency) earned to buy items donated by members to the Community instead of money. Members advance social levels and maintain their social status in the Community by accumulating Simba Coins earned for performing even more good deeds.

## Prerequisites
- PHP 7.1 or later (best if also added to the env path for direct access with the terminal)
- MySQL Server
- Composer
- Text Editor - Visual Studio Code recommended
- MPESA Daraja API credentials (https://developer.safaricom.co.ke/)

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
1. `APP_NAME` - The application name (any string. If the name has spaces, enclose in "double quotes")
2. `APP_ENV` - The application environment (acceptable values: local, production)
3. `APP_KEY` - The application key. Generated automatically using `php artisan key:generate`
4. `APP_DEBUG` - Whether to display debug messages (acceptable values: true, false)
5. `APP_URL` - The URL of the application (including http/https) e.g https://tendawema.com (used for sending password reset emails)
6. `APP_DOMAIN` - The domain name of the application without http/https (e.g. tendawema.com, abc.com)
7. `APP_CONTACT_EMAIL` - The contact email displayed in the website
8. `APP_SYSTEM_EMAIL` - Email that the system used to send automated emails. e.g no-reply@tendawema.com
9. `PUBLIC_PATH` - The path that contains public assets (default: public_html)
10. `HTTPS` - Whether the website is HTTPS or not (acceptable values: true, false)
11. `LOG_CHANNEL` - The channel where data is logged (acceptable values: stack, single)
12. `DB_CONNECTION` - The database driver (acceptable values: mysql, postgres, e.t.c).
13. `DB_HOST` - The ip/hostname of the Database Server 
14. `DB_PORT` - Database port
15. `DB_DATABASE` - Database name. Must have been created before running `php artisan migrate`
16. `DB_USERNAME` - The username of the database user
17. `DB_PASSWORD` - Database password
18. `BROADCAST_DRIVER` - 
19. `CACHE_DRIVER` - 
20. `SESSION_DRIVER` - 
21. `SESSION_LIFETIME` - The duration which the session is valis in minutes
22. `QUEUE_DRIVER` - 
23. `REDIS_HOST` - 
24. `REDIS_PASSWORD` - 
25. `REDIS_PORT` - 
26. `MAIL_DRIVER` - The mail driver (acceptable values: smtp, sparkpost, mailgun)
27. `MAIL_HOST=` - The mail host
28. `MAIL_PORT` - Mail Port
29. `MAIL_USERNAME` - Email username
30. `MAIL_PASSWORD` - Email password
31. `MAIL_ENCRYPTION` - The type of mail encryption (acceptable values: null, ssl, tls)
32. `MAIL_FROM_ADDRESS` - The email address from where the system email originates
33. `MAIL_FROM_NAME` - The name displayed when system email is sent
34. `SPARKPOST_SECRET` - The secred API code received from sparkpost (https://sparkpost.com)
35. PUSHER_APP_ID=
36. PUSHER_APP_KEY=
37. PUSHER_APP_SECRET=
38. PUSHER_APP_CLUSTER=mt1
39. MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
40. MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
41. GOOGLE_CLIENT_ID=
42. GOOGLE_CLIENT_SECRET=
43. GOOGLE_REDIRECT=
44. FACEBOOK_CLIENT_ID=
45. FACEBOOK_CLIENT_SECRET=
46. FACEBOOK_REDIRECT=
47. MPESA_MODE=live
48. MPESA_SHORTCODE_SANDBOX=
49. MPESA_PASSKEY_SANDBOX=
50. MPESA_CONSUMER_KEY_SANDBOX=
51. MPESA_CONSUMER_SECRET_SANDBOX=
52. MPESA_CALLBACK_URL_SANDBOX=
53. MPESA_SHORTCODE_LIVE=
54. MPESA_PASSKEY_LIVE=
55. MPESA_CONSUMER_KEY_LIVE=
56. MPESA_CONSUMER_SECRET_LIVE=
57. MPESA_CALLBACK_URL_LIVE=
