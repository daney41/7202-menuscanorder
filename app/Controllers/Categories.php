<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoryModel;

/*
* RESTFul API for CategoryModel
*/
class Categories extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new CategoryModel();

        $data = $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $model = new CategoryModel();

        // Attempt to retrieve the specific Category entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Category found with ID: {$id}");
        }
    }

    public function create()
    {
        $model = new CategoryModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Category created successfully.');
        } else {
            return $this->failServerError('Failed to create new Category.');
        }
    }

    public function update($id = null)
    {
        $model = new CategoryModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Category found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Category updated successfully.');
        } else {
            return $this->failServerError('Failed to update Category.');
        }
    }

    public function delete($id = null)
    {
        $model = new CategoryModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Category found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Category deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Category.');
        }
    }
}