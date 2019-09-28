What is this repository for?

    This repository is majorly for web services, it's a MVC todo web based application written in codeigniter, whereby a user can create (events and time of the events ), set the event status(completed or pending), update and delete and also search an event. There is a signup page for users to register, a user authentication page and a login page page after successful registration.

How do I get set up?

    Registration page->Login page->user page
    bootstrap, JQuery
    Database configuration
        Host->"localhost" or "127.0.0.1"
        Username->"root"
        Password->""
        Database->Todo
        TABLES
            users-> holds user details
            todo->holds events
            column todo.user_id=users.id is the matching order
						SQL:
 CREATE DATABASE todo;						
 CREATE TABLE users(
  id INT NOT NULL  AUTO_INCREMENT PRIMARY KEY ,
  username VARCHAR(50) NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
);

CREATE  TABLE  todo (
  id INT  NOT  NULL AUTO_INCREMENT PRIMARY KEY ,
  event VARCHAR (100) NOT  NULL ,
  time VARCHAR(10) NOT  NULL ,
  status tinyint(1) DEFAULT 0,
  user_id INT NOT NULL,
  CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

						
		config : base_url=>http://http://localhost/Codeigniter-todo-application/
		registration page=>http://localhost/Codeigniter-todo-application/index.php/home/signup
		signin page  =>http://localhost/Codeigniter-todo-application/index.php/home/login
		user page =>http://http://localhost/Codeigniter-todo-application/home
		user profile page =>http://http://localhost/Codeigniter-todo-application/home/profile/username
ROUTES
$route['home'] = 'home/index';
$route['home/login'] = 'users/login';
$route['home/signup'] = 'users/sign_up';
$route['home/profile/(:any)'] = 'users/profile/$1';
