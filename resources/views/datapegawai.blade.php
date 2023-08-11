@extends('layout.admin')
@push('css')
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 ml-1">
          <div class="col-sm-6">
            <h1 class="m-0">Data Pegawai</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="container ml-4">
            <a href="/tambahpegawai" class="btn btn-success">Tambah +</a>
            
            <div class="row g-3 align-items-center mt-1">
              <div class="col-auto">
              <form action="/pegawai" method="GET">
                <input type="search" id="inputPassword6" name="search" class="form-control" aria-describedby="passwordHelpInline">
              </form>
              </div>

              <div class="col-auto">
                <a href="/exportpdf" class="btn btn-danger">Export PDF</a>
              </div>

              <div class="col-auto">
                <a href="/exportexcel" class="btn btn-success">Export Excel</a>
              </div>

              <div class="col-auto">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Data
                </button>
              </div>

              <div class="col-auto">
                <a href="/logout" class="btn btn-danger">Logout</a>
              </div>

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Pegawai</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/importexcel" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <input type="file" name="file" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

            <div class="row">
                <table id="pegawaiTable" class="table mt-2">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Dibuat</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0; $i < count($data); $i++) { ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1; ?></th>
                            <td>
                                <img src="<?php echo asset('fotopegawai/' . $data[$i]->foto); ?>" alt="" style="width: 40px;">
                            </td>
                            <td><?php echo $data[$i]->nama; ?></td>
                            <td><?php echo $data[$i]->nik; ?></td>
                            <td><?php echo $data[$i]->posisi; ?></td>
                            <td><?php echo date('D M Y', strtotime($data[$i]->created_at)); ?></td>
                            <td>
                                <a href="/tampilkandata/<?php echo $data[$i]->id; ?>" class="btn btn-info">Edit</a>
                                <a href="#" class="btn btn-danger delete" data-id="<?php echo $data[$i]->id; ?>" data-nama="<?php echo $data[$i]->nama; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    @push('js')
                    <script>
                        $(document).ready(function() {
                            $('#pegawaiTable').DataTable({
                                serverSide: true,
                                processing: true,
                                ajax: {
                                    url: "{{ route('pegawai') }}",
                                    type: 'GET',
                                },
                                columns: [
                                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                    { data: 'foto', name: 'foto' },
                                    { data: 'nama', name: 'nama' },
                                    { data: 'nik', name: 'nik' },
                                    { data: 'posisi', name: 'posisi' },
                                    { data: 'created_at', name: 'created_at' },
                                    { data: 'action', name: 'action', orderable: false, searchable: false },
                                ]
                            });
                        });
                    </script>
                    @endpush

                      
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script
      src="https://code.jquery.com/jquery-3.7.0.min.js"
      integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
      crossorigin="anonymous"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>

  <script>
    $('.delete').click(function(){
      var pegawaiid = $(this).attr('data-id');
      var nama = $(this).attr('data-nama');
      swal({
        title: "Apa kamu yakin?",
        text: "Anda akan menghapus data pegawai dengan nama "+nama+"",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location = "/delete/"+pegawaiid+""
          swal("File Anda telah dihapus!", {
            icon: "success",
          });
        } else {
          swal("File Anda tidak dihapus!");
        }
      });
    });
    
  </script>
  <script>
  @if (Session::has('success'))
    toastr.success("{{ Session::get('success') }}")
  @endif
  </script>

@endsection