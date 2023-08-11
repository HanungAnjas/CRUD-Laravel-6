@extends('layout.admin')

@section('content')

<body>
    <h1 class="text-center mb-5 mt-5">Edit Data Pegawai</h1>

        <div class="container mr-1 mb-5">

            <div class="row justify-content-center">
                <div class="col-8">
                  <div class="card">
                    <div class="card-body">
                      <form action="/updatedata/{{ $data->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Nama</label>
                          <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $data->nama }}">
                        </div>
                        @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">NIK</label>
                          <input type="text" name="nik" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $data->nik }}"> 
                        </div>
                        @error('nik')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Posisi</label>
                          <select class="form-select" name="posisi" aria-label="Default select example">
                            <option selected>{{ $data->posisi }}</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="Frontend">Frontend</option>
                            <option value="Backend">Backend</option>
                          </select>
                        </div>
                        @error('posisi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>

  @endsection