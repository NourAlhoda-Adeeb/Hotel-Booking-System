<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $allowedFields = [
    'category',
    'cuisine',
    'dish_name',
    'image'
];

}
