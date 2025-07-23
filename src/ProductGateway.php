<?php

/*
    Methods in this class serve as a gateway to the product table in the database.
*/
class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        // create sql statement to query the db
        // assign statment to a variable
        // create an empty array for data storage
        // return an array of rows (associative array)

        $sql = "SELECT *
                FROM product";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row["is_available"] = (bool) $row["is_available"]; // boolean literal - 'true' or 'false' rather than 1 or 0
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        // create sql statement
        // prepare sql statment on the db connection property
        // bind the values to the placeholders, define values types
        // execute the statment
        // return the ID of the record inserted

        $sql = "INSERT INTO product (name, size, is_available)
                VALUES (:name, :size, :is_available)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":size", $data["size"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":is_available", (bool) ($data["is_available"] ?? false), PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        // create sql statement
        // prepare sql statment on the db connection property
        // bind the values of the ID arguement as an integer
        // execute the statment
        // fetch the record as an associative array
        // check if product is available (as a boolean value)
        // return array data or false if there is no data

        $sql = "SELECT *
                FROM product
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["is_available"] = (bool) $data["is_available"];
        }

        return $data;
    }

    public function update(array $product, array $new): int
    {
        // compare current array data with new array data

        // create update statement WHERE id = product's id
        // prepare sql statment on the db connection property
        // bind values to placeholders
        // bind ID value that we get it from the current values
        // execute statement
        // return number of rows affected

        $sql = "UPDATE product
                SET name = :name, size = :size, is_available = :is_available
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $product["name"], PDO::PARAM_STR);
        $stmt->bindValue(":size", $new["size"] ?? $product["size"], PDO::PARAM_INT);
        $stmt->bindValue(":is_available", $new["is_available"] ?? $product["is_available"], PDO::PARAM_BOOL);

        $stmt->bindValue(":id", $product["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {
        // delete record from the table identified by ID
        // prepare sql statment on the db connection property
        // bind ID to ID placeholder
        // execute statement
        // return number of rows affected

        $sql = "DELETE FROM product
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
