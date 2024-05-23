<?php 

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

class CategoriaModelo {
    public function buscaAll() : array
    {
        $stmt = Conexao::getInstancia()->query("SELECT * FROM categorias ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM categorias WHERE id = {$id}";
        
        $stmt = Conexao::getInstancia()->query($query);
        return $stmt->fetch();
    }

    public function posts(int $id) : array
    {
        $stmt = Conexao::getInstancia()->query("SELECT * FROM roupas WHERE categoria_id = {$id} ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}