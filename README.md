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
1. Clone the Skeletor git repository into your project's root directory or a subdirectory
2. Run the SQL folder 'bd'

## Directory Structure
Intraway probe can be the entirety of your web project or live side-by-side with your CMS source directory, depending on your needs. The default directory structure is as follows:

```
Intraway
|-- bd/
|   |-- script.sql
|-- src/
|   |-- controller/
|   |   | -- StatusAPI.php 
|   |-- model/
|   |   | -- StatusDB.php
|-- test/
|   |-- src/
|   |   |-- controller/
|   |   |   | -- StatusAPITest.php 
|   |   |-- model/
|   |   |   | -- StatusDBTest.php
|-- index.php
```

## Configuration
Configuration variables at the beginning of each class. 
