# F4u test

#### by Gapanovich Vadim

Let's say, in our system we have two models "client" and "shipping address". Let's assume that we already have some existing (registered) clients in our storage. Let's do this simple and assume that our clients have only three properties ID, firstname and lastname.

Client can have several different shipping addresses, but max number is 3. One of them is a default address, so when client adds the first address, it becomes default. Client can change a default address any time.

Client can add a new address, modify an existing address or remove an existing address. Client can not remove a default address, thus there should be at least one address (default) if it was added earlier.

Shipping address includes country, city, zipcode, street.

Implement a console application to be able to add, update, delete and get shipping addresses for a specific client.

Requirements:

Use PHP 7.*
* Use DDD (Domain-Driven Design, Domain-Driven Design in PHP)
* Use any storage you want for storing data, e.g. JSON files. ACID is not important here.
* Cover an application service layer by unit tests. If you need use e.g. PHPUnit. There is no need to cover all methods, just a couple to show the principle.
* Use plain PHP (no frameworks).
* Fork your own copy of eglobal-it/f4u-test-assignment and share the result with us.

# Installation

```javascript
composer install
```

create .env.local file with u local params

create database

```javascript
mysql DATABASE_NAME -u USERNAME -p PASSWORD < ./ddl/delivery.sql
```

# Usage

_Create delivery address_
```javascript
php bin/console address-create -i 1 -c Country -t City -s Street -z 787877
```

Option | Description | Required
------------- | ------------- | -------------
-i    | User ID | true
-c | Delivery country | true
-t | Delivery city | true
-s | Delivery street | true
-z | Delivery zipcode | true




_Update delivery address_
```javascript
php bin/console address-update -i 1 -c Country -t City -s Street -z 787877 -d
```

Option | Description | Required
------------- | ------------- | -------------
-i    | User ID | true
-c | Delivery country | false
-t | Delivery city | false
-s | Delivery street | false
-z | Delivery zipcode | false
-d | Delivery address is default | false



_Remove delivery address_
```javascript
php bin/console address-remove -i 1
```

Option | Description | Required
------------- | ------------- | -------------
-i    | User ID | true

_List delivery address_
```javascript
php bin/console address-list -i 1
```

Option | Description | Required
------------- | ------------- | -------------
-i    | User ID | true

## Tests
**Run tests**
```javascript
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/
```