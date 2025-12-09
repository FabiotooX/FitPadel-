<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Traduce dinámicamente los textos del menú de AdminLTE en tiempo de render.
        // Evita llamar a __() dentro de los archivos de configuración (causa errores
        // durante el bootstrap). Hacemos la traducción aquí, cuando el traductor
        // ya está disponible.
        $menu = config('adminlte.menu', []);
        $translated = $this->translateMenuItems($menu);
        config(['adminlte.menu' => $translated]);
    }

    /**
     * Recursivamente traduce los items del menú.
     * Si un item tiene 'text', llama a __() (se devolverá el mismo texto si no
     * existe la clave de traducción). Traduce también submenus y headers.
     *
     * @param array $items
     * @return array
     */
    private function translateMenuItems(array $items): array
    {
        foreach ($items as $key => $item) {
            if (!is_array($item)) {
                continue;
            }

            // Traducir 'text' si existe
            if (isset($item['text'])) {
                $items[$key]['text'] = __($item['text']);
            }

            // Traducir 'header' si existe (etiquetas de sección)
            if (isset($item['header'])) {
                $items[$key]['header'] = __($item['header']);
            }

            // Traducir submenus recursivamente
            if (isset($item['submenu']) && is_array($item['submenu'])) {
                $items[$key]['submenu'] = $this->translateMenuItems($item['submenu']);
            }
        }

        return $items;
    }
}
