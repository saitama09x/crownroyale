<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------


    public $valid_new_client = [        
        'clientname' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Client Name is required'
            ],
        ],
        'clientaddress' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Address is required'
            ],
        ],
        'contactno' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Contact No. is required'
            ],
        ],
        'email' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Email is required'
            ],
        ]       
    ];

    public $valid_new_project = [        
        'projname' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Project Name is required'
            ],
        ],
        'projdesc' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Description is required'
            ],
        ],
        'projaddress' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Address is required'
            ],
        ],
        'client_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select your client'
            ],
        ],
        'startdate' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select your Start Date'
            ],
        ],
        'enddate' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please select your End Date'
            ],
        ],
        'projcost' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please input your project costs'
            ],
        ]
    ];

    public $valid_add_user = [        
        'fname' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'lname' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'username' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'password' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'user_type' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
    ];

     public $valid_new_task = [        
        'project_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'descriptions' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'user_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ],
        'due_date' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ]    
    ];


    public $valid_add_comment = [        
        'comment' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'required'
            ],
        ]
    ];
}
