<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {

    public function add_category(Request $request) {

    	if($request->method() == 'POST') {
            $valid = $request->validate([
                'name' => ['required', 'string', 'unique:product_category'],
            ]);

            $product = ProductCategory::create($valid);
            return $this->success($product);
        } else {
            return $this->failed("invalid request");
        }

    }

    public function get_categories(Request $request) {
        return $this->success(ProductCategory::paginate(10));
    }

    public function delete_category(Request $request) {
        if($request->method() == 'POST') {
            $valid = $request->validate([
                'id' => ['required']
            ]);

            try {
                $category = ProductCategory::findOrFail($valid['id']);
                $category->delete();
                return $this->success("Deleted");

            }catch(Exception $e) {
                return $this->failed("Unable to delete");
            }
        } else {
            return $this->failed("invalid request");
        }
    }
}
