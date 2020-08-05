<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel as Category;
use App\Models\ImageModel as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index() {

        $categoriesList = Category::orderBy('name','asc')->get();
        $categoriesQantity = [];
        foreach ($categoriesList as $category):
            $quantity = Image::where('category', '=', $category->id)->count();
            $categoriesQantity[$category->id] = $quantity;
        endforeach;
        return view('auth.admin.categories.index', ['categories' => $categoriesList, 'quantity' => $categoriesQantity]);
    }

    public function edit(Category $category) {

        return view('auth.admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request) {

        $id = request()->route('category');
        $category = Category::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories,name,'.$id.'|min:2|max:30',
        ]);

        if ($request->get('name') != ""):
            $category->name = $request->get('name');
        endif;
        if ($request->get('isActive') != null):
            $category->isActive = true;
        else:
            $category->isActive = false;
        endif;

        $saved = $category->save();

        if (!($saved)):
            return redirect()->route('gallery')->with('warning', 'Error occured while updating the category');
        endif;

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function delete(Category $category) {

        return view('auth.admin.categories.delete', ['category' => $category]);
    }

    public function deleteConfirmed(Category $category) {

        $category->isActive = false;
        $saved = $category->save();

        if (!($saved)):
            return redirect()->route('gallery')->with('warning', 'Error occured while deleting the category');
        endif;

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }

    public function add() {

        return view('auth.admin.categories.add');
    }

    public function create(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories,name|min:2|max:30',
        ]);

        $category = new Category;
        $category->name = $request->get('name');
        $saved = $category->save();

        if (!($saved)):
            return redirect()->route('gallery')->with('warning', 'Error occured while creating the category');
        endif;

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }
}
