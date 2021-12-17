@extends('welcome')

@section('title', 'Member')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Member</h5>
                </div>
                <div class="card-body">
                    <button id="btnTambah" type="button" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Add</button>
                    <div class="btn-group float-right" role="group">
                        <button id="btnDel" type="button" class="btn btn-outline-danger" data-url="{{ url('/member/hapusAll') }}"><i class="fas fa-minus-circle"></i> Delete</button>
                        <button id="btnRecycle" type="button" class="btn btn-outline-secondary"><i class="fas fa-trash-alt"></i> Recycle Bin</button>
                    </div>
                    <br/>
                    <br/>
                    <table id="myTable" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkBoxAll" class="custom-checkbox"></th>
                                <th>NIM</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Alamat</th>
                                <th>HP</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($member as $m)
                            <tr id="tr_{{$m->id}}">
                                <td>
                                    <input type="checkbox" class="custom-checkbox cekbox" data-id="{{$m->id}}">
                                </td>
                                <td>
                                    {{ $m->kode }}
                                    <label for="a" name="id" style="display:none">{{ $m->id }}</label>
                                </td>
                                <td>
                                    @if (empty($m->foto))
                                        <div class="text-center"><i class="fas fa-user fa-5x"></i></div>
                                    @else
                                        <img width="100px" src="{{ url('/data_file/'.$m->foto) }}">
                                    @endif
                                </td>
                                <td>{{ $m->nama }}</td>
                                <td>{{ $m->kategori->nama }}</td>
                                <td>{{ $m->alamat }}</td>
                                <td>{{ $m->hp }}</td>
                                <td>{{ $m->email }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
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

            // Script untuk member/tambah & member/edit/{id}

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

                function validateEmail() {
                    if ($('#email').val().trim() != '') {
                        // var rs = document.forms["formInput"]["email"].value;
                        var rs = $('#email').val();
                        var atps=rs.indexOf("@");
                        var dots=rs.lastIndexOf(".");
                        if (atps<1 || dots<atps+2 || dots+2>=rs.length) {
                            return false;
                        }
                        else {
                            return true;
                        }
                    }
                    else {
                        return true;
                    }
                }

                var kode = $('#kode').val().length;
                var kategori = $('select[name=kategori] option').filter(':selected').val();
                var nama = $('#nama').val().length;
                var hp = $('#hp').val().length;
                var alamat = $('#alamat').val().length;

                if (kode != 5) {
                    $("#kode").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Kode tidak sesuai!"
                    });
                }
                else if (kategori == '') {
                    $("#selectKategori").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon pilih kategori!"
                    });
                }
                else if (nama == 0 || nama > 30) {
                    $("#nama").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (hp < 3 || hp > 14) {
                    $("#hp").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nomor HP min 3 karakter dan max 14 karakter!"
                    });
                }
                else if (validateEmail() == false) {
                    $("#email").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Alamat email tidak valid!"
                    });
                }
                else if (alamat < 10) {
                    $("#alamat").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon lengkapi alamat dengan benar!"
                    });
                }
                else {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "/member/store",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'kode': $('#kode').val(), 'kategori': kategori, 'nama': $('#nama').val(), 'alamat': $('#alamat').val(), 'hp': $('#hp').val(), 'email': $('#email').val(), 'image': base64data},
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

                function validateEmail() {
                    if ($('#emailEdit').val().trim() != '') {
                        // var rs = document.forms["formInput"]["email"].value;
                        var rs = $('#emailEdit').val();
                        var atps=rs.indexOf("@");
                        var dots=rs.lastIndexOf(".");
                        if (atps<1 || dots<atps+2 || dots+2>=rs.length) {
                            return false;
                        }
                        else {
                            return true;
                        }
                    }
                    else {
                        return true;
                    }
                }

                var kode = $('#kodeEdit').val().length;
                var kategori = $('select[name=kategoriEdit] option').filter(':selected').val();
                var nama = $('#namaEdit').val().length;
                var hp = $('#hpEdit').val().length;
                var alamat = $('#alamatEdit').val().length;
                var id = $('#idEdit').val();

                if (kode != 5) {
                    $("#kodeEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Kode tidak sesuai!"
                    });
                }
                else if (kategori == '') {
                    $("#selectKategoriEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon pilih kategori!"
                    });
                }
                else if (nama == 0 || nama > 30) {
                    $("#namaEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nama tidak boleh kosong dan max 30 karakter!"
                    });
                }
                else if (hp < 3 || hp > 14) {
                    $("#hpEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Nomor HP min 3 karakter dan max 14 karakter!"
                    });
                }
                else if (validateEmail() == false) {
                    $("#emailEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Alamat email tidak valid!"
                    });
                }
                else if (alamat < 10) {
                    $("#alamatEdit").focus();
                    Toast.fire({
                        icon: 'warning',
                        title: "Mohon lengkapi alamat dengan benar!"
                    });
                }
                else {
                    $.ajax({
                        type: "PUT",
                        dataType: "json",
                        url: "/member/update/" + id,
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'kode': $('#kodeEdit').val(), 'kategori': kategori, 'nama': $('#namaEdit').val(), 'alamat': $('#alamatEdit').val(), 'hp': $('#hpEdit').val(), 'email': $('#emailEdit').val(), 'image': base64dataEdit, 'photo_changed': photoChanged},
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
                $('#croppedImage').attr('src', '/data_file/User_icon_BLACK-01.png');
                $('#photo').val(null);
            });

            $("body").on("click", "#btnRemoveFotoOnEdit", function(e){
                url = null;
                base64dataEdit = null;
                $('#croppedImageEdit').attr('src', '/data_file/User_icon_BLACK-01.png');
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
                var route = '/member/edit/' + id;
                $('#divEdit').load(route);
                photoChanged = 'false';
                $('#modalEdit').modal('show');
            });

            $('body').on('click', '#btnTambah', function (event) {
                event.preventDefault();
                var route = '/member/tambah';
                $('#divTambah').load(route);
                $('#modalTambah').modal('show');
            });

            $('body').on('click', '#btnRecycle', function (event) {
                event.preventDefault();
                var route = '/member/recycle';
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
                        url: '/member/hapuspermanen/' + id,
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
                        url: '/member/hapus/' + id,
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