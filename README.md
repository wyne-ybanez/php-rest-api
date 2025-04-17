# Basic PHP REST API

- Basic REST API routing and URLs
- List, show, create, update and delete database records using a RESTful API
- Best-practice code organisation
- Controllers and table gateways
- Relevant HTTP status codes
- Data validation
- JSON decoding and encoding

## Setup

- [Laravel Valet](https://laravel.com/docs/11.x/valet)
- [HTTPie](https://httpie.io)
- PHP 8(+)

You will need to run the database commands in `database.sql` in this project within your DBMS.

Feel free to customize the sample sql file further.

## Example

Assuming I'm in the `/Sites` or `/Dev` directory. I have established my valet link. I have added my sample DB. I have added sample product rows.

Everything looks good to go.

This is what my terminal looks like:

```bash
~/dev/php-rest-api
```

Now I can do something like this:

```bash
 http php-rest-api.test/products
```

It should then output this (as an example):

```bash
HTTP/1.1 200 OK
Connection: keep-alive
Content-Encoding: gzip
Content-Type: application/json; charset=UTF-8
Date: Thu, 17 Apr 2025 15:05:31 GMT
Server: nginx/1.27.1
Transfer-Encoding: chunked
Vary: Accept-Encoding
X-Powered-By: PHP/8.2.28

[
    {
        "id": 1,
        "is_available": true,
        "name": "product 1",
        "size": 10
    },
    {
        "id": 2,
        "is_available": true,
        "name": "product 2",
        "size": 20
    },
    {
        "id": 3,
        "is_available": true,
        "name": "product 3",
        "size": 30
    }
]
```
