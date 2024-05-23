<?php 

namespace sistema\Nucleo;

use Exception;

class Helpers {

    public static function redirecionar(string $url = null): void
    {
        header('HTTP/1.1 302 Found');

        $local = ($url ? self::url($url) : self::url());

        header("Location: {$local}");
        exit();
    }

    public static function getOnlyNumbers(string $num) : string {
        return preg_replace('/[^0-9]/','',$num);
    }

    public static function validarCpf(string $cpf) : bool {
        
        $cpf = self::getOnlyNumbers($cpf);
        $soma_um = 0;
        $soma_dois = 0;

        if (mb_strlen($cpf) != 11 or preg_match('/(\d)\1{10}/', $cpf)) {        
            throw new Exception('O CPF precisa ter 11 digitos');
        }
        for ($i=0; $i < 11; $i++) { 
            
            $soma_um += $cpf[$i] * ($i+1);
            $soma_dois += $cpf[$i] * $i;
            
            if ($i == 8) {
                $digito_um = $soma_um % 11 == 10 ? 0 : $soma_um % 11;
                
                if ($digito_um != $cpf[$i+1]) {
                    throw new Exception('CPF Inválido');
                }
            
            } elseif ($i == 9) {
                $digito_dois = $soma_dois % 11 == 10 ? 0 : $soma_dois % 11;

                if ($digito_dois != $cpf[$i+1]) {
                    throw new Exception("CPF Inválido");
                }
            }
        }
        
        return true;
    }

    public static function slug(string $string) : string {
        $string = trim($string); 
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        $slug = strtolower($string);   
        $slug = preg_replace('/[^a-zA-Z0-9\s]/', '', $slug);
        
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return $slug;
    }


    public static function dataAtual() : string {
        $diaMes = date('d');
        $diaSemana = date('w');
        $mes = date('n') - 1;
        $ano = date('Y');

        $nome_dias_da_semana = [
            'domingo',
            'segunda-feira',
            'terça-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta,feira',
            'sabádo'
        ];

        $nome_meses = [
            'janeiro',
            'fevereiro',
            'março',
            'abril',
            'maio',
            'junho',
            'julho',
            'agosto',
            'setembro',
            'outubro',
            'novembro',
            'dezembro'
        ];
        
        $dataFormatada = "$nome_dias_da_semana[$diaSemana], $diaMes de $nome_meses[$mes]";
        return  $dataFormatada;
    }

    /**
     * Construtor de url
     * @param string $url endpoint
     * @return string $url completa
     */
    public static function url(string $url = null): string {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($servidor == 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);

        if (str_starts_with($url, '/')) {
            return $ambiente . $url;
        }
        return $ambiente . '/' . $url;
    }

    public static function localhost() : bool {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        
        if($servidor == 'localhost') {
            return true;
        }
        return false;
    }

    public static function validarUrl(string $url) : bool {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function validarUrlComFiltro(string $url) : bool 
    {
        if(mb_strlen($url) < 10) {
            return false;
        }
        
        if (!str_contains($url, '.')) {
            return false;
        }
        
        if (str_contains($url, 'http://') || str_contains($url, 'https://')) {
            return true;
        }
        
        return false;
    }

    public static function validarEmail(string $email) : bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Conta o tempo decorrido de uma data
     * @param string $data A data de comparação - a de agora
     * @return string O tempo decorrido
     */

    public static function contarTempo (string $data) : string {
        $agora = strtotime(date('Y-m-d H:i:s'));
        $tempo = strtotime($data);
        $diferenca = $agora - $tempo;

        if ($diferenca < 60) {
            return 'Agora';
        
        } elseif ($diferenca < 3600 ) {
            $calc_time = round($diferenca / 60);
            return $calc_time == 1 ? 'Há 1 minuto' : "Há $calc_time minutos";
        
        } elseif ($diferenca < 86400 ) {
            $calc_time = round($diferenca / 3600);
            return $calc_time == 1 ? 'Há 1 hora' : "Há $calc_time horas";
        
        } elseif ($diferenca < 604800 ) {
            $calc_time = round($diferenca / 86400);
            return $calc_time == 1 ? 'Ontem' : "Há $calc_time dias";
        
        } elseif ($diferenca < 2419200 ) {
            $calc_time = round($diferenca / 604800);
            return $calc_time == 1 ? 'Há 1 semana' : "Há $calc_time semanas";
        
        } elseif ($diferenca < 29030400 ) {
            $calc_time = round($diferenca / 2419200);
            return $calc_time == 1 ? 'Há 1 mês' : "Há $calc_time meses";
        
        } else {
            $calc_time = round($diferenca / 29030400);
            return $calc_time == 1 ? 'Há 1 ano' : "Há $calc_time anos";
        }
    }

    public static function formatarValor(float $valor = null) : string {
            return 'R$ ' . number_format(($valor ?? 0) , 2, ',' , '.');
    }

    public static function formatarNumero(string $num = null) : string {
        return number_format($num ?: 0, 0, '.', '.');
    }

    public static function saudacao(): string
    {
        $hora = intval(date('H'));

        $saudacao = match (true) {
            ($hora >= 0 && $hora <= 5) => 'Boa madrugada',
            ($hora >= 6 && $hora <= 12) => 'Bom dia',
            ($hora >= 13 && $hora <= 18) => 'Boa tarde',
            default => 'Boa noite'
        };

        return $saudacao;
    }

    /**
     * Resume o texto
     * 
     * @param string $texto para resumir
     * @param int $limite quantidade de caracteres
     * @param string $continue opcional - o que de ser exibido ao final do resumo
     * @return string texto resumido
     */

    public static function resumirTexto(string $texto, int $limite, string $continue = '...'): string
    {
        $textoLimpo = trim(strip_tags($texto));
        if(mb_strlen($textoLimpo) <= $limite) {
            return $textoLimpo;
        }

        $resumirTexto = trim(mb_substr($textoLimpo, 0, $limite));

        return $resumirTexto . $continue;
    }

    /**
     * Concatena o texto de pares em pares, a segunda palavra vira a primeira
     * @param string $texto Texto para ser concatenado
     * @return Retona o Texto concatenado
     */
    //função para distrair a mente um pouco...

    public static function textConcate(string $texto = 'Texto não fornecido') : string {
        $palavras = explode(" ", $texto);
        foreach ($palavras as $palavra) {
            $string_palavras[] = strval($palavra);
        }
        $string_palavras = array_filter($palavras);
        $palavras = array_values($palavras);

        for ($i=0; $i < count($palavras); $i++) { 
            if ($i % 2 == 0) {
                $par[] = $palavras[$i];
            } else {
                $impar[] = $palavras[$i];
            }
        }

        if (count($impar) == count($par)) {
            for ($i=0; $i < count($par); $i++) { 
                $texto_concatenado[] = $impar[$i];
                $texto_concatenado[] = $par[$i];
            }
        } else {
            for ($i=0; $i < count($impar); $i++) { 
                if($par[$i] && !is_null($par[$i])) {
                    $texto_concatenado[] = $impar[$i];
                    $texto_concatenado[] = $par[$i];
                }
            }
        }
        
        $texto = implode(" ", $texto_concatenado);

        return $texto;
    }
}