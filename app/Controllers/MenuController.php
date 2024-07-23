<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class MenuController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = session();
    }

    /**
    * Display the homepage view.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function index()
    {
        return view('homepage');
    }

    /**
    * Display the signup view.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function signup()
    {
        return view('signup');
    }

    /**
    * Handle user registration.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
           
            $model = new UserModel();

            $data = [
                'cafe_name' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'address' => $this->request->getPost('address'),
            ];

            if ($model->insert($data)) {
                $this->session->setFlashdata('success', 'User registered successfully.');
                return redirect()->to('/login');
            } else {
                $errors = $model->errors(); 
                $this->session->setFlashdata('error', 'Failed to register user. Please try again.');
                return redirect()->to('/signup');
            }
        }

        return view('signup');
    }

    /**
    * Handle user login.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    // public function login()
    // {
    //     if ($this->request->getMethod() === 'POST') {
    //         $userModel = new \App\Models\UserModel();
    //         $email = $this->request->getPost('email');
    //         $password = $this->request->getPost('password');

    //         $user = $userModel->where('email', $email)->first();

    //         if ($user && password_verify($password, $user['password'])) {
    //             $this->session->set('logged_in', true);
    //             $this->session->set('user_id', $user['user_id']);
    //             return redirect()->to('/admin');
    //         } else {
    //             $this->session->setFlashdata('error', 'Invalid login credentials');
    //             return redirect()->to('/login');
    //         }
    //     }

    //     return view('login');
    // }
    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $userModel = new \App\Models\UserModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                $this->session->set('logged_in', true);
                $this->session->set('user_email', $user['email']);
                return redirect()->to('/admin');
            } else {
                $this->session->setFlashdata('error', 'Invalid login credentials');
                return redirect()->to('/login');
            }
        }

        return view('login');
    }

    /**
    * Handle user logout.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    /**
    * Display the admin view with restaurant list under same account and search functionality.
    *
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function admin()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $model = new UserModel();
        $userEmail = $this->session->get('user_email');
        $search = $this->request->getGet('search');
    
        if (!empty($search)) {
            $conditions = [];
            foreach ($model->allowedFields as $field) {
                $conditions[] = "$field LIKE '%$search%'";
            }
            $whereClause = implode(' OR ', $conditions);
            $restaurants = $model->where('email', $userEmail)->where($whereClause)->orderBy('cafe_name', 'ASC')->findAll();
        } else {
            $restaurants = $model->where('email', $userEmail)->orderBy('cafe_name', 'ASC')->findAll();
        }
    
    
        $data['restaurants'] = $restaurants;
        return view('admin', $data);
    }
    

    /**
    * Load the ordering view with $data array about specified table and menu.
    *
    * @param int $table_id Table ID
    * @param int $menu_id Menu ID
    * @return \CodeIgniter\HTTP\RedirectResponse
    */
    public function ordering($table_id, $menu_id)
    {
        $userModel = new \App\Models\UserModel();
        $dishesModel = new \App\Models\DishesModel();
        $milksModel = new \App\Models\MilksModel();
        $categoryModel = new \App\Models\CategoryModel();
        $tableModel = new \App\Models\TablesModel();
        $menuModel = new \App\Models\MenusModel();

        $data['table'] = $tableModel->where('table_id', $table_id)->first();
        $data['menu'] = $menuModel->where('menu_id', $menu_id)->findAll();
        if ($data['table'] && isset($data['table']['user_id'])) {
            $user_id = $data['table']['user_id'];  // get user_id from table data
            $data['user'] = $userModel->where('user_id', $user_id)->first(); // get the cafe name using user_id

        } else {
            echo "Table data or User ID not found.";
        }

        $dishes = $dishesModel->where('menu_id', $menu_id)->findAll();
        $categories = $categoryModel->findAll();

        $reorderCategories = [];
        foreach ($categories as $category) {
            if ($category['name'] != "Not selected") {
                $reorderCategories[] = $category;
            }
        }

        $data['categoriesDishes'] = [];
        // put dishes into each category
        foreach ($reorderCategories as $category) {
            $filteredDishes = array_filter($dishes, function ($dish) use ($category) {
                return $dish['category_id'] == $category['category_id'];
            });

            if (!empty($filteredDishes)) { 
                $data['categoriesDishes'][] = [
                    'category_info' => $category,
                    'dishes' => $filteredDishes
                ];
            }
        }

        $data['milks'] = $milksModel->findAll();

        return view('ordering', $data);
    }

    
    /**
     * Load user's menu view and pass the $data array to it.
     * 
     * @param int $user_id User ID
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function menu($user_id)
    {
        $userModel = new \App\Models\UserModel();
        $menuModel = new \App\Models\MenusModel();
        $tableModel = new \App\Models\TablesModel();

        // Fetch user details by user_id
        $data['user'] = $userModel->find($user_id);

        // Ensure user exists
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User Not Found');
        }

        // Fetch related data
        $data['menus'] = $menuModel->where('user_id', $user_id)->findAll();
        $data['tables'] = $tableModel-> getTablesWithOrders($user_id);


        return view('menu_view', $data);
    }

    /**
     * Load menu's dishes view and pass the $data array to it.
     * 
     * @param int $menu_id Menu ID
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function dishes($menu_id)
    {
        $menuModel = new \App\Models\MenusModel();
        $dishesModel = new \App\Models\DishesModel();
        $milksModel = new \App\Models\MilksModel();
        $categoryModel = new \App\Models\CategoryModel();


        // Fetch dishes details by user_id
        $data['menu'] = $menuModel->find($menu_id);
        $dishes = $dishesModel->where('menu_id', $menu_id)->findAll();
        $categories = $categoryModel->findAll();

        $notSelected = null;
        $reorderCategories = [];
        foreach ($categories as $category) {
            if ($category['name'] == "Not selected") {
                $notSelected = $category;  
            } else {
                $reorderCategories[] = $category;  
            }
        }

        // Put category "not selected" to the end of the array.
        if ($notSelected) {
            $reorderCategories[] = $notSelected;
        }

        $data['categoriesDishes'] = [];
        foreach ($reorderCategories as $category) {
            $filteredDishes = array_filter($dishes, function ($dish) use ($category) {
                return $dish['category_id'] == $category['category_id'];
            });
            $data['categoriesDishes'][] = [
            'category_info' => $category,
            'dishes' => $filteredDishes
            ];
        }

        return view('dish_view', $data);
    }

    /**
     * Load orders view and pass the $data array to it.
     * 
     * @param int $table_id Table ID
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function orders($table_id)
    {
        $tableModel = new \App\Models\TablesModel();
        $orderModel = new \App\Models\OrdersModel();

        // Fetch dishes details by table_id
        $data['table'] = $tableModel-> getSpecificTablesOrders($table_id);
        $data['fullOrders'] = $orderModel-> getCompleteOrderDetails($table_id);


        return view('order_view', $data);
    }

    /**
     * Update order's status.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateOrderStatus()
    {
        $orderModel = new \App\Models\OrdersModel();
        $data = $this->request->getJSON(true);

        // Check if request data exists and contains order_id and status
        if (isset($data['order_id']) && isset($data['status'])) {
            $orderId = $data['order_id'];
            $status = $data['status'];

            if ($orderModel->update($orderId, ['status' => $status])) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update order status.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request data.']);
        }
    }

    /** 
     * Add and Edit cafe in the admin panel
     * 
     * @param int|null $id User ID(null for adding new user)
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function addedit($id = null)
    {
        $userModel = new UserModel();
        $userEmail = $this->session->get('user_email');
        $user = $userModel->where('email', $userEmail)->first();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'email' => $userEmail,
                'cafe_name' => $this->request->getPost('cafe_name'),
                'address' => $this->request->getPost('address'),
            ];

            if ($id === null) {
                if ($userModel->insert($data)) {
                    $this->session->setFlashdata('success', 'Restaurant added successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to add restaurant. Please try again.');
                }
            } else {
                if ($userModel->update($id, $data)) {
                    $this->session->setFlashdata('success', 'Restaurant updated successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to update restaurant. Please try again.');
                }
            }
        
            return redirect()->to('/admin');
        }

        $data['user'] = $user;
        $data['restaurant'] = ($id === null) ? null : $userModel->find($id);
        return view('addedit', $data);
    }


    /**
     * Delete user in admin panel.
     * 
     * @param int $id User ID
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $userModel = new \App\Models\UserModel();

        if ($userModel->delete($id)) {
            $this->session->setFlashdata('success', 'User deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Failed to delete user. Please try again.');
        }

        return redirect()->to('/admin');
    }

    /** 
     * Add and Edit menu in the menu view.
     * 
     * @param int|null $id Menu ID(null for adding new menu)
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function menuaddedit($id = null)
    {
        $userModel = new \App\Models\MenusModel();
        $data['user']['user_id'] = $this->request->getGet('user_id');

        if ($this->request->getMethod() === 'POST') {
            // Retrieve the submitted form data.
            $data = $this->request->getPost();

            // If no menu_id is provided, add new menu.
            if ($id === null) {
                if ($userModel->insert($data)) {
                    $this->session->setFlashdata('success', 'Menu added successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to add menu. Please try again.');
                }
            } else {
                // If menu_id is provided, edit existing menu.
                if ($userModel->update($id, $data)) {
                    $this->session->setFlashdata('success', 'Menu updated successfully.');
                } else {
                    $this->session->setFlashdata('error', 'Failed to update menu. Please try again.');
                }
            }

            // Redirect back to the admin page after the operation.
            return redirect()->to('/menu/'.$data['user_id']);
        }

        // If the request is a GET request, load the form with existing menu data (for edit) or as blank (for add).
        $data['menu'] = ($id === null) ? null : $userModel->find($id);
        // Display the add/edit form view, passing in the menu data if available.
        return view('menuaddedit', $data);
    }

    /** 
     * Delete menu in the menu view.
     * 
     * @param int|null $id Menu ID
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function menudelete($id)
    {
        $userModel = new \App\Models\UserModel();

        if ($userModel->delete($id)) {
            $this->session->setFlashdata('success', 'Menu deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Failed to delete menu. Please try again.');
        }

        return redirect()->to('/menu/'.$id);
    }

    /** 
     * Place and order and save it to the database.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function placeOrder()
    {
        $orderModel = new \App\Models\OrdersModel();
        $customizationModel = new \App\Models\CustomizationsModel();

        // Get JSON data from the request and convert it to a PHP array
        $orderData = $this->request->getJSON(true);

        // Prepare order data to be inserted
        $order = [
            'user_id' => $orderData['user_id'],
            'table_id' => $orderData['table_id'],
            'total_price' => $orderData['totalPrice'],
            'status' => 'Received'
        ];

        try {
            // Insert order data and get the inserted order ID
            $orderId = $orderModel->insert($order);

            // Check if insertion was successful
            if ($orderId === false) {
                $errors = $orderModel->errors();
                log_message('error', 'Order Insert Error: ' . print_r($errors, true));
                return $this->response->setJSON(['success' => false, 'message' => 'Order Insert Error', 'errors' => $errors]);
            }

            // Insert customization data
            $customizationIds = [];
            foreach ($orderData['dishes'] as $dish) {
                if (!empty($dish['customization'])) {
                    $customization = [
                        'dish_id' => $dish['dishId'],
                        'customization' => $dish['customization']
                    ];
                    $customizationId = $customizationModel->insert($customization);
                    $customizationIds[] = $customizationId;
                } else {
                    $customizationIds[] = null;
                }
            }

            // Return order ID and customization IDs
            return $this->response->setJSON(['success' => true, 'order_id' => $orderId, 'customization_ids' => $customizationIds]);
        } catch (\Exception $e) {
            log_message('error', 'Place Order Exception: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Internal Server Error']);
        }
    }

    /** 
     * Place order details and save them to the database
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function placeOrderDetails()
    {
        $orderDetailsModel = new \App\Models\OrderDetailsModel();
        
        // Get JSON data from the request and convert it to a PHP array 
        $orderDetailsData = $this->request->getJSON(true);

        foreach ($orderDetailsData as $detail) {
            $orderDetail = [
                'order_id' => $detail['order_id'],
                'dish_id' => $detail['dish_id'],
                'customization_id' => $detail['customization_id'],
                'quantity' => $detail['quantity'],
                'milk_id' => isset($detail['milk_id']) ? $detail['milk_id'] : null
            ];

            $orderDetailsModel->insert($orderDetail);
        }

        return $this->response->setJSON(['success' => true]);
    }

}


