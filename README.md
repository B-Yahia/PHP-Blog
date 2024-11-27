# PHP Blog
This is a simple blog application built using PHP, created to familiarize with the basics of PHP development. The app is based on the tutorial [Make Your Own Blog](https://ilovephp.jondh.me.uk/en/tutorial/make-your-own-blog).

## Features
- User authentication (login/logout).
- Create, read, update, and delete blog posts.
- Dynamic content rendering.

## Installation 
1. clone the repository 

```
git clone https://github.com/B-Yahia/PHP-Blog.git  
```
2. Install dependencies using Composer
```
cd PHP-Blog  
composer install  
```

3. Create a MySQL database.

4. Set up the `.env` file using `.env.example` as a template.

5. Run the SQL script available in `lib/init.sql` to create the required tables.

6. Navigate in the browser to the `http://localhost/run_init.php` to finalize the setup, And this will by default create user credentials:
  - **Username** : `admin1`
  - **Password** : `password`


## Configuring a Virtual Host

If you need to configure a virtual host to deploy this application, you can follow the instructions provided in the README file of the [linux-apache-virtual-host-setup](https://github.com/B-Yahia/linux-apache-virtual-host-setup) repository.

## Requirements
  - PHP 7.4+
  - MySQL
  - Composer
