@extends('frontend.layout.main', ['titlePage' => 'Wishlist'])

@section('content')
    <section class="container py-5">
        <h2>My Wishlist</h2>

        @if ($wishlistItems->count() > 0)
            <div class="row">
                @foreach ($wishlistItems as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset($item->product->images->first()->image_path ?? '') }}" class="card-img-top">

                            <div class="card-body">
                                <h5>{{ $item->product->name }}</h5>
                                <p>LKR {{ number_format($item->product->price, 2) }}</p>

                                <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Your wishlist is empty.</p>
        @endif
    </section>
@endsection
