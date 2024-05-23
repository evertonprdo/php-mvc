<?php 

namespace sistema\Suporte;

use Twig\Lexer;
use sistema\Nucleo\Helpers;

class Template 
{
    private \Twig\Environment $twig;

    public function __construct(string $diretorio) 
    {
        #Carregando o Twig Template
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

        #Setando as Funções no Twig
        $lexer = new Lexer($this->twig, array(
            $this->helpers()
        ));
        $this->twig->setLexer($lexer);
    }

    public function renderizar(string $view, array $dados): string
    {
        return $this->twig->render($view, $dados);
    }
    
    private function helpers(): void
    {
        #Array de funções Twig Template
        array(
            
            #Função url
            $this->twig->addFunction(new \Twig\TwigFunction('url', function(string $url = null)
                {
                    return Helpers::url($url);
                })
            ),

            #Função saudacao
            $this->twig->addFunction(new \Twig\TwigFunction('saudacao', function()
                {
                    return Helpers::saudacao();
                })
            ),

            #Função getOnlyNumbers
            $this->twig->addFunction(new \Twig\TwigFunction('getOnlyNumbers', function(string $num)
                {
                    return Helpers::getOnlyNumbers($num);
                })
            ),

            #Função validarCpf
            $this->twig->addFunction(new \Twig\TwigFunction('validarCpf', function(string $cpf)
                {
                    return Helpers::getOnlyNumbers($cpf);
                })
            ),

            #Função slug
            $this->twig->addFunction(new \Twig\TwigFunction('slug', function(string $string)
                {
                    return Helpers::getOnlyNumbers($string);
                })
            ),

            #Função dataAtual
            $this->twig->addFunction(new \Twig\TwigFunction('dataAtual', function()
                {
                    return Helpers::dataAtual();
                })
            ),

            #Função localhost
            $this->twig->addFunction(new \Twig\TwigFunction('localhost', function()
                {
                    return Helpers::localhost();
                })
            ),

            #Função validarUrl
            $this->twig->addFunction(new \Twig\TwigFunction('validarUrl', function(string $url)
                {
                    return Helpers::validarUrl($url);
                })
            ),

            #Função validarUrlComFiltro
            $this->twig->addFunction(new \Twig\TwigFunction('validarUrlComFiltro', function(string $url)
                {
                    return Helpers::validarUrlComFiltro($url);
                })
            ),

            #Função validarEmail
            $this->twig->addFunction(new \Twig\TwigFunction('validarEmail', function(string $email)
                {
                    return Helpers::validarEmail($email);
                })
            ),

            #Função contarTempo
            $this->twig->addFunction(new \Twig\TwigFunction('contarTempo', function(string $data)
                {
                    return Helpers::contarTempo($data);
                })
            ),

            #Função formatarValor
            $this->twig->addFunction(new \Twig\TwigFunction('formatarValor', function(float $valor = null)
                {
                    return Helpers::formatarValor($valor);
                })
            ),

            #Função formatarNumero
            $this->twig->addFunction(new \Twig\TwigFunction('formatarNumero', function(string $num = null)
                {
                    return Helpers::formatarNumero($num);
                })
            ),

            #Função resumirTexto
            $this->twig->addFunction(new \Twig\TwigFunction('resumirTexto', function(string $texto, int $limite, string $continue = '...')
                {
                    return Helpers::resumirTexto($texto, $limite, $continue);
                })
            ),

            #Função textConcate
            $this->twig->addFunction(new \Twig\TwigFunction('textConcate', function(string $texto = 'Texto não fornecido')
                {
                    return Helpers::textConcate($texto);
                })
            )
        );
    }
}
?>