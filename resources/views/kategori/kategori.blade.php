@extends('welcome')

@section('title', 'Kategori Member')

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <!-- <div class="card mt-5"> -->
            <div class="card">
                <div class="card-header text-center">
                    <h5>Kategori Member</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <!-- <a href="/member/category/tambah" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalTambah">Input Kategori</a> -->
                        <button id="tambahData" type="button" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Add</button>
                        <!-- <a href="/member/category/recycle" class="btn btn-outline-warning float-right">Recycle Bin</a> -->
                        <div class="btn-group float-right" role="group">
                            <button id="btnDel" type="button" class="btn btn-outline-danger" data-url="{{ url('/member/category/hapusAll') }}"><i class="fas fa-minus-circle"></i> Delete</button>
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalRecycleBin"><i class="fas fa-trash-alt"></i> Recycle Bin</button>
                        </div>
                    </div>

                    <br/>
                    <br/>
                    <div style="overflow:auto" class="col-md-12">
                    <table id="myTable" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkBoxAll" class="custom-checkbox"></th>
                                <th>Nama</th>
                                <th>Tgl Dibuat</th>
                                <th>Tgl Diupdate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori as $k)
                            <tr id="tr_{{$k->id}}">
                                <td>
                                    <input type="checkbox" class="custom-checkbox cekbox" data-id="{{$k->id}}">
                                </td>
                                <td>
                                    {{ $k->nama }}
                                    <label for="a" name="id" style="display:none">{{ $k->id }}</label>
                                </td>
                                <td>{{ $k->created_at }}</td>
                                <td>{{ $k->updated_at }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button id="editData" type="button" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                        <!-- <a id="editData" href="/member/category/edit/{{ $k->id }}" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalEdit">Edit</a> -->
                                        <!-- <a id="editData" href="/member/category/edit/{{ $k->id }}" class="btn btn-outline-warning" data-toggle="modal" data-target="#modalEdit" data-id="{{ $k->id }}">Edit</a> -->
                                        <!-- <a href="/member/category/hapus/{{ $k->id }}" class="btn btn-danger" onclick="toasthapussoft()">Delete</a> -->
                                        <button type="button" class="btn btn-outline-danger btnSoftDel"><i class="fas fa-minus-circle"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <!-- <div class="card-footer">
                    Footer Konten
                </div> -->
            </div>
        </div>
    @endsection

    @section('modal')
    <!-- Modal untuk Recycle Bin -->
    <div class="modal fade" id="modalRecycleBin" tabindex="-1" role="dialog" aria-labelledby="modalRecycleBinTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRecycleBinTitle">Kategori Member (Deleted)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                            <div class="col-md-12">
                                <button id="btnRestore" type="button" class="btn btn-outline-primary" data-url="{{ url('/member/category/restoreAll') }}"><i class="fas fa-undo-alt"></i> Restore</button>
                                <div class="btn-group float-right" role="group">
                                    <button id="btnDelPermanentAll" type="button" class="btn btn-outline-danger" data-url="{{ url('/member/category/hapuspermanenAll') }}"><i class="fas fa-fire"></i> Permanently Delete</button>
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <div style="overflow:auto" class="col-md-12">
                                <table id="myTableRecycle" class="table table-bordered table-hover table-striped display">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkBoxRecycleAll" class="custom-checkbox"></th>
                                            <th>Nama</th>
                                            <th>Tgl Dibuat</th>
                                            <th>Tgl Dihapus</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kategoriRecycle as $kk)
                                        <tr id="tr_{{$kk->id}}">
                                            <td>
                                                <input type="checkbox" class="custom-checkbox cekboxRecycle" data-id="{{$kk->id}}">
                                            </td>
                                            <td>
                                                {{ $kk->nama }}
                                                <label for="a" name="idd" style="display:none">{{ $kk->id }}</label>
                                            </td>
                                            <td>{{ $kk->created_at }}</td>
                                            <td>{{ $kk->updated_at }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="/member/category/restore/{{ $kk->id }}" class="btn btn-outline-primary" onclick="toastrestore()"><i class="fas fa-undo-alt"></i></a>
                                                    <!-- <a href="/member/category/hapuspermanen/{{ $kk->id }}" class="btn btn-outline-danger">Permanently Delete</a> -->
                                                    <button type="button" class="btn btn-outline-danger btnHapus"><i class="fas fa-fire"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                </div> <!-- body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="divTambah">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <input type="hidden" id="idData" name="idData" value=""> -->
                <div id="divEdit">
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
                $('#myTableRecycle').DataTable();
            });

            $('#checkBoxAll').click(function () {
                if ($(this).is(":checked")) {
                    $(".cekbox").prop("checked", true)
                }
                else {
                    $(".cekbox").prop("checked", false)
                }
            });

            $('#checkBoxRecycleAll').click(function () {
                if ($(this).is(":checked")) {
                    $(".cekboxRecycle").prop("checked", true)
                }
                else {
                    $(".cekboxRecycle").prop("checked", false)
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

                // Ini metode untuk C# MVC5:
                // var cek = 0;
                // var i = 0;
                // var myreload = false;
                // $('input:checkbox.cekbox').each(function () {
                //     if ($(this).prop('checked')) {
                //         cek += 1;
                //     }
                // });

                // if (cek == 0) {
                //     // alert("Tidak ada data yang di pilih!!!");
                //     Toast.fire({
                //         icon: 'warning',
                //         title: "No data selected!"
                //     });
                // } else {
                //     if (confirm('Move ' + cek + ' data to Recycle Bin?')) {
                //         $('input:checkbox.cekbox').each(function () {
                //             if ($(this).prop('checked')) {
                //                 var tr = $(this).closest('tr');
                //                 var id = (tr.find('label[name="id"]').text()).trim();
                //                 if (id != null) {
                //                     $.ajax({
                //                         url: '/member/category/hapus/' + id,
                //                         type: 'GET',
                //                         data: { id: id },
                //                         ajaxasync: true,
                //                         success: function (response) {
                //                             //alert(response);
                //                             //location.reload();
                //                             alert(id);
                //                             document.getElementById("myTable").deleteRow(i);
                //                             alert('delete row index: ' + i);
                //                         },
                //                         failure: function (response) {
                //                             // alert(response.responseText);
                //                             Toast.fire({
                //                                 icon: 'warning',
                //                                 title: response.responseText
                //                             });
                //                         },
                //                         error: function (response) {
                //                             // alert(response.responseText);
                //                             Toast.fire({
                //                                 icon: 'error',
                //                                 title: response.responseText
                //                             });
                //                         }
                //                     });
                //                 }
                //             }
                //             i += 1;
                //         });

                //         // alert("Berhasil hapus " + cek + " data");
                //         Toast.fire({
                //             icon: 'info',
                //             title: "Successfully deleted " + cek + " data"
                //         });

                //         myreload = true;
                //         // location.reload();
                //         // window.location.href = "/member/category";
                //     };
                // }
                // // if (myreload == true){
                // //     location.reload();
                // // }
            });

            $("#btnRestore").click(function (e) {
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

            $("#btnDelPermanentAll").click(function (e) {
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

            $(".btnHapus").click(function (e) {
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
                    var id = (tr.find('label[name="idd"]').text()).trim();

                    $.ajax({
                        url: '/member/category/hapuspermanen/' + id,
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
                else {

                }
            });

            $('body').on('click', '#editData', function (event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="id"]').text()).trim();
                var route = '/member/category/edit/' + id;
                $('#divEdit').load(route);
                $('#modalEdit').modal('show');
            });

            $('body').on('click', '#tambahData', function (event) {
                event.preventDefault();
                var route = '/member/category/tambah';
                $('#divTambah').load(route);
                $('#modalTambah').modal('show');
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
                        url: '/member/category/hapus/' + id,
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
                else {

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

                // Swal.fire(
                //     'Saved!',
                //     'Your data has been saved.',
                //     'success'
                // )

                // var txt;
                // var r = confirm("Simpan data?");
                // if (r == true) {
                //     Swal.fire(
                //         'Saved!',
                //         'Your data has been saved.',
                //         'success'
                //     )
                // }

                // Swal.fire({
                //     title: 'Save Data',
                //     text: "Do you want to Save?",
                //     icon: 'question',
                //     showCloseButton: true,
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Yes, delete it!'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             Swal.fire(
                //                 'Deleted!',
                //                 'Your file has been deleted.',
                //                 'success'
                //             )
                //         }
                //     })
            };

            //Script ini digunakan Jika konsep edit menggunakan Output JSON bernama 'data'
            //Untuk mengambil data sebelum diedit
            // $('body').on('click', '#editData', function (event) {
            //     event.preventDefault();
            //     // var url = window.location.pathname;
            //     // var id = url.substring(url.lastIndexOf('/') + 1);
            //     var id = $(this).data('id');
            //     console.log(id);
            //     $.get('/member/category/edit/' + id, function (data) {
            //         console.log(data);
            //         $('#idData').val(data.data.id);
            //         $('#nama').val(data.data.nama);
            //         $('#modalEdit').modal('show');
            //         })
            //     });

            //Script ini digunakan Jika konsep edit menggunakan Output JSON bernama 'data'
            //Untuk simpan or update data, tetapi masih gagal!
            // $('body').on('click', '#submit', function (event) {
            //     // event.preventDefault()
            //     var id = $("#idData").val();
            //     var nama = $("#nama").val();
            //     var url = "member/category/update/" + id;
            //     var datastring = "ID: " + id + ", Nama: " + nama;
            //     // $.post(url,
            //     //     {
            //     //         id: id,
            //     //         nama: nama
            //     //     },
            //     //     function(data,status){
            //     //         $('#kategoridata').trigger("reset");
            //     //         $('#modalEdit').modal('hide');
            //     //         window.location.reload(true);
            //     //     });
            //     $.ajax({
            //         type: "POST",
            //         url: url,
            //         data: {
            //             id: id,
            //             nama: nama
            //             },
            //         success: function (data) {
            //             $('#kategoridata').trigger("reset");
            //             $('#modalEdit').modal('hide');
            //             window.location.reload(true);
            //             },
            //         dataType: 'json'
            //         });
            //     });
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