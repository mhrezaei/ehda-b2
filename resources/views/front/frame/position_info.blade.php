@if(!isset($color) or !$color)
    {{ null, $color = 'black' }}
@endif

<div class="row">
    @if(isset($group) and $group)
        <div class="page-{{ $color }}-title col-xs-12">
            <h3 class="container">{{ $group }}</h3>
        </div>
    @endif
    <div class="col-xs-12">
        <div class="container">
            @if(isset($category) and $category)
                <h2 class="text-success">{{ $category }}</h2>
            @endif
            @if(isset($title) and $title)
                <h3 class="gallery-title">{{ $title }}</h3>
            @endif
            @if(isset($description) and $description)
                <p class="gallery-description">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>