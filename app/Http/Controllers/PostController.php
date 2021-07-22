<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostImage;
use App\Models\PostCategory;
use Datatables;
use DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Post $post)
    {
        
        $query = $post->join('users', 'posts.id_author', 'users.id')->join('post_categories', 'posts.id', 'post_categories.id_post')
        ->leftjoin('post_images', 'posts.id', 'post_images.id_post');
        if(isset($request->title) && !empty($request->title)){
            $query->where('posts.title', 'like', '%'.$request->title.'%');
        }
        if(isset($request->author) && !empty($request->author)){
            $query->where('users.name', 'like', '%'.$request->author.'%');
        }
        if(isset($request->category) && !empty($request->category)){
            $query->where('post_categories.id_category', $request->category);
        }
        
        $response = $query->select('posts.*', 'users.name as author', 'post_images.url_image','post_categories.id_category as categoria')->paginate(9);

        return Response()->json($response);
    }
    public function list(Post $post)
    {
        return view('posts.list');
    }

    public function listPost(Post $post)
    {
        $response = $post->join('users', 'posts.id_author', 'users.id')->select('posts.*', 'users.name as author', )->get();

        return Datatables::collection($response)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $categories = $category->all();


        return view('posts.create', compact('categories'));
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
            $dataForm['id_author'] = auth()->user()->id;
            $dataForm['status'] = 1;
            $createPost = Post::create($dataForm);
            $nameFile = null;
            // Verifica se informou o arquivo e se é válido
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                
                // Define um aleatório para o arquivo baseado no timestamps atual
                $name = uniqid(date('HisYmd'));
        
                // Recupera a extensão do arquivo
                $extension = $request->image->extension();
        
                // Define finalmente o nome
                $nameFile = "{$name}.{$extension}";
        
                // Faz o upload:
                $upload = $request->image->storeAs('public/posts', $nameFile);
                // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
        
                // Verifica se NÃO deu certo o upload (Redireciona de volta)
                // if ( !$upload )
                //     DB::rollBack();
                //     // return Response()->json(['error', 'Falha ao fazer upload'])->withInput();
                //     return Response()->json(['error', 'Falha ao fazer upload']);

                $imagem_post = new PostImage;
                $imagem_post->id_post = $createPost->id;
                $imagem_post->url_image = "posts/".$nameFile;
                $imagem_post->status =  1;
                $imagem_post->save();

                $imagem_post = new PostCategory;
                $imagem_post->id_post = $createPost->id;
                $imagem_post->id_category =$request->category;
                $imagem_post->save();
            }
            if($createPost){
                DB::commit();
                return Redirect()->back()->with(['error' => false, 'message' => 'Sucesso ao criar um novo post', 'data' => $createPost]);
            }
            DB::rollBack();
            return Redirect()->back()->with(['error' => true, 'message' => 'Falha ao criar um novo post']);

        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();

            return Redirect()->back()->with(['error' => true, 'message' => 'Falha ao criar um novo post']);
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
    
            //Recupera os dados do formulário
            $dataForm = $request->all();
            
            $updatePost = Post::update($dataForm);

            // Verifica se informou o arquivo e se é válido
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
    
                // Define um aleatório para o arquivo baseado no timestamps atual
                $name = uniqid(date('HisYmd'));
        
                // Recupera a extensão do arquivo
                $extension = $request->image->extension();
        
                // Define finalmente o nome
                $nameFile = "{$name}.{$extension}";
        
                // Faz o upload:
                $upload = $request->image->storeAs('posts', $nameFile);
                // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
        
                // Verifica se NÃO deu certo o upload (Redireciona de volta)
                if ( !$upload )
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }

            if($updatePost){
                DB::commit();
                return Response()->json(['error' => false, 'message' => 'Sucesso ao atualizar o post', 'data' => $updatePost]);
            }
            DB::rollBack();
            return Response()->json(['error' => true, 'message' => 'Falha ao atualizar o post']);

        } catch (\Throwable $th) {
            DB::rollBack();

            return Response()->json(['error' => true, 'message' => 'Falha ao atualizar o post']);
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
            $post = Post::find($id);
            if($post->id_author == Auth()->user()->id){
                DB::beginTransaction();
    
                $destroyPost = Post::destroy($id);
    
                if($destroyPost){
                    DB::commit();
                    return redirect()->back()->with(['error' => false, 'message' => 'Sucesso ao deletar o post']);
                }
                DB::rollBack();
                return redirect()->back()->with(['error' => true, 'message' => 'Falha ao deletar o post selecionado']);
            }
            return redirect()->back()->with(['error' => true, 'message' => 'Falha ao deletar o post selecionado']);

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with(['error' => true, 'message' => 'Falha ao deletar o post selecionado']);
        } 
        return redirect()->back()->with(['error' => true, 'message' => 'Falha ao deletar o post selecionado']);
    }
}
