# simple-sku
Small web app to maintain an SKU list

## What you need to run it ##
* Apache Webserver
* PHP 7+ with PDO
* MySQL 5+
* IDE with support for UTF8 encoded files

## Setup ##
1. Clone this repository into a directory of your choice
2. Create a vhost for the site 
3. Add database DSN and access credentials to file __framework\boot.php__
4. Create the database and table. Example:
```
drop database products;
create database products;
use products;
create table tbl_sku (
    pk          int unsigned auto_increment primary key,
    sku         varchar(64) unique not null,
    description varchar(128) not null,
    created_at  datetime not null,
    updated_at  datetime null on update current_timestamp
) engine=innodb default charset utf8;
```

There is a __public\\.htaccess__ file that makes sure all requests go to the index file. 

That's it, run it!

## What next? ##
Adding more to it!

This app is built on top of a micro MVC framework written in PHP, so get to it! :) 

## Directories the framework will use ##
* app 
  * __controller__, where your controllers __must__ be 
  * __model__, where your models __must__ be 
    * __repository__, where your model repositories __must__ be 
  * __view__, where your views __must__ be
* public
  * __assets__, where your Javascript and CSS files __must__ be

Inside the __app__ directory you can also find the __routes.php__ file.

Controller, model, repository and view classes extend base classes and implement some interfaces. (Feel free to hack away with your IDE...)

## How do i use it? ##
1. Define a request/route and what will handle it.
2. Write some business logic inside a controller
   1. create/use models?
   2. create/use model repositories?
3. Write some HTML in a view, to show data and allow clients to interact with the app
4. Write some javascript code for your client side needs
5. Access the app in your browser

## Output to the client side ##
Return a View instance from the controller and the kernel will run the __render()__ method and output the HTML to the client.
Return any other type and the kernel will __json_encode()__ it before output to the client.

### How do i define a route? ###
Each route is an array inside the main routes array. It is defined by:
   1. an HTTP method (GET or POST supported)
   2. a regular expression describing the URI which it matches
   3. the handler class name with namespace
   4. the name of the method handling the request
      1. if "null" value the kernel assumes that you want to show a view and will call the "render()" its method on its own

### How do i create a controller? ###
Copy & paste & rename the example __app\controller\Sku.php__ until you get the gist of it.

Controllers __must extend framework\base\bController.php base class__ which implements __framework\interfaces\iController.php__ interface. This interface defines __pre()__ and __post()__ method. The first is not yet implemented (... could be used to write input validation). The latter is and will be run after the controller method that handles the route is executed. __If you override any of these methods don't forget to call the parent method inside your method!__

### How do i create a model? ###
Copy & paste & rename from the example __app\model\SkuModel.php__ until you get the gist of it.

The model is a representation of a database table (... but unaware of the database, that "connection" is made in the repository but we'll get to that later).

Models __must extend framework\base\bModel.php base class__ which implements __framework\interfaces\iModel.php__. This interface defines magic methods that assert whether you can modify model values.  

By default all Model members are protected, you need to write your own getter and/or setter methods to access them outside the model. The __columns[ ]__ array holds the model members, which __should__ correspond to the database table columns. The __access\['public'\]__ array holds the list of members you can access freely from the __columns[ ]__ array. Feel free to use your IDE to check __framework\base\bModel.php__ base class.

### How do i create a repository? ###
Copy & paste & rename the example __app\model\repository\SkuRepository.php__ until you get the gist of it.

The repository has the capability to create, retrieve and persist Model instances from/to the database. It extends __framework\base\bRepository.php__ base class and implements __framework\interfaces\iRepository.php__.

To persist the models to the database use the __save()__ method. If you don't the kernel will do it for you, if the repository is stored in __$repository__ controller member (... see __post()__ method in __framework\base\bcontroller.php__ base class).

### How do i create a view? ###
Copy & paste & rename from the example __app\view\Sku.php__ until you get the gist of it.

Views __must__ extend __bView base class__ which implements __iView interface__. This interface defines the __render()__ and __setViewData()__ methods. The __render()__ method is where you place the HTML you want to send to the client (... or create a partial content for some other view). The __setViewData()__ method is used to pass data to be used inside the view.

## How all of this comes together? Dependecy injection ##
The framework kernel uses a __framework\Factory.php__ to automatically inject dependencies defined in class methods. You can also use the factory to get class instances. It has two methods:
* __getInstance()__, will return a class instance with __\_\_construct()__ dependencies already injected
* __getMethod()__, will return a class and method instances with dependencies already injected. __Do not call__ unless you know what you are doing.

# What it does not do #
* Access and authorization
* Automatic input data validation
* Database connection management

# Are there bugs in the code? #
Yes, minor.
