<?php namespace App\Controllers\Admin;

use \App\Models\CategoryModel;

class CategoryController extends \App\Controllers\BaseController
{
    protected $categoryModel = null;
	public function __construct()
	{
		$this->categoryModel = new CategoryModel();
	}

	//--------------------------------------------------------------------

	public function index()
	{
        $viewData['categories'] = $this->categoryModel->findAll();
		return view('admin/category/index', $viewData);
	}

	//--------------------------------------------------------------------

	public function new()
	{
		return view('admin/category/new');
	}

	//--------------------------------------------------------------------

	public function edit($id = null)
	{
		
	}

	//--------------------------------------------------------------------

	public function show($id = null)
	{
        $viewData['category'] = $this->categoryModel->find($id);
        return view('/admin/category/detail', $viewData);
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$data = [
            'name'          => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
        ];

        $result = $this->categoryModel->insert($data);

        if (! $result)
        {
            $errors = $this->categoryModel->errors();
            var_dump($errors);die();
            return redirect()->to('/admin/categories/new');
        }

        return redirect()->to('/admin/categories');
	}

	//--------------------------------------------------------------------

	public function delete($id = null)
	{
		$result = $this->categoryModel->delete($id);

		if (! $result)
		{
			$viewData['errors'] = $this->categoryModel->errors();
			return redirect()->to("/admin/categories/$id", $viewData);
		}

		return redirect()->to('/admin/categories');
	}

	//--------------------------------------------------------------------

	public function update($id = null)
	{
		$team = $this->categoryModel->find($id);
		$data = [
			'name'          => $this->request->getPost('name'),
			'description'   => $this->request->getPost('description'),
		];

		$result = $this->categoryModel->update($id, $data);
		if (! $result)
		{
			$viewData['errors'] = $this->categoryModel->errors();
			return redirect()->to("/admin/categories/$id", $viewData);
		}
		return redirect()->to("/admin/categories/$id");
	}
}
