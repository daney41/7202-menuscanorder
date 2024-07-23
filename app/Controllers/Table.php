<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TablesModel;

/*
* RESTFul API for TablesModel
*/
class Table extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new TablesModel();

        // Retrieve 'user_id' from query parameters if provided.
        $userId = $this->request->getGet('user_id');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $userId ? $model->where('user_id', $userId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $model = new TablesModel();

        // Attempt to retrieve the specific Tables entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No Table found with ID: {$id}");
        }
    }

    public function create()
    {
        $model = new TablesModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'Table created successfully.');
        } else {
            return $this->failServerError('Failed to create new Table.');
        }
    }

    public function update($id = null)
    {
        $model = new TablesModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No Table found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'Table updated successfully.');
        } else {
            return $this->failServerError('Failed to update Table.');
        }
    }

    public function delete($id = null)
    {
        $model = new TablesModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No Table found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Table deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete Table.');
        }
    }
}