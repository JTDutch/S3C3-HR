<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use CodeIgniter\Controller;

class Admin extends BaseController
{
    protected $AgendaModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->validator = \Config\Services::validation();
        $this->AccountModel = model('AccountModel');
        $this->AgendaModel = model('AgendaModel');
    }


    public function login()
    {
        helper('form');
        $errors = null;
        if ($this->request->getMethod() == 'POST') {
            // Validation rules
            $rules = [
                'name' => [
                    'rules' => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'The name field is required.',
                        'min_length' => 'Name must be at least 3 characters long.',
                        'max_length' => 'Name can not be more than 255 characters.',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'The password field is required.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password can not be more than 255 characters.'
                    ]
                ]            ];

            // Validate form input
            if ($this->validate($rules)) {
                // If validation is successful, authenticate the user
                $name = $this->request->getPost('name');
                $password = $this->request->getPost('password');
                $user = $this->AccountModel->authenticate($name, $password);

                if ($user) {
                    // Set session variables
                    $this->session->set('account_id', $user->id);

                    // Redirect to the home page
                    return redirect()->to(base_url('Agenda/index'));
                } else {
                    // If authentication fails, set the error message for invalid login
                    $errors = 'Invalid name or password.';
                }
            } else {
                // If validation fails, capture errors
                $errors = $this->validator;
            }
        }

        // Pass the errors and other view data to the view
        $this->viewData['errors'] = $errors;
        $this->viewData['title'] = 'Unhinged | Admin';
        $this->viewData['view'] = 'admin/login';
        echo view('template', $this->viewData);
    }

    public function register(){
        helper('form');
        $errors = null;

        if ($this->request->getMethod() == 'POST') {
            // Validation rules
            $rules = [

                'name' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'The first name field is required.',
                        'max_length' => 'Email can not be more than 255 characters.',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'The password field is required.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password can not be more than 255 characters.'
                    ]
                ]
            ];

            // Validate form input
            if ($this->validate($rules)) {
                // If validation is successful, authenticate the user

                $name = $this->request->getPost('name');
                $password = $this->request->getPost('password');
                $password = password_hash($password, PASSWORD_BCRYPT);
                $user = $this->AccountModel->register($name, $password);

                if ($user) {
                    // Set session variables
                    $this->session->set('account_id', $user->id);
                    $this->session->set('name', $user->name);

                    // Redirect to the home page
                    return redirect()->to(base_url('/Home'));
                } else {
                    // If authentication fails, set the error message for invalid login
                    $errors = 'An error has occurred while trying to create your profile.';
                }
            } else {
                // If validation fails, capture errors
                $errors = $this->validator;
            }
        }

        $this->viewData['errors'] = $errors;
        $this->viewData['title'] = 'Unhinged | Register';
        $this->viewData['view'] = 'admin/register';
        echo view('template', $this->viewData);
    }

    public function add_show()
    {
        helper('form');
        $errors = null;

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'venue_city' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Plaatsnaam is verplicht.',
                        'max_length' => 'Plaatsnaam mag niet langer zijn dan 255 tekens.'
                    ]
                ],
                'venue_name' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Venue naam is verplicht.',
                        'max_length' => 'Venue naam mag niet langer zijn dan 255 tekens.'
                    ]
                ],
                'show_date' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Datum is verplicht.',
                        'valid_date' => 'Ongeldige datum.'
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                $data = [
                    'venue_name' => $this->request->getPost('venue_name'),
                    'venue_city' => $this->request->getPost('venue_city'),
                    'show_date' => $this->request->getPost('show_date'),
                    'show_time' => $this->request->getPost('show_time') ?? 'TBA',
                    'ticket_link' => $this->request->getPost('ticket_link'),
                    'info_link' => $this->request->getPost('info_link')
                ];

                $saved = $this->AgendaModel->add_show($data);

                if ($saved) {
                    return redirect()->to(base_url('/agenda'))->with('success', 'Show toegevoegd!');
                } else {
                    $errors = 'Er is iets misgegaan bij het opslaan van de show.';
                }
            } else {
                $errors = $this->validator;
            }
        }

        $this->viewData['errors'] = $errors;
        $this->viewData['title'] = 'Unhinged | Show Toevoegen';
        $this->viewData['view'] = 'admin/add_show';
        echo view('template', $this->viewData);
    }

    public function edit_show($id)
    {
        helper('form');
        $errors = null;
        
        // Fetch the show data by id from the database
        $show = $this->AgendaModel->get($id);
        
        // If the show doesn't exist, redirect to agenda page or show an error
        if (!$show) {
            return redirect()->to(base_url('/agenda'))->with('error', 'Show not found.');
        }

        // Check if the form was submitted
        if ($this->request->getMethod() === 'POST') {
            // Validation rules
            $rules = [
                'venue_city' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Plaatsnaam is verplicht.',
                        'max_length' => 'Plaatsnaam mag niet langer zijn dan 255 tekens.'
                    ]
                ],
                'venue_name' => [
                    'rules' => 'required|max_length[255]',
                    'errors' => [
                        'required' => 'Venue naam is verplicht.',
                        'max_length' => 'Venue naam mag niet langer zijn dan 255 tekens.'
                    ]
                ],
                'show_date' => [
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => 'Datum is verplicht.',
                        'valid_date' => 'Ongeldige datum.'
                    ]
                ]
            ];

            // If the form is valid
            if ($this->validate($rules)) {
                // Prepare updated data
                $data = [
                    'venue_name' => $this->request->getPost('venue_name'),
                    'venue_city' => $this->request->getPost('venue_city'),
                    'show_date' => $this->request->getPost('show_date'),
                    'show_time' => $this->request->getPost('show_time') ?? 'TBA',
                    'ticket_link' => $this->request->getPost('ticket_link'),
                    'info_link' => $this->request->getPost('info_link')
                ];

                // Update the show in the database
                $updated = $this->AgendaModel->update_show($id, $data);

                if ($updated) {
                    return redirect()->to(base_url('/agenda'))->with('success', 'Show updated successfully!');
                } else {
                    $errors = 'Something went wrong while updating the show.';
                }
            } else {
                $errors = $this->validator;
            }
        }

        // Pass the current show data to the view
        $this->viewData['errors'] = $errors;
        $this->viewData['show'] = $show;  // Pass the show details to the view
        $this->viewData['title'] = 'Unhinged | Edit Show';
        $this->viewData['view'] = 'admin/edit_show';  // Point to the edit view
        echo view('template', $this->viewData);
    }

    public function delete_show($id)
    {
        // Ensure the user is logged in before allowing delete operation
        if (!session()->get('account_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not logged in']);
        }

        // Perform the delete operation
        $deleted = $this->AgendaModel->delete_show($id);

        if ($deleted) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Show deleted successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete show']);
        }
    }


}
