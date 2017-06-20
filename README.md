# phpBlog

This php Blog system has a MVC pattern, use Twig v2.0 (Require php 7.0), Namespaces, Bootstrap v3.3, jQuery v3.2, and PDO.

I built this project for my php oop learning with [OpenClassRooms](https://openclassrooms.com/).

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

* Local server environment or live server
* PHP v7.0
* MySQL v5.0 or higher


### Installing



* Clone or download the repository, and put files into your environment

```
https://github.com/natinho68/phpBlog.git
```

* Import or create a database with the same structure as the file **blog.sql in the root folder of the project**.
* Edit the **Database.php** class in **app/Natinho68/Config/Database.php** with your connection informations to the database
```php
/**
   * Constant: username of db
   *
   * @var string
   */
  const DEFAULT_SQL_USER = 'root';
 
  /**
   * Constant: host of db
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = 'localhost';
 
  /**
   * Constant: password of db
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'root';
 
  /**
   * Constant: name of db
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'blogtwig';
 
```
* Go into **"Blog" in the nav bar** and see if you get your blog posts.

## Built With

* [Composer](https://getcomposer.org/) - Used for dependency manager
* [Twig](https://twig.sensiolabs.org/) - Used for template engine
* [Bootstrap](http://getbootstrap.com/) - Used for design and responsive
* [jQuery](https://rometools.github.io/rome/) - Used for animations
* [Google fonts](https://fonts.google.com/) - Used for polices
* [Freepik](http://fr.freepik.com/) - Used for illustrations images

## Authors

[**Nathan MEYER**](https://github.com/natinho68)

See also [ismail1432](https://github.com/ismail1432) who helps me a lot in this project.