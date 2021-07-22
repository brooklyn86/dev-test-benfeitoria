<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        if(isset($request->title) && !empty($request->title)){
            $response = Category::where('title', 'like', '%'.$request->title.'%')->paginate(10);
            return Response()->json($response);
        }

        $response = $category->paginate(10);
        return Response()->json($response);
    }

    public function list(Category $category)
    {
        return view('category.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            //Recupera os dados do formulário
            $dataForm = $request->all();
            $category = new Category;
            $category->title = $dataForm['title'];
            $category->status = 1;
            $newCategory = $category->save();

            if($newCategory){
                DB::commit();
                return  Redirect()->back()->with('success', 'Sucesso ao cadastrar a categoria');
            }
            DB::rollBack();
            return  Redirect()->back()->with('error','Falha ao criar uma nova categoria');

        } catch (\Throwable $th) {
            DB::rollBack();

            return  Redirect()->back()->with('error', 'Falha ao criar uma nova categoria');
        }
       
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $dataForm = $request->all();

            $updateCategory = Category::update($dataForm);

            if($updateCategory){
                DB::commit();
                return Response()->json(['error' => false, 'message' => 'Sucesso ao deletar a categoria', 'data' => $updateCategory]);
            }
            DB::rollBack();
            return Response()->json(['error' => true, 'message' => 'Falha ao deletar uma nova categoria']);

        } catch (\Throwable $th) {
            DB::rollBack();

            return Response()->json(['error' => true, 'message' => 'Falha ao deletar uma nova categoria']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $destroyCategory = Category::destroy($id);

            if($destroyCategory){
                DB::commit();
               return  Redirect()->back()->with('success','Categoria removida com sucesso');
            }
            DB::rollBack();
            return  Redirect()->back()->with('error','Falha ao criar uma nova categoria');

        } catch (\Throwable $th) {
            DB::rollBack();

            return  Redirect()->back()->with('error','Falha ao criar uma nova categoria');
        }
    }
}
