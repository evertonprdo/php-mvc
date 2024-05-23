<?php 

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

class PostModelo
{
    public function buscaAll() : array
    {
        $stmt = Conexao::getInstancia()->query("SELECT * FROM roupas ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM roupas WHERE id = {$id}";
        
        $stmt = Conexao::getInstancia()->query($query);
        return $stmt->fetch();
    }

    public function buscaCategorias(int $id): bool|object
    {
        $query = "SELECT * FROM categorias WHERE id = {$id}";
        
        $stmt = Conexao::getInstancia()->query($query);
        return $stmt->fetch();
    }

    public function pesquisa(string $busca) : array
    {
        $stmt = Conexao::getInstancia()->query("SELECT * FROM roupas WHERE titulo LIKE '%{$busca}%'");
        return $stmt->fetchAll();
    }
}