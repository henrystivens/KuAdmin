<?php

/**
 * Base Controller for building REST API for models quickly
 *
 * @category Kumbia
 * @package  Controller
 */
abstract class ControllerScaffoldRest extends ControllerRest
{
    /** @var string Model Name in CamelCase */
    public $model = '';
    /** @var int Number of records per page */
    public $perPage = 1;

    /**
     * Returns a record through the ID
     * GET method object/:id
     */
    public function get(int $id)
    {
        $data = $this->model::get($id);

        if (!$data) {
            http_response_code(404);
        }

        $this->data = $data;
    }

    /**
     * List all records
     * GET method object/
     */
    public function getAll()
    {
        $this->data = $this->model::paginateQuery('SELECT * FROM ' . strtolower($this->model), 1, $this->perPage);
    }

    public function get_page(int $page = 1)
    {
        $this->data = Users::paginateQuery('SELECT * FROM ' . strtolower($this->model), $page, $this->perPage);
    }

    /**
     * Create a new record
     * POST method object/
     */
    public function post()
    {
        try {
            $obj = new $this->model;
            
            if (!$obj->create($this->param())) {
                http_response_code(400);
                return;
            }

            http_response_code(201);
            $this->data = $obj;
        } catch (Exception $e) {
            $this->data = $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Update a record by $id
     * PUT method object/:id
     */
    public function put(int $id)
    {
        $obj = $this->model::get($id);
        if (!$obj->update($this->param())) {
            http_response_code(400);
            return;
        }

        http_response_code(201);
        $this->data = $obj;
    }

    /**
     * Delete a record by $id
     * DELETE method object/:id
     */
    public function delete(int $id)
    {
        if (!$this->model::delete($id)) {
            http_response_code(400);
            return;
        }

        http_response_code(204);
        $this->data = [];
    }
}
