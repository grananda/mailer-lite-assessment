# YBank
To initiate the development environment follow the steps above after cloning the repository.

- Use the `master` branch for execution purposes.
- Copy the file `.env.example` to `.env`
- For the **cors** rules to work, you must add the domian `ybank.test` to your `/etc/host` file (when working from Linux or Max OSx.) Nevertheless, the API will also accept calls from `localhost` and `127.0.0.1`
- For the back end API, and from your terminal window, go to the `api` folder and run the following commands:
	- `composer install` : this will install all necessary dependencies for the API to run.
	- `php artisan key:generate` : this is an optional step in case you wish to change the `.env` file key.
	- `touch ./database/database.sqlite` : this command will initiate your database file.
	- `composer db` : reset: this will initiate your local SQLite database with dummy data.
	- `composer server:start` : this command will start your server at port 8000
	- `phpunit`: to run all the tests.
- For the front end, switch to th `web` folder and follow the steps below:
	- `yarn install` : this command will install the necessary dependencies for the application to run.
	- `yarn dev` : this commad will start the front end application in development mode.
	- You may now access the application from any of the following uris:
		- http://ybank.test:3000
		- http://localhost:3000
		- http://127.0.0.1:3000

For testing purposes, the following account number will always be available:
- 1182957782
- 34813497363
- 212100141865
- 681465881310
- 88BARC200318



