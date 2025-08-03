<?php

if (!function_exists('custom_icon')) {
    /**
     * Render custom icon
     *
     * @param string $name
     * @param string $class
     * @param array $attributes
     * @return string
     */
    function custom_icon($name, $class = '', $attributes = [])
    {
        $iconPath = public_path("images/icons/{$name}.svg");
        
        if (file_exists($iconPath)) {
            $svg = file_get_contents($iconPath);
            
            // Add classes to SVG
            if ($class) {
                $svg = str_replace('<svg', '<svg class="' . $class . '"', $svg);
            }
            
            // Add attributes to SVG
            foreach ($attributes as $attr => $value) {
                $svg = str_replace('<svg', '<svg ' . $attr . '="' . $value . '"', $svg);
            }
            
            return $svg;
        }
        
        // Fallback to FontAwesome if custom icon not found
        return '<i class="fas fa-' . $name . ' ' . $class . '"></i>';
    }
}

if (!function_exists('village_icon')) {
    /**
     * Render village-specific icons
     *
     * @param string $type
     * @param string $class
     * @return string
     */
    function village_icon($type, $class = '')
    {
        $icons = [
            'home' => 'house',
            'news' => 'newspaper',
            'gallery' => 'images',
            'contact' => 'phone',
            'profile' => 'info-circle',
            'announcement' => 'bullhorn',
            'user' => 'user',
            'eye' => 'eye',
            'village' => 'tree-city', // Custom village icon
            'population' => 'users',
            'area' => 'map',
            'economy' => 'chart-line',
        ];
        
        $iconName = $icons[$type] ?? $type;
        return custom_icon($iconName, $class);
    }
}
