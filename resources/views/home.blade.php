@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-5">
            <a href="{{ route('articles.create') }}" class="btn btn-primary">Create</a>

        </div>
        <div class="row">

            @foreach ($articles as $article)
                <div class="card mb-3 me-2 " style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class=" "
                                style=" width: 100%;
                height: 200px;
                padding:1rem;
                background-image: url('img_flowers.jpg');
                background-repeat: no-repeat;
                background-size: contain;
                border: 1px solid red; 
                overflow:hidden;
                box-">
                                @if ($article->image)
                                    <img style="" src="   {{ asset('storage/articles/' . $article->image) }} "
                                        class="img-fluid rounded-start p-2" alt="...">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">

                                <h5 class="card-title">{{ $article->title }}</h5>
                                <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                                    class="card-text">{{ $article->description }}</a>
                                <p class="card-text"><small class="text-body-secondary">{{ $article->user->name }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="container mt-5">
                <h1>My Article</h1>
                <div class="wrapper d-flex">
                    @foreach ($userArticle as $article)
                        <div class="card mb-3 me-2 " style="max-width: 540px;">

                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class=" "
                                        style=" width: 100%;
                height: 200px;
                padding:1rem;
                background-image: url('img_flowers.jpg');
                background-repeat: no-repeat;
                background-size: contain;
                overflow:hidden;
                box-">
                                        @if ($article->image)
                                            <img style="" src="   {{ asset('storage/articles/' . $article->image) }} "
                                                class="img-fluid rounded-start p-2" alt="...">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">

                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                                            class="card-text">{{ $article->description }}</a>
                                        <p class="card-text"><small
                                                class="text-body-secondary">{{ $article->user->name }}</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Check if there is a success message in the URL query parameter
            const successMessage = "{{ session('successMessage') }}";
            if (successMessage) {
                toastr.success(successMessage, 'Success'); // Display the success message as a toast
            }
        });
    </script>
@endsection
