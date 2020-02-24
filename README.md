# Install
- Install composer if you dont have it. [https://getcomposer.org/download/].
- cd to your api root directory.
- Run ***composer install***.
- Create a database into your local mySQL (can be xampp or your [test, production] server) and import the template DB ***database/template/local_DB.sql***.
- Configure your .env and replace the name from ***.env.example*** to ***.env***.

# Run server
- Run ***php -S 127.0.0:5050***.

# Usage
- Import the postman collection [https://www.getpostman.com/collections/cdeda903632620d48fe0] for the basic usage of the built-in models/controllers.
