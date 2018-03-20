<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use \Firebase\JWT\JWT;


class TarefaController extends Controller {
    
    /** Lista todas tarefas do usuário */
    public function listar(Request $request) {
        $tarefas = $this->getTarefas($request);    
        return response()->json($tarefas, 200);
    }

    /** Cadastra uma nova tarefa */
    public function cadastrar(Request $request) {
        $dados = $request->only(['titulo', 'data']);
        $dados['usuario_id'] = $this->getId($request);
        Tarefa::create($dados);

        $tarefas = $this->getTarefas($request);    
        return response()->json($tarefas, 201);
    }

    /** Atualiza uma tarefa */
    public function atualizar(Request $request, $id) {
        Tarefa::where('id', $id)->where('usuario_id', $this->getId($request))->update($request->only(['titulo', 'data']));

        $tarefas = $this->getTarefas($request);    
        return response()->json($tarefas, 200);
    }

    /** Deleta uma tarefa */
    public function excluir(Request $request, $id) {
        $tarefa = Tarefa::where('id', $id)->where('usuario_id', $this->getId($request))->firstOrFail();
        $tarefa->delete();

        $tarefas = $this->getTarefas($request);    
        return response()->json($tarefas, 200);
    }

    /** Retorna as tarefas do usuário que solicitou a requisição */
    private function getTarefas($request) {
        return Tarefa::where('usuario_id', $this->getId($request))->orderBy('data')->get()->toArray();
    }

    /** Busca o ID do usuário que solicitou a requisição */
    private function getId($request): ?int {
        $dados = (array)JWT::decode($request->header('Authorization'), config('jwt.key'), ['HS256']);
        return $dados['id'];
    }
}
