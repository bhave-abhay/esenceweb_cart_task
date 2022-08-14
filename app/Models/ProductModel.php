<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\uuid;
use CodeIgniter\I18n\Time;


class ProductModel extends Model
{
    protected $table                = 'TProduct';
    protected $primaryKey           = 'uidPK';
    protected $useAutoIncrement     = false;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $allowedFields        = ['uidPK', 'uidSalt', 'bStatus', 'sName', 'rPrice'];
    protected $useTimestamps        = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

}
