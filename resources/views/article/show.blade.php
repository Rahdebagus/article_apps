@extends('layouts.app')
@section('content')
    <div class="container ">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4 p-2">
                    <div class="img-wrapper">
                        @if ($article->image)
                            <img src="{{ asset('storage/articles/' . $article->image) }}" class="img-fluid rounded-start "
                                style="overflow: hidden" alt="...">
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="title d-flex justify-content-between align-item-center mb-3">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p> {{ $article->created_at->format('d F Y') }}</p>

                        </div>
                        <p class="card-text">{{ $article->description }}</p>
                        <p class="card-text">User : {{ $article->user->name }}</p>
                        {{--  < class="card-text">Data di : <p>Status artikel: {{ $visibility }}</p>s  --}}
                    </div>
                    <div class="d-flex gap-2 m-3">

                        @if ($article->user_id == Auth::user()->id || Auth::user()->role == 'admin')
                            <a id="edit_form" href="{{ route('articles.edit', ['id' => $article->id]) }}"
                                class="btn btn-primary col-3 ">Edit</a>
                            <button id="btn-delete" class="btn btn-danger col-3 ">Delete</button>

                            <button id="btn-change-visible" class="btn btn-danger col-3 "><span
                                    id="visibilityStatus">{{ $article->show ? 'public' : 'private' }}</span></button>
                        @endif



                    </div>


                    <div class="col-lg-12 border">
                        <h5>komentar</h5>
                        @if ($article->comments)
                            @foreach ($article->comments as $comment)
                                <div class="col-lg-12 border">
                                    <p>{{ $comment->user->name }}</p>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        @else
                            <p>belum ada komentar</p>
                        @endif
                    </div>


                    <div class="col-lg-12 border">
                        <form id="comment_form" action="">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <textarea name="comment" id="" cols="30" rows="2"></textarea>
                            <button type="submit">kirim</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--  <img src="{{ asset('storage/articles/wahde.png') }}" class="img-fluid rounded-start" alt="...">  --}}
    </div>
    <script>
        $(document).ready(function() {



            @if ($article->user_id == Auth::user()->id || Auth::user()->role == 'admin')


                $('#btn-delete').on('click', function() {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('articles.destroy', ['id' => $article->id]) }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'DELETE',
                        data: {
                            id: '{{ $article->id }}'
                        },
                        success: function(data) {
                            window.location.href = "{{ route('home') }}";
                        },
                        error: function(xhr, status, error) {
                            const data = xhr.responseJSON;
                            toastr.error(data.message, 'Opss')
                        }

                    })
                })

                {{--  //  --}}
                $('#btn-change-visible').on('click', function() {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('articles.change') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        data: {
                            id: '{{ $article->id }}'
                        },
                        success: function(data) {
                            console.log(data); // Cetak respons JSON ke konsol untuk pemeriksaan
                            toastr.success(data.message, 'berhasil');

                            {{--  var showStatus = {!! json_encode(session('article_show_status', $article->show)) !!};
                            $('#visibilityStatus').text(showStatus ? 'public' : 'private');  --}}

                            $('#visibilityStatus').text(data.message);
                        },
                        error: function(xhr, status, error) {
                            const data = xhr.responseJSON;
                            toastr.error(data.message, 'Opss')
                        }

                    })
                })

                $('#comment_form').on('submit', function() {
                    event.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('articles.comment.add', ['id' => $article->id]) }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            toastr.success(data.message, 'berhasil');
                            setTimeout(() => {
                                    location.reload();
                                },
                                1000)

                        },
                        error: function(xhr, status, error) {
                            const data = xhr.responseJSON;
                            toastr.error(data.message, 'Opss')
                        }

                    })
                })
            @endif
        })
    </script>
@endsection
