<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function redirect;

class CategoriesController extends Controller
{
    /**
     * Акшен главная страница категорий
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index',[
            'categories' => $categories
        ]);
    }

    /**
     * Выводит форму создание категорий
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Метод создает категорию
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request,[
             'title' => 'required'
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    /**
     * Выводит форму редактирования категорий
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit',[
            'category' => $category
        ]);
    }

    /**
     * Обновляет категорию
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required'
        ]);

        $category = Category::find($id);
        $category->update($request->all());

        return redirect()->route('categories.index');
    }

    /**
     * Удалить категорию
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('categories.index');
    }

}
