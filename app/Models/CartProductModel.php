<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\uuid;


class CartProductModel extends Model
{
    protected $table                = 'MTCartProduct';
    protected $primaryKey           = 'uidPK';
    protected $useAutoIncrement     = false;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $allowedFields        = ['uidPK', 'uidSalt', 'bStatus', 'uidCartFK', 'uidProductFK', 'rPrice', 'nQuantity'];
    protected $useTimestamps        = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    public function getCartProductByCart($cartInfo)
    {
        $arrCartProductInfo = $this
            ->where(['uidCartFK' => $cartInfo['uidPK']])
            ->select(
                'TCart.uidPK AS uidCartPK,'.
                'TCart.uidSalt AS uidCartSalt,'.
                'TCart.bStatus AS bCarStatus,'.
                'TProduct.uidPK AS uidProductPK,'.
                'TProduct.uidSalt AS uidProductSalt,'.
                'TProduct.bStatus AS bProductStatus,'.
                'TCart.dtCreated AS dtCartCreated,'.
                'TProduct.sName AS sProductName,'.
                'TProduct.rPrice AS rProductPrice,'.
                'MTCartProduct.bStatus AS bStatus,'.
                'MTCartProduct.nQuantity AS nQuantity'
            )
            ->join('TCart', 'MTCartProduct.uidCartFK=TCart.uidPK')
            ->join('TProduct', 'MTCartProduct.uidProductFK=TProduct.uidPK')
            ->findAll();
        $arrCartProductInfo_active = [];
        foreach ($arrCartProductInfo as $cartProductInfo_candidate) {
            if(($cartProductInfo_candidate['bStatus'] & StatusConstants::ACTIVE) != 0) {
                $arrCartProductInfo_active[] = $cartProductInfo_candidate;
            }
        }
        return $arrCartProductInfo_active;
    }

    public function addCartProduct($cartInfo, $productInfo, $nQuantity)
    {
        if($nQuantity<=0) {
            return null;
        }
        $session = session();
        $sessionInfo = null;
        if($session->has('session')) {
            $sessionInfo = $session->get('session');
            $modelSession = model('App\Models\SessionModel');
            $sessionInfo = $modelSession->getActiveSessionByID($sessionInfo['uidPK']);
        }

        $arrExistingCartProduct = $this->getWhere([
                'uidCartFK' => $cartInfo['uidPK'],
                'uidProductFK' => $productInfo['uidPK']
            ])
            ->getResultArray();
        $existingCartProduct = null;
        foreach ($arrExistingCartProduct as $existingCartProduct_candidate) {
            if(($existingCartProduct_candidate['bStatus']&StatusConstants::ACTIVE) != 0) {
                $existingCartProduct = $existingCartProduct_candidate;
                break;
            }
        }
        if($existingCartProduct) {
            $newCartProductQuantity = $existingCartProduct['nQuantity'] + $nQuantity;
            $this->where(['uidPK' => $existingCartProduct['uidPK']])
            ->set('nQuantity', $newCartProductQuantity)
            ->update();
            $cartProductInfo = $this->find($existingCartProduct['uidPK']);

            return $cartProductInfo;
        }

        $uuid = new Uuid();

        $newCartProductData = [
            'uidPK' => $uuid->v4(true),
            'uidSalt' => $uuid->v4(true),
            'bStatus' => StatusConstants::ACTIVE,
            'uidCartFK' => $cartInfo['uidPK'],
            'uidProductFK' => $productInfo['uidPK'],
            'rPrice' => $productInfo['rPrice'],
            'nQuantity' => $nQuantity,
        ];
        $this->insert($newCartProductData);
        return $newCartProductData;
    }


    public function removeCartProduct($cartInfo, $productInfo, $nQuantity)
    {
        $arrExistingCartProduct = $this->getWhere([
            'uidCartFK' => $cartInfo['uidPK'],
            'uidProductFK' => $productInfo['uidPK']
            ])->getResultArray();

        $existingCartProduct = null;
        foreach ($arrExistingCartProduct as $existingCartProduct_candidate) {
            if(($existingCartProduct_candidate['bStatus']&StatusConstants::ACTIVE) != 0) {
                $existingCartProduct = $existingCartProduct_candidate;
                break;
            }
        }

        if($existingCartProduct) {
            $newCartProductQuantity = $existingCartProduct['nQuantity'] - $nQuantity;
            if($newCartProductQuantity<=0) {
                $newCartProductQuantity = 0;
            }
            if($newCartProductQuantity==0) {

                $this->where(['uidPK' => $existingCartProduct['uidPK']])
                ->set(
                    'bStatus',
                    ($existingCartProduct['bStatus']&(~StatusConstants::ACTIVE))|StatusConstants::DELETED
                )
                ->update();
            }
            $this->where(['uidPK' => $existingCartProduct['uidPK']])
            ->set('nQuantity', $newCartProductQuantity)
            ->update();
            $cartProductInfo = $this->getWhere([
                'uidCartFK' => $cartInfo['uidPK'],
                'uidProductFK' => $productInfo['uidPK']
                ])->getResultArray();

            return $cartProductInfo;
        }
        return NULL;
    }
}
