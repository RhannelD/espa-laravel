@props([
    'bottom',
])

<div class="overflow-auto">
    <table {{ $attributes->class(['table table-hover']) }}>
        {{ $slot }}
    </table>

    {{ $bottom ?? '' }}
</div>
