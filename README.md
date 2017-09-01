# Skyward-to-ASM
Skyward API to Apple School Manager CSV Automation

The purpose of this application to assist in the automated creation of nightly CSV files using the Skyward API.

## Skyward API Requirements

You will be required to set up API credentials for the application to authenticate. Depending on your hosting platform, the way to get the API configured will be different.

### Secure Cloud (ISCorp) Hosted Environment
Please create a ticket with Skyward Support to have the API set up for your hosted account. [ISCorp Helpdesk Support](https://support.iscorp.com/)

### Self-Hosted Environments
Please refer to the API Server Launch Kit to set up the API for your self-hosted account. You may also need to open a support call with Skyward for assistance. 

https://support.skyward.com/DeptDocs/Corporate/IT%20Services/Public%20Website/Technical%20Information/system/current_requirements/Api%20Server%20Launch%20kit.pdf

Once you API is configured and credentials have been made, you will need to make note of the following variables:
* Domain URL: This will be your full hosted domain URL, this will be everything before the /api.
* Consumer Key: The local API account username you created.
* Consumer Secret: The key that was created during the creation of the API user account.

## Application Requirements

- Same requirements needed for Laravel 5.4 documented at [https://laravel.com/docs/5.4](https://laravel.com/docs/5.4).
- HTTP server with PHP support (eg: Apache, Nginx, Caddy)
- A supported database: MySQL, PostgreSQL or SQLite
- [Node.js](https://nodejs.org/en/) for running the **npm run production** command.

## Installation

1. Get the source code
- Github: Download the ZIP
- Git: git clone https://github.com/josephlucia/skyward-to-asm.git
2. Open the terminal of your web server, navigate to skyward-to-asm and run the following commands:
- composer install
- npm install
- npm run production
- cp .env-example .env
- php artisan key:generate
3. Open the .env file and enter your database details for the flavor of SQL you have access to.
4. Go back to the terminal, and run **php artisan migrate**.
5. Open the browser and navigate to your installed application.
6. Register your user account.
7. Add your Skyward Domain, Consumer Secret and Consumer Key. Save.
8. Edit your locations table. Disable any entities that should not sync.
9. Perform a manual sync of each table to confirm there are no errors.
10. Enable the sync setting.
11. Check the documentation related to scripting the nightly process of syncing the tables, and uploading the files.

## License
Copyright 2017 Joseph Lucia

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.