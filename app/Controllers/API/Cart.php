<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\StatusConstants;

class Cart extends BaseController
{

    use ResponseTrait;

    public function getMyCart()
    {
        $session = session();
        if($session->has('session')) {
            $sessionInfo = $session->get('session');
            $modelSession = model('App\Models\SessionModel');
            $sessionInfo = $modelSession->find($sessionInfo['uidPK']);
            if($modelSession->isSessionActive($sessionInfo)) {
                $modelCart = model('App\Models\CartModel');
                $myCart = $modelCart->getCartBySession($sessionInfo);
                if(!$myCart) {
                    $myCart = $modelCart->createCart($sessionInfo);
                }
                if($myCart) {
                    $modelCartProduct = model('App\Models\CartProductModel');
                    $arrCartProductInfo = $modelCartProduct->getCartProductByCart($myCart);
                    $responseData = [
                        'status'   => 200,
                        'error'    => null,
                        'message' => 'SUCCESS',
                        'data' => [
                            'cartInfo'=> $myCart,
                            'arrCartProductInfo' => $arrCartProductInfo
                        ]
                    ];
                    return $this->respond($responseData);
                }
                //Failed to create cart
                return $this->fail('Failed to create cart');
            }
            //Dead session
            return $this->failUnauthorized('Not logged in');
        }
        //No session
        return $this->failUnauthorized('Not logged in');
    }

    public function addProductToCart()
    {
        $session = session();
        if($session->has('session')) {
            $sessionInfo = $session->get('session');
            $modelSession = model('App\Models\SessionModel');
            $sessionInfo = $modelSession->find($sessionInfo['uidPK']);
            if($modelSession->isSessionActive($sessionInfo)) {
                $uidProductFK = $this->request->getPost('uidProductFK');
                $nQuantity = $this->request->getPost('nQuantity');
                if($uidProductFK) {
                    $modelProduct = model('App\Models\ProductModel');
                    $productInfo = $modelProduct->find($uidProductFK);
                    if($productInfo) {
                        if(($productInfo['bStatus'] & StatusConstants::ACTIVE)!=0) {
                            $modelCart = model('App\Models\CartModel');
                            $cartInfo = $modelCart->getCartBySession($sessionInfo);
                            if(!$cartInfo) {
                                $cartInfo = $modelCart->createCart($sessionInfo);
                            }

                            if($cartInfo) {
                                $modelCartProduct = model('App\Models\CartProductModel');
                                $cartProductInfo = $modelCartProduct->addCartProduct($cartInfo, $productInfo, $nQuantity);
                                if($cartProductInfo) {
                                    //SUCCESS
                                    $responseData = [
                                        'status'   => 201,
                                        'error'    => null,
                                        'message' => 'SUCCESS',
                                        'data' => [
                                            'cartProductInfo' => $cartProductInfo
                                        ]
                                    ];
                                    return $this->respond($responseData);
                                }
                                //Failed to add product to cart
                                return $this->fail('Failed to add');
                            }
                            //Failed to create cart
                            return $this->fail('Failed to add');
                        }
                        //Dead product
                        return $this->fail('Failed to add');
                    }
                    //No product
                    return $this->fail('Failed to add');
                }
                //No product ID
                return $this->failValidationError('No product specified');
            }
            //Dead session
            return $this->failUnauthorized('Not logged in');
        }
        //No session
        return $this->failUnauthorized('Not logged in');
    }


    public function removeProductFromCart()
    {
        $session = session();
        if($session->has('session')) {
            $sessionInfo = $session->get('session');

            $modelSession = model('App\Models\SessionModel');
            $sessionInfo = $modelSession->find($sessionInfo['uidPK']);
            if($modelSession->isSessionActive($sessionInfo)) {
                $uidProductFK = $this->request->getPost('uidProductFK');
                $nQuantity = $this->request->getPost('nQuantity');
                if($uidProductFK) {
                    $modelProduct = model('App\Models\ProductModel');
                    $productInfo = $modelProduct->find($uidProductFK);
                    if($productInfo) {
                        if(($productInfo['bStatus'] & StatusConstants::ACTIVE)!=0) {
                            $modelCart = model('App\Models\CartModel');
                            $arrCartInfo = $modelCart
                            ->getWhere(['uidSessionFK' => $sessionInfo['uidPK']])
                            ->getResultArray();
                            $cartInfo = null;
                            foreach ($arrCartInfo as $cartInfo_candidate) {
                                if(($cartInfo_candidate['bStatus'] & StatusConstants::ACTIVE)!=0) {
                                    $cartInfo = $cartInfo_candidate;
                                    break;
                                }
                            }
                            if(!$cartInfo) {
                                $cartInfo = $modelCart->createCart($sessionInfo);
                            }

                            if($cartInfo) {
                                $modelCartProduct = model('App\Models\CartProductModel');
                                $cartProductInfo = $modelCartProduct->removeCartProduct($cartInfo, $productInfo, $nQuantity);
                                if($cartProductInfo) {
                                    //SUCCESS
                                    $responseData = [
                                        'status'   => 201,
                                        'error'    => null,
                                        'message' => 'SUCCESS',
                                        'data' => [
                                            'cartProductInfo' => $cartProductInfo
                                        ]
                                    ];
                                    return $this->respond($responseData);
                                }
                                //Failed to add product to cart
                                return $this->fail('Failed to add');
                            }
                            //Failed to create cart
                            return $this->fail('Failed to add');
                        }
                        //Dead product
                        return $this->fail('Failed to add');
                    }
                    //No product
                    return $this->fail('Failed to add');
                }
                //No product ID
                return $this->failValidationError('No product specified');
            }
            //Dead session
            return $this->failUnauthorized('Not logged in');
        }
        //No session
        return $this->failUnauthorized('Not logged in');
    }
}
