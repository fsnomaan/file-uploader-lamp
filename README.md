
This is a basic LAMP stack environment built using Docker Compose. It consists following:

* PHP 7.2
* Apache 2.4
* MySQL 5.7
* phpMyAdmin
* Code for the technical test

Application running on http://localhost:8888
PhpMyAdmin running on http://localhost:8080

The application has 5 end points:
- `/storefile` - to upload a file
- `/getlist` - get list of uploaded file
- `/download/{id}` - download a file by id
- `/delete/{id}` - delete a file by id
- `/getusage` - get size of all uploaded file

To comply with the requirements, no full framework is used for the API.

To enable routing a compser package called `altorouter` has been used.
To test API I have used `guzzlehttp`.

I have started automated testing by writing some functional tests but due to time constrains I could not finish it.
To run tests:
`./vendor/bin/phpunit tests`

Thanks for your time and all the best.