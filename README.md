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

In the directory, assuming I have valet installed - I can then run the command:

```bash
valet link .
```

&nbsp;

---

&nbsp;

### Make a GET request

```bash
http php-rest-api.test/products
```

Example Output:

```bash
HTTP/1.1 200 OK
...

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
    },
]
```

---

&nbsp;

### Make a POST request

- name (string)
- size (int)
- is_available (boolean)

```bash
http post php-rest-api.test/products name="Test Product"
```

Example Output:

```bash
HTTP/1.1 200 OK
...

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
    },
    {
        "id": 4,
        "is_available": false,
        "name": "Test Product",
        "size": 0
    }
]
```

---

&nbsp;

### Make a PATCH request

- name (string)
- size (int)
- is_available (boolean)

```bash
http patch php-rest-api.test/products/4 name="New Product 4"
```

Example Output:

```bash
HTTP/1.1 200 OK
...

{
    "message": "Product 4 updated",
    "rows": 1
}
```

Run GET request again to see changes:

```bash
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
    },
    {
        "id": 4,
        "is_available": false,
        "name": "New Product 4",
        "size": 0
    },
]
```

---

&nbsp;

### Make a DELETE request

```bash
http delete php-rest-api.test/products/4
```

Example Output:

```bash
HTTP/1.1 200 OK
...

{
    "message": "Product 4 deleted",
    "rows": 1
}
```
