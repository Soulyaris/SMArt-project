<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryModelController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        if (Gate::allows('admin-user', Auth::user())):
            return true;
        else:
            return redirect()->route('home');
        endif;
    }

    public function checkPrivilegies() {
        if (Gate::allows('admin-user', Auth::user())):
            return true;
        else:
            return false;
        endif;
    }

    public function index() {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        $categoriesList = DB::table('categories')->orderBy('name','asc')->get();
        return view('auth.admin.categories.index', ['categories' => $categoriesList]);
    }

    public function edit(CategoryModel $category) {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        return view('auth.admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request) {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        $id = request()->route('category');
        $category = CategoryModel::find($id);
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,'.$id.'|min:2|max:30',
        ]);

        if ($request->get('name') != ""):
            $category->name = $request->get('name');
        endif;
        if ($request->get('isActive') != null):
            $category->isActive = true;
        else:
            $category->isActive = false;
        endif;
        $category->save();
        return redirect()->route('admin.categories.index');
    }

    public function delete(CategoryModel $category) {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        return view('auth.admin.categories.delete', ['category' => $category]);
    }

    public function deleteConfirmed(CategoryModel $category) {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        $category->update(array('isActive' => false));
        return redirect()->route('admin.categories.index');
    }

    public function add() {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        return view('auth.admin.categories.add');
    }

    public function create(Request $request) {
        if (!($this->checkPrivilegies())):
            return redirect()->route('home');
        endif;

        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name|min:2|max:30',
        ]);

        $category = new CategoryModel;
        $category->name = $request->get('name');
        $category->save();

        return redirect()->route('admin.categories.index');
    }
}
