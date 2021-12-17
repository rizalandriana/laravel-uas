@extends('welcome')

@section('title', 'Buku')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Buku</h5>
                </div>
                <div class="card-body">
                    <button id="btnTambah" type="button" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Add</button>
                    <div class="btn-group float-right" role="group">
                        <button id="btnDel" type="button" class="btn btn-outline-danger" data-url="{{ url('/buku/hapusAll') }}"><i class="fas fa-minus-circle"></i> Delete</button>
                        <button id="btnRecycle" type="button" class="btn btn-outline-secondary"><i class="fas fa-trash-alt"></i> Recycle Bin</button>
                    </div>
                    <br/>
                    <br/>
                    <table id="myTable" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkBoxAll" class="custom-checkbox"></th>
                                <th>NIB</th>
                                <th>Picture</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tempat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $b)
                            <tr id="tr_{{$b->id}}">
                                <td>
                                    <input type="checkbox" class="custom-checkbox cekbox" data-id="{{$b->id}}">
                                </td>
                                <td>
                                    {{ $b->kode }}
                                    <label for="a" name="id" style="display:none">{{ $b->id }}</label>
                                </td>
                                <td>
                                    @if (empty($b->gambar))
                                        <!-- <div class="text-center"><i class="fas fa-user fa-5x"></i></div> -->
                                        <img width="100px" src="{{ url('/data_file/book_cover.png') }}">
                                    @else
                                        <img width="100px" src="{{ url('/data_file/'.$b->gambar) }}">
                                    @endif
                                </td>
                                <td>{{ $b->judul_buku }}</td>
                                <td>{{ $b->tahun }}</td>
                                <td>{{ $b->pengarang }}</td>
                                <td>{{ $b->penerbit }}</td>
                                <td>{{ $b->tempat }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-primary btnCartAdd"><i class="fas fa-cart-plus"></i></button>
                                        <button id="editData" type="button" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-outline-danger btnSoftDel"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('modal')
    <!-- Modal untuk Recycle Bin -->
    <div class="modal fade" id="modalRecycle" tabindex="-1" role="dialog" aria-labelledby="modalRecycleTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="divRecycle">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="divTambah">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="divEdit">
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')

        <script>

            // Script untuk buku/tambah & buku/edit/{id}

            var base64data = null;
            var base64dataEdit = null;
            var photoChanged = 'false';

            $("body").on("click", "#btnSave", function(e){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                var kode = $('#kode').val().length;
                var judul = $('#judul').val().length;
                var pengarang = $('#pengarang').val().length;
                var penerbit = $('#penerbit').val().length;
                var tempat = $('#tempat').val().length;
                var tahun = $('#tahun').val().length;
                var harga = $('#harga').val().length;
                var stok = $('#stok').val().length;

                if (kode != 5) {
                    $("#kode").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Kode tidak sesuai!"
                    });
                }
                else if (judul == 0) {
                    $("#judul").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon lengkapi judul buku!"
                    });
                }
                else if (pengarang == 0 || pengarang > 30) {
                    $("#pengarang").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Pengarang tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (penerbit == 0 || penerbit > 30) {
                    $("#penerbit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Penerbit tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (tempat == 0 || tempat > 30) {
                    $("#tempat").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Tempat tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (tahun < 4) {
                    $("#tahun").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi tahun dengan benar!"
                    });
                }
                else if (harga == 0) {
                    $("#harga").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi harga!"
                    });
                }
                else if (stok == 0) {
                    $("#stok").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi stock!"
                    });
                }
                else {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/buku/store",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'kode': $('#kode').val(), 'judul': $('#judul').val(), 'harga': $('#harga').val(), 'stok': $('#stok').val(), 'pengarang': $('#pengarang').val(), 'penerbit': $('#penerbit').val(), 'tahun': $('#tahun').val(), 'tempat': $('#tempat').val(), 'image': base64data},
                        success: function(data){
                            $modal.modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: data['success']
                            });
                            location.reload();
                        }
                    });
                }
            });

            $("body").on("click", "#btnSaveEdit", function(e){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                var kode = $('#kodeEdit').val().length;
                var judul = $('#judulEdit').val().length;
                var pengarang = $('#pengarangEdit').val().length;
                var penerbit = $('#penerbitEdit').val().length;
                var tempat = $('#tempatEdit').val().length;
                var tahun = $('#tahunEdit').val().length;
                var harga = $('#hargaEdit').val().length;
                var stok = $('#stokEdit').val().length;
                var id = $('#idEdit').val();

                if (kode != 5) {
                    $("#kodeEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Kode tidak sesuai!"
                    });
                }
                else if (judul == 0) {
                    $("#judulEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon lengkapi judul buku!"
                    });
                }
                else if (pengarang == 0 || pengarang > 30) {
                    $("#pengarangEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Pengarang tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (penerbit == 0 || penerbit > 30) {
                    $("#penerbitEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Penerbit tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (tempat == 0 || tempat > 30) {
                    $("#tempatEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama Tempat tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (tahun < 4) {
                    $("#tahunEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi tahun dengan benar!"
                    });
                }
                else if (harga == 0) {
                    $("#hargaEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi harga!"
                    });
                }
                else if (stok == 0) {
                    $("#stokEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon isi stock!"
                    });
                }
                else {
                    $.ajax({
                        type: "PUT",
                        dataType: "json",
                        url: "/buku/update/" + id,
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'kode': $('#kodeEdit').val(), 'judul': $('#judulEdit').val(), 'harga': $('#hargaEdit').val(), 'stok': $('#stokEdit').val(), 'pengarang': $('#pengarangEdit').val(), 'penerbit': $('#penerbitEdit').val(), 'tahun': $('#tahunEdit').val(), 'tempat': $('#tempatEdit').val(), 'image': base64dataEdit, 'photo_changed': photoChanged},
                        success: function(data){
                            $modalEdit.modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: data['success']
                            });
                            location.reload();
                        }
                    });
                }
            });

            $("body").on("click", "#btnRemoveFotoOnTambah", function(e){
                url = null;
                base64data = null;
                $('#croppedImage').attr('src', '/data_file/book_cover.png');
                $('#photo').val(null);
            });

            $("body").on("click", "#btnRemoveFotoOnEdit", function(e){
                url = null;
                base64dataEdit = null;
                $('#croppedImageEdit').attr('src', '/data_file/book_cover.png');
                $('#photoEdit').val(null);
                photoChanged = 'true';
            });

        ////////////////////////////////////////////////////////////////////////////////////////

            $(document).ready( function () {
                $('#myTable').DataTable({
                    "scrollX": true
                });
            });

            $('body').on('click', '#editData', function (event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="id"]').text()).trim();
                var route = '/buku/edit/' + id;
                $('#divEdit').load(route);
                photoChanged = 'false';
                $('#modalEdit').modal('show');
            });

            $('body').on('click', '.btnCartAdd', function (event) {
                event.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    // showCloseButton: true,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="id"]').text()).trim();
                $.ajax({
                    url: '/buku/storecart',
                    type: 'POST',
                    data: {'_token': $('meta[name="_token"]').attr('content'), 'id': id},
                    ajaxasync: true,
                    success: function (data) {    
                        if (data['success']) {
                            Toast.fire({
                                icon: 'success',
                                title: data['success']
                            });
                            countcart();
                        }
                        else if (data['warning']) {
                            Toast.fire({
                                icon: 'warning',
                                title: data['warning']
                            });
                        }
                    },
                    failure: function (data) {
                        // console.log(data.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: data.responseText
                        });
                    },
                    error: function (data) {
                        // console.log(data.responseText);
                        Toast.fire({
                            icon: 'error',
                            title: data.responseText
                        });
                    }
                });
            });

            $('body').on('click', '#btnTambah', function (event) {
                event.preventDefault();
                var route = '/buku/tambah';
                $('#divTambah').load(route);
                $('#modalTambah').modal('show');
            });

            $('body').on('click', '#btnRecycle', function (event) {
                event.preventDefault();
                var route = '/buku/recycle';
                $('#divRecycle').load(route);
                $('#modalRecycle').modal('show');
            });

            $('#checkBoxAll').click(function () {
                if ($(this).is(":checked")) {
                    $(".cekbox").prop("checked", true)
                }
                else {
                    $(".cekbox").prop("checked", false)
                }
            });

            $("#btnDel").click(function (e) {
                e.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                var allVals = [];
                $(".cekbox:checked").each(function() {  
                    allVals.push($(this).attr('data-id'));
                });

                if(allVals.length <= 0)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: "No data selected!"
                    });
                }
                else
                {
                    var check = confirm("Move " + allVals.length + " data(s) to Recycle Bin?");
                    if(check == true)
                    {
                        var join_selected_values = allVals.join(",");

                        $.ajax({
                            url: $(this).data('url'),
                            type: 'GET',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+join_selected_values,
                            ajaxasync: true,
                            success: function (response) {
                                if (response['success']) {
                                    // $(".cekbox:checked").each(function() {
                                    //     $(this).parents("tr").remove();
                                    // });
                                    // alert(response['success']);
                                    Toast.fire({
                                        icon: 'info',
                                        title: response['success']
                                        });
                                    location.reload();
                                } else if (response['error']) {
                                    // alert(response['error']);
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['error']
                                    });
                                } else {
                                    // alert('Whoops something went wrong!');
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Whoops something went wrong!'
                                    });
                                }
                            },
                            error: function (response) {
                                // alert(response.responseText);
                                Toast.fire({
                                        icon: 'error',
                                        title: response.responseText
                                });
                            }
                        });

                        // $.each(allVals, function( index, value ) {
                        //     $('table tr').filter("[data-row-id='" + value + "']").remove();
                        // });
                    }
                }
            });

            // $('#modalRecycle').find("#btnRestore").click(function (e) {    
            // });
            $('body').on('click', '#btnRestore', function (e) {
                e.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                var allVals = [];
                $(".cekboxRecycle:checked").each(function() {  
                    allVals.push($(this).attr('data-id'));
                });

                if(allVals.length <= 0)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: "No data selected!"
                    });
                }
                else
                {
                    var check = confirm("Restore " + allVals.length + " data(s)?");
                    if(check == true)
                    {
                        var join_selected_values = allVals.join(",");

                        $.ajax({
                            url: $(this).data('url'),
                            type: 'GET',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+join_selected_values,
                            ajaxasync: true,
                            success: function (response) {
                                if (response['success']) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: response['success']
                                        });
                                    location.reload();
                                } else if (response['error']) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['error']
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Whoops something went wrong!'
                                    });
                                }
                            },
                            error: function (response) {
                                Toast.fire({
                                        icon: 'error',
                                        title: response.responseText
                                });
                            }
                        });
                    }
                }
            });

            $('body').on('click', '#btnDelPermanentAll', function (e) {
                e.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                
                var allVals = [];
                $(".cekboxRecycle:checked").each(function() {  
                    allVals.push($(this).attr('data-id'));
                });

                if(allVals.length <= 0)
                {
                    Toast.fire({
                        icon: 'warning',
                        title: "No data selected!"
                    });
                }
                else
                {
                    var check = confirm("Permanently delete " + allVals.length + " data(s)?");
                    if(check == true)
                    {
                        var join_selected_values = allVals.join(",");

                        $.ajax({
                            url: $(this).data('url'),
                            type: 'GET',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+join_selected_values,
                            ajaxasync: true,
                            success: function (response) {
                                if (response['success']) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: response['success']
                                        });
                                    location.reload();
                                } else if (response['error']) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: response['error']
                                    });
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Whoops something went wrong!'
                                    });
                                }
                            },
                            error: function (response) {
                                Toast.fire({
                                        icon: 'error',
                                        title: response.responseText
                                });
                            }
                        });
                    }
                }
            });

            $('body').on('click', '.btnHapus', function (e) {
                e.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                if (confirm('Are you sure delete data permanently?')) {
                    var tr = $(this).closest('tr');
                    var id = (tr.find('label[name="idr"]').text()).trim();

                    $.ajax({
                        url: '/buku/hapuspermanen/' + id,
                        type: 'GET',
                        data: {id:id},
                        ajaxasync: true,
                        success: function (response) {
                            // alert(response);
                            Toast.fire({
                                icon: 'info',
                                title: response
                            });
                            location.reload();
                        },
                        failure: function (response) {
                            // alert(response.responseText);
                            Toast.fire({
                                icon: 'warning',
                                title: response.responseText
                            });
                        },
                        error: function (response) {
                            // alert(response.responseText);
                            Toast.fire({
                                icon: 'error',
                                title: response.responseText
                            });
                        }
                    });
                }
            });

            function toastrestore() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'success',
                    title: 'Restore data successfully'
                })
            };

            function toasthapus() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'info',
                    title: 'Data is moved to the recycle bin'
                })
            };

            $(".btnSoftDel").click(function (e) {
                e.preventDefault();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                if (confirm('Move data to Recycle Bin?')) {
                    var tr = $(this).closest('tr');
                    var id = (tr.find('label[name="id"]').text()).trim();
                    
                    $.ajax({
                        url: '/buku/hapus/' + id,
                        type: 'GET',
                        data: {id:id},
                        ajaxasync: true,
                        success: function (response) {
                            // alert(response);
                            Toast.fire({
                                icon: 'info',
                                title: response
                            });
                            location.reload();
                        },
                        failure: function (response) {
                            // alert(response.responseText);
                            Toast.fire({
                                icon: 'warning',
                                title: response.responseText
                            });
                        },
                        error: function (response) {
                            // alert(response.responseText);
                            Toast.fire({
                                icon: 'error',
                                title: response.responseText
                            });
                        }
                    });
                }
            });

            function toastsuccess() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    // timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'success',
                    title: 'Save data successfully'
                })

            };

        </script>
    @endsection

@else
    @section('konten')
        <div class="alert alert-danger" role="alert">
            You don't have any access!
        </div>
    @endsection
        @if (Route::has('register'))

        @endif
    @endauth
@endif