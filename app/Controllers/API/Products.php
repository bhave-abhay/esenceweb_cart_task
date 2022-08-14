<?php
namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\ProductModel;
use App\Models\StatusConstants;

use App\Libraries\uuid;

class Products extends ResourceController
{
	use ResponseTrait;
	// get all product
	public function index()
	{
		$modelProduct = model('App\Models\ProductModel');
		$arrProductInfo = $modelProduct->findAll();

		// ->where('bStatus & ' . StatusConstants::ACTIVE . ' != 0')
		// ->get();
		$respData = [
			'status' => 200,
			'error'    => null,
			'message' => 'SUCCESS',
			'data' => [
				'arrProductInfo' => []
			]
		];

		foreach ($arrProductInfo as $productInfo ) {
			if(($productInfo['bStatus'] & StatusConstants::ACTIVE)!=0) {
				$respData['data']['arrProductInfo'][] = $productInfo;
			}
		}
		return $this->respond($respData);
	}

	// get single product
	public function show($id = null)
	{
		$modelProduct = model('App\Models\ProductModel');
		$productInfo = $modelProduct->getWhere(['uidPK' => $id])->getResult();
		if($productInfo && (($productInfo['bStatus'] & StatusConstants::ACTIVE) != 0)) {
			$respData = [
				'status' => 200,
				'error'    => null,
				'message' => 'SUCCESS',
				'data' => [
					'productInfo' => $productInfo
				]
			];
			return $this->respond($data);
		}
		return $this->failNotFound('No Data Found with id '.$id);
	}

	// create a product
	public function create()
	{
		$modelProduct = model('App\Models\ProductModel');
		$arrProductInfo = $modelProduct->getWhere(
			['sName' => $this->request->getVar('sName')]
		)->getResult();
		$productInfo = null;
		foreach ($arrProductInfo as $info) {
			if(($info['bStatus'] & StatusConstants::ACTIVE) != 0) {
				$productInfo = $info;
				break;
			}
		}
		if($productInfo) {
			return $this->failResourceExists(
				'Item with same name ('
				. $this->request->getVar('sName')
				. ') already exists'
			);
		}

		$uuid = new Uuid();

		$productInfo = [
			'uidPK' => $uuid->v4(true),
			'uidSalt' => $uuid->v4(true),
			'bStatus' => StatusConstants::ACTIVE,
			'sName' => $this->request->getVar('sName'),
			'rPrice' => $this->request->getVar('rPrice'),
		];
		$modelProduct->insert($productInfo);
		$response = [
			'status'   => 201,
			'error'    => null,
			'message' => 'SUCCESS',
			'data' => [
				'productInfo' => $productInfo
			]
		];
		return $this->respondCreated($response);
	}

	// update product
	public function update($id = null)
	{
		$modelProduct = model('App\Models\ProductModel');
		$productInfo = $modelProduct->find($id);
		if($productInfo && (($productInfo & StatusConstants::ACTIVE) != 0)) {

			$sName = $this->request->getVar('sName')??$productInfo['sName'];
			$rPrice = $this->request->getVar('rPrice')??$productInfo['rPrice'];

			$productInfo = [
				'sName' => $sName,
				'rPrice' => $rPrice,
			];
			$modelProduct
			->where(['uidPK' => $id])
			->set($productInfo)
			->update();
			$productInfo = $modelProduct->find($id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'message' => 'SUCCESS',
				'data' => [
					'productInfo' => $productInfo
				]
			];
			return $this->respond($response);
		}
		return $this->failNotFound('No Data Found with id '.$id);
	}

	// delete product
	public function delete($id = null)
	{
		$modelProduct = model('App\Models\ProductModel');
		$productInfo = $modelProduct->find($id);
		if($productInfo && ($productInfo['bStatus'] & (StatusConstants::ACTIVE))) {
			$modelProduct
			->where(['uidPK' => $id])
			->set([
				'bStatus' =>
				($productInfo & (~StatusConstants::ACTIVE))|StatusConstants::DELETED
			])
			->update();
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => 'Data Deleted'
				]
			];
			return $this->respondDeleted($response);
		}
		return $this->failNotFound('No Data Found with id '.$id);
	}
}

?>
