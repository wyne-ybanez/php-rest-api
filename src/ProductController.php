<?php

class ProductController
{
    // Ensures the value of this arguement will be assigned to a private property with the same name
    public function __construct(private ProductGateway $gateway) {}

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            $this->processResourceRequest($method, $id);
        } else {
            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        // fetch product via ID
        // if product is not found - give 404 response & message

        // GET - output the product data as json

        // PATCH - update an existing record
        // get data from request
        // validate input data
        // update existing record
        // return the number of rows affected and ID of product changed

        // DELETE - delete record from the table identified by ID

        $product = $this->gateway->get($id);

        if (! $product) {
            http_response_code(404);
            echo json_encode(["message" => "Product not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($product);
                break;

            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if (! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($product, $data);

                echo json_encode([
                    "message" => "Product $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "Product $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405); // method not allowed
                header("Allow: GET, PATCH, DELETE"); // specify allowed methods
        }
    }

    private function processCollectionRequest(string $method): void
    {
        // GET -  encodes data into JSON format
        // in HTTPie, data is encoded as strings by default so strict typing must be kept in mind when making a POST request e.g. size:=30

        // POST - decodes input data into an associative array
        // validate input data
        // if data passes, create data -> call gateway create method on the data
        // echo a response message

        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if (! empty($errors)) {
                    http_response_code(422); // unprocessable entity
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(201); // response for inserting a record
                echo json_encode([
                    "message" => "Product created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405); // method not allowed
                header("Allow: GET, POST"); // specify whats allowed
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        // initialize an empty array
        // validate the name field, should only work if we're creating a new record
        // validate the size field, check if integer
        // return errors array

        $errors = [];

        if ($is_new && empty($data["name"])) {
            $errors[] = "name is required";
        }

        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "size must be an integer";
            }
        }

        return $errors;
    }
}
