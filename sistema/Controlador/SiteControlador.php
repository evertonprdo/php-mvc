<?php 
namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\PostModelo;
use sistema\Nucleo\Helpers;
use sistema\Modelo\CategoriaModelo;

class SiteControlador extends Controlador
{
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }   

    public function index(): void
    {
        $posts = (new PostModelo())->buscaAll();
        
        echo $this->template->renderizar('index.html', [
            'posts' => $posts,
            'categorias' => $this->categorias()
        ]);
    }

    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        
        if (isset($busca)) {
            $posts = (new PostModelo())->pesquisa($busca);
            
            foreach ($posts as $post) {
                echo "<li class='list-group-item fw-bold'><a href=" . Helpers::url('post/') . $post->id .">$post->titulo</a></li>";
            }
        }
    }

    public function post(int $id): void
    {
        $post = (new PostModelo())->buscaPorId($id);  
        $post ?: Helpers::redirecionar('404');

        echo $this->template->renderizar('post.html', [
            'post' => $post,
            'categorias' => $this->categorias()
        ]);
    }

    public function categorias(): Array
    {
        return (new CategoriaModelo())->buscaAll();
    }

    public function categoria(int $id): void
    {
        $post = (new CategoriaModelo())->posts($id);
        $post ?: Helpers::redirecionar('404');

        echo $this->template->renderizar('categoria.html', [
            'posts' => $post,
            'categorias' => $this->categorias()
        ]);
    }

    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'Página Sobre',
            'subtitulo' => 'Teste da Página Sobre'
        ]);
    }

    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'titulo' => 'Página Não Encontrada'
        ]);
    }
}

?>