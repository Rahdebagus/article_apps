@extends('layouts.app')
@section('content')
<div class="container">
    <form class="row" id="edit_form" >
        @csrf
        <div class="col-lg-12 mb-3">
            <label class="d-flex align-items-center fs-6 form-label mb-2">
                <span class="fw-bold required">Nama Article</span>
            </label>
            <input type="text" name="title" class="form-control form-control-solid" value="{{ $article->title }}">
        </div>
        <div class="col-lg-12 mb-3">
            <label class="d-flex align-items-center fs-6 form-label mb-2">
                <span class="fw-bold required">Isi Article</span>
            </label>
            <textarea type="text" name="description" class="form-control form-control-solid">{{$article->description}}</textarea>
        </div>
        <div class="col-lg-12 mb-3">
            <label class="d-flex align-items-center fs-6 form-label mb-2">
                <span class="fw-bold required">Nama Article</span>
            </label>
            <p>URL Gambar Saat Ini: {{ $article->image }}</p>
            <input type="file" name="image" class="form-control form-control-solid">
        </div>
        <button type="submit" id="submit" action="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#edit_form').on('submit', function(event){ 

            event.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('articles.update',['id'=>$article->id]) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST', 
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    window.location.href = "{{ route('home') }}";
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        toastr.error('Terjadi kesalahan dalam validasi formulir.', 'Error');
                    } else {
                        toastr.error('Terjadi kesalahan saat mengirim data.', 'Error');
                    }
                }
            });
        });
    });
    
</script>
@endsection