# Intraway
Technical college entrance exam. API for CRUD state
* [Requirements](#requirements)
* [Installation Instructions](#installation-instructions)
* [Directory Structure](#directory-structure)
* [Configuration](#configuration)

## Requirements
* [PHP](http://php.net) version 5.3+ (for Pattern Lab)
* [PHPUnit](http://php.net) version 5.1.3+ (for Sebastian Bergmann)
* [MySQL](https://mysql.com) version 5.7+ (Oracle)

## Installation Instructions
1. Clone the git repository into your project's root directory or a subdirectory
2. Run the SQL folder 'bd'
3. File configure the variables in the configuration folder
4. Enable writing rules in apache

## Directory Structure
Intraway probe can be the entirety of your web project or live side-by-side with your CMS source directory, depending on your needs. The default directory structure is as follows:

```
Intraway
|-- bd/
|   |-- script.sql
|-- config/
|   |-- Config.php
|-- logs/
|-- src/
|   |-- ado/
|   |   | -- AdoDB.php
|   |-- controller/
|   |   | -- Logs.php
|   |   | -- StatusAPI.php
|   |-- model/
|   |   | -- StatusDB.php
|-- test/
|   |-- src/
|   |   |-- controller/
|   |   |   | -- StatusAPITest.php 
|   |   |-- model/
|   |   |   | -- StatusDBTest.php
|-- autoload.php
|-- index.php
```

## Configuration
Configuration variables at the beginning of each class. 
