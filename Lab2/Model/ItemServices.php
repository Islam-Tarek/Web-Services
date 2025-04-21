<?php

class ItemServices
{
    // localhost:8000/items/id

    private MySQLHandler $handler;

    public function __construct()
    {
        $this->handler = new MySQLHandler("products");
    }

    public function getItem($id)
    {
        $result = $this->handler->get_record_by_id($id);
        return !empty($result) ? $result[0] : $result;
    }
    public function getAllItems()
    {
        $result =  $this->handler->get_data();
        // return $this->handler->get_data();
        return $result;
    }
    public function createItem($data)
    {
        return $this->handler->save($data);
    }
    public function updateItem($id, $data)
    {
        return $this->handler->update($data, $id);
    }
    public function deleteItem($id)
    {
        return $this->handler->delete($id);
    }
}
