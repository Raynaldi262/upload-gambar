@extends('layout.app')

@section('title')
Add Image
@endsection
<style>
    img {
        max-width: 100%;
        max-height: 100%;
    }

    .card {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        margin-top: 10%;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <dic class="card col-sm-4 bg-info">
                    <form action="/upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type='hidden' name='doc_id' id='doc_id' value="{{$id}}">
                        <div class="col-sm-12 gambar">
                            <img src="storage/images/default.jpg" class="img-tumbnail img-preview" width="200px">
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" onchange="preview()">
                                <label class="custom-file-label" for="image">Pilih Gambar</label>
                                @error('image')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 d-inline">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>

                    <a href="/" class="d-inline">
                        <button class="btn btn-danger">Kembali</button>
                    </a>
            </div>
        </div>

        @if ($counter == 1)
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($counter == 6)
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

    </div>

</body>