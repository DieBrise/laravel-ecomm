<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
use App\Models\Product;

use DB;

use Response;

class ProductController extends BaseController
{
    protected $brandRepository;

    protected $categoryRepository;

    protected $productRepository;

    public function __construct(
        BrandContract $brandRepository,
        CategoryContract $categoryRepository,
        ProductContract $productRepository
    )
    {
		$this->middleware('auth:admin');
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
	}
	
	public function index()
	{
		$products = $this->productRepository->listProducts();

		$this->setPageTitle('Products', 'Products List');
		return view('admin.products.index', compact('products'));
	}

	public function create()
	{
		$brands = $this->brandRepository->listBrands('name', 'asc');
		$categories = $this->categoryRepository->listCategories('name', 'asc');

		$this->setPageTitle('Products', 'Create Product');
		return view('admin.products.create', compact('categories', 'brands'));
	}

	public function store(Request $request)
	{
		$params = $request->except('_token');

		$product = $this->productRepository->createProduct($params);

		if (!$product) {
			return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
		}
		$route = 'admin.products.edit';
		$attr = ['id' => $product->id];
		return $this->responseRedirect($route, 'Product added successfully' ,'success',false, false, $attr);
	}

	public function edit($id)
	{
		$product = $this->productRepository->findProductById($id);
		$brands = $this->brandRepository->listBrands('name', 'asc');
		$categories = $this->categoryRepository->listCategories('name', 'asc');

		$this->setPageTitle('Products', 'Edit Product');
		return view('admin.products.edit', compact('categories', 'brands', 'product'));
	}

	public function update(Request $request)
	{
		$params = $request->except('_token');

		$product = $this->productRepository->updateProduct($params);

		if (!$product) {
			return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
		}
		return $this->responseRedirect('admin.products.index', 'Product updated successfully' ,'success',false, false);
	}

	public function delete($id)
	{
		$product = Product::find($id);
		$attrs = $product->attributes();
		$images = $product->images();

		DB::table('product_categories')->where('product_id', '=', $id)->delete();

		$product->delete();
		return $this->responseRedirect('admin.products.index', 'Product deleted successfully' ,'success',false, false);
	}

	public function featured($id)
	{
		$product = Product::find($id);
		
		if ($product->featured) {
			$product->featured = 0;
			$product->save();
			return $this->responseRedirectBack('Product is no longer featured.', 'success', true, true);
		} else {
			$product->featured = 1;
			$product->save();
			return $this->responseRedirectBack('Product set as featured.', 'success', true, true);
		}
	}
}
