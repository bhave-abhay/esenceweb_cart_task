<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\uuid;
use CodeIgniter\I18n\Time;


class CartModel extends Model
{
    protected $table                = 'TCart';
    protected $primaryKey           = 'uidPK';
    protected $useAutoIncrement     = false;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $allowedFields        = ['uidPK', 'uidSalt', 'bStatus', 'uidSessionFK', 'dtCreated'];
    protected $useTimestamps        = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    public function createCart($sessionInfo)
    {
        $uuid = new Uuid();

        $newCartData = [
            'uidPK' => $uuid->v4(true),
            'uidSalt' => $uuid->v4(true),
            'bStatus' => StatusConstants::ACTIVE,
            'uidSessionFK' => $sessionInfo['uidPK'],
            'dtCreated' => gmdate(DATE_RFC3339),
        ];

        $this->insert($newCartData);
        return $newCartData;
    }

    public function getCartBySession($sessionInfo)
    {
        $arrCartInfo = $this->getWhere(['uidSessionFK' => $sessionInfo['uidPK']])->getResultArray();
        $cartInfo = null;
        foreach ($arrCartInfo as $cartInfo_candidate) {
            if(($cartInfo_candidate['bStatus'] & StatusConstants::ACTIVE) != 0) {
                $cartInfo = $cartInfo_candidate;
            }
        }
        return $cartInfo;
    }
}
