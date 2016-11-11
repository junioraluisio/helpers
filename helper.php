<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 07/11/2016
 * Time: 10:10
 */

if (!function_exists('sysName')) {
    function sysName($type='name'){
        return ($type == 'name') ? 'GRS 9' : 'grs9';
    }
}

if (!function_exists('UrlPublicPath')) {
    /**
     * Retorna a url da pasta public para as views
     * @return string
     */
    function UrlPublicPath()
    {
        $protocol   = (isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        $serverName = $_SERVER['SERVER_NAME'];
        $scriptName = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

        $path = $protocol . $serverName . $scriptName;

        return $path;
    }
}

if (!function_exists('debug')) {
    /**
     * debug()
     * Cria uma interface que permite a visualização de variáveis
     *
     * @param mixed  $var
     * @param string $exit
     *
     * @return string
     */
    function debug($var, $exit = "")
    {
        $backTrace = debug_backtrace();

        $typeVar = gettype($var);

        $debug = debug_style();

        $debug .= debug_head($backTrace, $typeVar);

        if ($typeVar == 'object') {
            $debug .= debug_var_object($var);
        } else {
            if (is_scalar($var)) {
                $debug .= debug_var_scalar($var);
            } else {
                $debug .= debug_var_normal($var);
            }
        }

        echo $debug;

        if (!empty($exit)) {
            exit;
        }

        return true;
    }
}

if (!function_exists('debug_color')) {
    /**
     * debug_color()
     * function para colorir o debug
     *
     * @param  string $str info to colorize
     *
     * @return string HTML colorida
     */
    function debug_color($str)
    {
        $str = preg_replace("/\[(\w*)\]/i", '[<font color="red">$1</font>]', $str);
        $str = preg_replace("/(\s+)\)$/", '$1)</span>', $str);
        $str = str_replace('Array', '<span style="color: #0000bb">Array</span>', $str);
        $str = str_replace('=>', '<span style="color: #556F55">=></span>', $str);

        return $str;
    }
}

if (!function_exists('debug_style')) {
    /**
     * Retorna o estilo css para a funcção debug()
     *
     * @return string
     */
    function debug_style()
    {
        $style = '<style type="text/css">';
        $style .= '.msgDebug {width:100% !important; display:block !important; top:0 !important; right:0 !important; margin:25px auto !important; background:#fff !important; padding:0 15px 15px 15px !important; border:1px solid #DDDDDD !important; color:#2c3e50 !important; z-index:999 !important; font-family:\"MS Serif\", \"New York\", serif !important; line-height:24px !important;}';
        $style .= '.msgDebug h6 {font-weight:bold;font-size:24px !important; margin-bottom:15px !important; font-family:"Courier New", Courier, monospace !important; padding:10px 0 0 0 !important;}';
        $style .= '.msgDebug .clear {clear:both !important;}';
        $style .= '.msgDebug strong {color:#c0392b !important; font-weight:bold !important;}';
        $style .= '.msgDebug pre {white-space: pre-wrap !important; word-wrap: break-word !important;}';
        $style .= '.msgDebug .tip0 {color:#e74c3c;font-weight:bold;}';
        $style .= '.msgDebug .tip1 {color:#A94442;font-weight:bold;}';
        $style .= '.msgDebug .tip2 {color:#95a5a6;font-style:italic !important;}';
        $style .= '</style>';

        return $style;
    }
}

if (!function_exists('debug_head')) {
    /**
     * Retorna um HEAD para a função debug()
     * @param $backtrace
     * @param $typevar
     *
     * @return string
     */
    function debug_head($backtrace, $typevar)
    {
        $file = isset($backtrace[0]['file']) ? $backtrace[0]['file'] : '';
        $line = isset($backtrace[0]['line']) ? $backtrace[0]['line'] : '';

        $backtrace = '<div class="msgDebug">';
        $backtrace .= '<h6>DEBUG</h6>';
        $backtrace .= '<p>';
        $backtrace .= '<span class="tip2">#Arquivo:</span> ' . $file . '<br />';
        $backtrace .= '<span class="tip2">#Linha:</span> ' . $line . '<br />';
        $backtrace .= '<span class="tip2">#Tipo da variável:</span> ' . $typevar . '<br />';
        $backtrace .= '</p>';
        $backtrace .= '<br />';

        return $backtrace;
    }
}

if (!function_exists('debug_var_object')) {
    /**
     * Retorna uma string formatada para variáveis do tipo object para a função debug()
     *
     * @param $var
     *
     * @return string
     */
    function debug_var_object($var)
    {
        $text = '<pre>';
        $text .= var_export($var, true);
        $text .= '</pre>';
        $text .= '<div class="clear"></div>';
        $text .= '</div>';

        return $text;
    }
}

if (!function_exists('debug_var_scalar')) {
    /**
     * Retorna uma string formatada para variáveis do tipo scalar para a função debug()
     *
     * @param $var
     *
     * @return string]
     */
    function debug_var_scalar($var)
    {
        if (is_bool($var)) {
            $txt = var_export($var) . ' (boolean)';
        } else {
            $txt = preg_replace('/\s\s+/', ' ', $var);
        }

        $arr = [
            "/SELECT/"     => "<strong>SELECT</strong>",
            "/CREATE/"     => "<strong>CREATE</strong>",
            "/DATABASE/"   => "<strong>DATABASE</strong>",
            "/FROM/"       => "\n<strong>FROM</strong>",
            "/DISTINCT/"   => "\n<strong>DISTINCT</strong>",
            "/WHERE/"      => "\n<strong>WHERE</strong>",
            "/AND/"        => "\n<strong>AND</strong>",
            "/ORDER BY/"   => "<strong>ORDER BY</strong>",
            "/GROUP BY/"   => "<strong>GROUP BY</strong>",
            "/OR/"         => "\n<strong>OR</strong>",
            "/LIMIT/"      => "\n<strong>LIMIT</strong>",
            "/IN/"         => "<strong>IN</strong>",
            "/LIKE/"       => "<strong>LIKE</strong>",
            "/ASC/"        => "<strong>ASC</strong>",
            "/DESC/"       => "<strong>DESC</strong>",
            "/INNER JOIN/" => "<strong>INNER JOIN</strong>",
            "/LEFT JOIN/"  => "<strong>LEFT JOIN</strong>",
            "/RIGHT JOIN/" => "<strong>RIGHT JOIN</strong>",
            "/FULL JOIN/"  => "<strong>FULL JOIN</strong>",
            "/UNION ALL/"  => "\n<strong>UNION ALL</strong>",
            "/UNION/"      => "\n<strong>UNION</strong>",
        ];

        $text = '<pre>';
        $text .= preg_replace(array_keys($arr), array_values($arr), $txt);
        $text .= '</pre>';
        $text .= '<div class="clear"></div>';
        $text .= '</div>';

        return $text;
    }
}

if (!function_exists('debug_var_normal')) {
    /**
     * Retorna uma string formatada para variáveis diferentes de object e scalar para a função debug()
     *
     * @param $var
     *
     * @return mixed
     */
    function debug_var_normal($var)
    {
        $txt = serialize($var);
        $txt = unserialize($txt);
        $txt = print_r($txt, true);

        $arr = [
            '/Array/'                        => '<strong>Array</strong>',
            '/\[/'                           => '[<span class=\"tip0\">',
            '/\]/'                           => '</span>]',
            '@<script[^>]*?>.*?</script>@si' => '',
            '@<[\/\!]*?[^<>]*?>@si'          => '',
            '@<style[^>]*?>.*?</style>@siU'  => '',
            '@<![\s\S]*?--[ \t\n\r]*>@'      => ''
        ];

        $text = '<pre>';
        $text .= preg_replace(array_keys($arr), array_values($arr), $txt);
        $text .= '</pre>';
        $text .= '<div class="clear"></div>';
        $text .= '</div>';

        return debug_color($text);
    }
}