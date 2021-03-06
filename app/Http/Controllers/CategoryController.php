<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $category = new Category;
            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->url = $data['url'];
            $category->description = $data['category_descr'];
            $category->save();
            return redirect('/admin/view-category')->with('flash_message_success', 'Category Added Successfully');
        }
        $levels = Category::where(['parent_id' => 0])->get();
        return view('admin.Category.add-category')->with(compact('levels'));
    }

    public function viewCategories()
    {
        $categories = Category::get();
        return view('admin.category.view_category')->with(compact('categories'));
    }

    public function editCategory(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Category::where(['id' => $id])->update(['name' => $data['category_name'],
                'parent_id' => $data['parent_id'], 'description' => $data['category_description'],
                'url' => $data['category_url']]);
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category update Successfully');

        }
        $levels = Category::where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['id' => $id])->first();
        return view('admin.category.edit_Category')->with(compact('levels', 'categoryDetails'));
    }

    public function deleteCategory($id = null)
    {
        Category::where(['id' => $id])->delete();
        Alert::Success('Deleted', 'Success Message');
        return redirect()->back();
    }

    function updateStatus(Request $request, $id = null)
    {
        $data = $request->all();
        Category::where('id', $data['id'])->update(['status' => $data['status']]);
    }
}
