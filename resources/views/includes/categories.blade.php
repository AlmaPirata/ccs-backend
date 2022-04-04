@push('scripts')
    <link rel="stylesheet" href="/css/app.css" />
@endpush

<div class="btn-group mb-4 category-feed" role="group" aria-label="Basic outlined example">
    @foreach($categories as $category)
        <a href="{{route('getNewsByCategory', $category->id)}}" class="btn btn-outline-primary category-item">{{$category->title}}</a>
    @endforeach
</div>
