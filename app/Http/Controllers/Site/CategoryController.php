<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\CategoryContract;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function show($slug)
    {
		$category = $this->categoryRepository->findBySlug($slug);
		$featured = Product::where('featured', 1)->get();

		if(empty($category)){
			return view('site.pages.404');
		}
		
        return view('site.pages.category', compact('category', 'featured'));
    }
}