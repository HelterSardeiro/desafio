<?php
abstract class Crud{
    abstract public function delete($id);
    abstract public function read($id = null);
}
class Product extends Crud
{
    private $conn;
    function __construct() {
        $username = 'root';
        $password = '';
        $this->conn = new PDO('mysql:host=localhost;dbname=market', $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function create($name, $price, $amount, $sku, $description, $category, $url = null)
    {
        $insert = $this->conn->prepare("INSERT INTO products (name, price, amount, sku, description, category, url) VALUES (:name, :price, :amount, :sku, :description, :category, :url)");
        $insert->bindParam(':name', $name);
        $insert->bindParam(':price', $price);
        $insert->bindParam(':amount', $amount);
        $insert->bindParam(':sku', $sku);
        $insert->bindParam(':description', $description);
        $insert->bindParam(':category', $category);
        $insert->bindParam(':url', $url);
        return $insert->execute();
    }

    public function read($id = null)
    {
        $result = '';
        if(!empty($id)){
            $read = $this->conn->prepare('SELECT * FROM products WHERE id = ?');
            $read->bindParam(1, $id, PDO::PARAM_INT);
            $read->execute();
            $result = $read->fetch(PDO::FETCH_OBJ);
        } else {
            $read = $this->conn->prepare('SELECT * FROM products');
            $read->execute();
            $result = $read->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }

    public function update($id, $name, $price, $amount, $sku, $description, $category, $url = null)
    {
        $update = $this->conn->prepare("UPDATE products set name = :name, price = :price, amount = :amount, sku = :sku, description = :description, category = :category, url = :url where id = :id LIMIT 1");
        $update->bindParam(':id', $id);
        $update->bindParam(':name', $name);
        $update->bindParam(':price', $price);
        $update->bindParam(':amount', $amount);
        $update->bindParam(':sku', $sku);
        $update->bindParam(':description', $description);
        $update->bindParam(':category', $category);
        $update->bindParam(':url', $url);
        return $update->execute();
    }

    public function delete($id)
    {
        $delete = $this->conn->prepare("DELETE FROM products where id = :id");
        $delete->bindParam(':id', $id);
        return $delete->execute();
    }
}

class Category  extends Crud
{
    private $conn;
    function __construct() {
        $username = 'root';
        $password = '';
        $this->conn = new PDO('mysql:host=localhost;dbname=market', $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function create($name, $code)
    {
        $insert = $this->conn->prepare("INSERT INTO categories (name, code) VALUES (:name, :code)");
        $insert->bindParam(':name', $name);
        $insert->bindParam(':code', $code);
        return $insert->execute();
    }

    public function read($id = null)
    {
        $result = '';
        if(!empty($id)){
            $read = $this->conn->prepare('SELECT * FROM categories WHERE id = ?');
            $read->bindParam(1, $id, PDO::PARAM_INT);
            $read->execute();
            $result = $read->fetch(PDO::FETCH_OBJ);
        } else {
            $read = $this->conn->prepare('SELECT * FROM categories');
            $read->execute();
            $result = $read->fetchAll(PDO::FETCH_OBJ);
        }
        return $result;
    }

    public function update($id, $name, $code)
    {
        $update = $this->conn->prepare("UPDATE categories set name = :name, code = :code where id = :id LIMIT 1");
        $update->bindParam(':id', $id);
        $update->bindParam(':name', $name);
        $update->bindParam(':code', $code);
        return $update->execute();
    }

    public function delete($id)
    {
        $delete = $this->conn->prepare("DELETE FROM categories where id = :id");
        $delete->bindParam(':id', $id);
        return $delete->execute();
    }
}