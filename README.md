# Javier Fonseca POC

## How to build the POC?

To start it's neccesary to build the images used on this POC. To do that simply execute the script build_image.sh

### **PHP Image**

`./build_image.sh 2`

### **PostgreSQL Image**

`./build_image.sh 1`

### **Executing docker-compose**

Edit **DATABASE_CON** environment variable of **php** task using host Docker IP.

On main directory execute

`docker-compose up -d`

-------------

### **Building demo database**

To build the demo database it's necessary to use the following schema

<code> CREATE TABLE companies(
   company_id SERIAL PRIMARY KEY,
   company_name VARCHAR(255) NOT NULL
);

CREATE TABLE contacts(
   contact_id SERIAL PRIMARY KEY,
   company_id INT,
   contact_name VARCHAR(255) NOT NULL,
   phone VARCHAR(25),
   email VARCHAR(100),
   CONSTRAINT fk_company
      FOREIGN KEY(company_id) 
      REFERENCES companies(company_id)
); </code>

And execute the following command

`synth generate db_data_test --size 200 --to postgres://root:poc123@localhost:5432/root`

Reference: https://github.com/shuttle-hq/synth

-------------

## Vulnerabilities

I introduced two differents vulnerabilities in this POC

### SQL Injection

For this test it's neccesary to go http://localhost/test.php

![php1](Images/sql_injection.png)

To exploit this vulnerability it's possible to execute

`http://localhost/test.php?company_id=4%20OR%201=1`

And obtain all database companies name

![php1](Images/sql_injection2.png)

### Local File Inclusion

IF the code is tested it's easily to infer the website has this code

`include("$file");`

So... executing 

`http://localhost/index.php?file=../../../../../../../../etc/passwd`

We can see the following result

![php1](Images/lfi.png)


## Docker scan

Checking vulnerabilities executing the following command

`docker scan -f Dockerfile php:staging`

It's possible to see there's many vulnerabilties.

![php1](Images/php_scan.png)

## Building CI/CD Pipeline simulation with bash

For this POC I added more options to the bash script

![php1](Images/options.png)

So, option 4 will scan the images and if any of this images have more than 10 vulnerabilities it will break the execution. 

However I allowed to the user execute the docker-compose with option 3 just for this POC
