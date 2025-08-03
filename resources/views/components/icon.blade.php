@if($type === 'custom')
    @php
        $iconPath = public_path("images/icons/{$name}.svg");
        $iconExists = file_exists($iconPath);
    @endphp
    
    @if($iconExists)
        @php
            $svg = file_get_contents($iconPath);
            $classes = trim($class . ' ' . $size . ' ' . $color);
            // Sanitize classes to prevent XSS
            $classes = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $classes);
            if($classes) {
                $svg = str_replace('<svg', '<svg class="' . htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') . '"', $svg);
            }
            // Basic SVG sanitization
            $allowedTags = ['svg', 'path', 'g', 'circle', 'rect', 'line', 'polyline', 'polygon', 'ellipse', 'defs', 'use'];
            $svg = strip_tags($svg, '<' . implode('><', $allowedTags) . '>');
        @endphp
        {!! $svg !!}
    @else
        <!-- Fallback to FontAwesome -->
        <i class="fas fa-{{ $name }} {{ $class }} {{ $size }} {{ $color }}"></i>
    @endif
@elseif($type === 'village')
    @php
        $villageIcons = [
            'home' => 'house',
            'news' => 'newspaper', 
            'gallery' => 'images',
            'contact' => 'phone',
            'profile' => 'info-circle',
            'announcement' => 'bullhorn',
            'user' => 'user',
            'eye' => 'eye',
            'village' => 'tree-city',
            'population' => 'users',
            'area' => 'map-location-dot',
            'economy' => 'chart-line',
        ];
        $iconName = $villageIcons[$name] ?? $name;
    @endphp
    <i class="fas fa-{{ $iconName }} {{ $class }} {{ $size }} {{ $color }}"></i>
@else
    <!-- Default FontAwesome -->
    <i class="fas fa-{{ $name }} {{ $class }} {{ $size }} {{ $color }}"></i>
@endif
