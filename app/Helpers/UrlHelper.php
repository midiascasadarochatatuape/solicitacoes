<?php

namespace App\Helpers;

class UrlHelper
{
    public static function cleanUrl()
    {
        return url()->current();
    }

    public static function sortUrl($campo, $direcaoAtual = null)
    {
        $request = request();
        $params = $request->except(['page']);

        // Remove parâmetros vazios
        $params = array_filter($params, function($value) {
            return $value !== null && $value !== '';
        });

        // Define a direção da ordenação
        if ($direcaoAtual === 'asc') {
            $params['sort'] = $campo . '-desc';
        } else {
            $params['sort'] = $campo . '-asc';
        }

        return $request->url() . '?' . http_build_query($params);
    }
}
