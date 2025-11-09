<div class="breadcrumb-area bg-gray">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li>
                    <a href="#">{{ $product->category->name }}</a>
                </li>
                <li class="active">{{ $product->name }}</li>
            </ul>
        </div>
    </div>
</div>