@extends('layouts.app')
@section('title', 'Wishlist')

@section('content')
<div class="container py-5">
    <h1 class="fw-800 mb-1" style="font-size:1.8rem;">My Wishlist</h1>
    <p class="text-muted mb-4">Products you love</p>

    @if($wishlists->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-heart" style="font-size:5rem; color:#ddd;"></i>
            <h5 class="fw-700 mt-3">Your wishlist is empty</h5>
            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Browse Products</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($wishlists as $wishlist)
            <div class="col-6 col-md-4 col-lg-3" id="wishlist-item-{{ $wishlist->id }}">
                @include('components.product-card', ['product' => $wishlist->product])
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
