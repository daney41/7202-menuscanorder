<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CustomizationsModel;

/*
* RESTFul API for CustomizationsModel
*/
class Customizations extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new CustomizationsModel();

        // Retrieve 'user_id' from query parameters if provided.
        $userId = $this->request->getGet('user_id');

        // Filter the data by user_id if provided, otherwise retrieve all entries.
        $data = $userId ? $model->where('user_id', $userId)->findAll() : $model->findAll();

        // Use HTTP 200 to return data.
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $model = new CustomizationsModel();

        // Attempt to retrieve the specific Tables entry by ID.
        $data = $model->find($id);

        // Check if data was found.
        if ($data) {
            return $this->respond($data);
        } else {
            // Return a 404 error if no data is found.
            return $this->failNotFound("No customization found with ID: {$id}");
        }
    }

    public function create()
    {
        $model = new CustomizationsModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Validate input data before insertion.
        if (empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Insert data and check for success.
        $inserted = $model->insert($data);
        if ($inserted) {
            return $this->respondCreated($data, 'customization created successfully.');
        } else {
            return $this->failServerError('Failed to create new customization.');
        }
    }

    public function update($id = null)
    {
        $model = new CustomizationsModel();
        $data = $this->request->getJSON(true);  // Ensure the received data is an array.

        // Check if the record exists before attempting update.
        if (!$model->find($id)) {
            return $this->failNotFound("No customization found with ID: {$id}");
        }

        // Update the record and handle the response.
        if ($model->update($id, $data)) {
            return $this->respondUpdated($data, 'customization updated successfully.');
        } else {
            return $this->failServerError('Failed to update customization.');
        }
    }

    public function delete($id = null)
    {
        $model = new CustomizationsModel();

        // Check if the record exists before attempting deletion.
        if (!$model->find($id)) {
            return $this->failNotFound("No customization found with ID: {$id}");
        }

        // Attempt to delete the record.
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'customization deleted successfully.']);
        } else {
            return $this->failServerError('Failed to delete customization.');
        }
    }
}