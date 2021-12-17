@extends('welcome')

@section('title', 'Pinjam Buku')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Pinjam Buku</h5>
                </div>
                <div class="card-body">
                    {{ method_field('PUT') }}
                    <div class="form-row">
                        <div class="col-md-4">
                            <label name="idMember" style="display:none"></label>
                            <div class="input-group mb-3">
                                <input type="text" id="txtMember" class="form-control" placeholder="Find Member" readonly>
                                <div class="input-group-append">
                                    <button id="btnMember" class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-5">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">No</span>
                                </div>
                                <input id="txtCode" type="text" class="form-control" placeholder="Transaction" value="{{ $pcode }}" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Total</span>
                                </div>
                                <input id="txtTotal" type="text" class="form-control" placeholder="Amount" readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="float-right">
                                <button id="btnTambah" type="button" class="btn btn-outline-secondary"><i class="fas fa-plus-circle"></i> Add</button>
                                <button id="btnDelCartAll" type="button" class="btn btn-outline-danger"><i class="fas fa-minus-circle"></i> Delete</button>
                                <button id="btnCalc" type="button" class="btn btn-outline-success" style="display:none"><i class="fas fa-arrow-circle-up"></i> Calc</button>
                            </div>
                        </div>
                    </div>
                    <div id="divTableCart">
                    </div>
                    <br>
                    <div class="float-right">
                        <button id="btnUpdate" type="button" class="btn btn-outline-secondary"><i class="fas fa-arrow-circle-up"></i> Update</button>
                        <button id="btnSave" type="button" class="btn btn-outline-primary"><i class="fas fa-save"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('modal')
    <!-- Modal untuk Search Member -->
    <div class="modal fade" id="modalMember" tabindex="-1" role="dialog" aria-labelledby="modalMemberTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="divMember">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Search Buku -->
    <div class="modal fade" id="modalBuku" tabindex="-1" role="dialog" aria-labelledby="modalBukuTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="divBuku">
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')

        <script>

            var qtychanged = false;

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

            function toastsuccess() {
                Toast.fire({
                    icon: 'success',
                    title: 'Save data successfully'
                })
            };

            $(document).ready( function () {
                // To load every 1 second:
                // var request = function () {};
                // setInterval(request, 1000);

                // OR Like This!
                // var requesting = false;
                // var request = function() {
                //     requesting = true;
                //     $.ajax({
                //         success: function(data){
                //             requesting = false;
                //         }
                //     });
                // }
                // if(!requesting){
                //     setTimeout(request, 1000);
                // };
                $("#btnCart").css("display", "none");
                refreshGrid();
            });

            // $('td').click(function(){
            //     // var row_index = $(this).parent().index();
            //     // var col_index = $(this).index();
            //     var row = $(this).parent().index();
            //     // alert('row_index: ' + row_index + ', col_index: ' + col_index);
            //     alert('row: ' + row);

            //     // var tdl = $('td').length;
            //     // alert(tdl);
            // });

            function calculateTotal() {
                // var rowCount = $('#myTable tr[name="cartData"]').length;
                var total = 0;
                // for (var i = 0; i < rowCount; i++) {
                //     var tr = $('tr[index="' + i + '"]');
                //     var harga = tr.find('td[name="harga"]').text();
                //     // var stok = tr.find('td[name="stok"]').text();
                //     var qty = tr.find('.qty').val();
                //     var subtotal = harga * qty;
                //     tr.find('td[name="subtotal"]').text(subtotal);
                //     total += subtotal;
                // }
                $('td[name="harga"]').each(function () {
                    var harga = $(this).text();
                    // var stok = tr.find('td[name="stok"]').text();
                    var tr = $(this).closest('tr');
                    var qty = tr.find('.qty').val();
                    var subtotal = harga * qty;
                    tr.find('td[name="subtotal"]').text(subtotal);
                    total += subtotal;
                });
                $('#txtTotal').val(total);
            };

            function refreshGrid() {
                $('#divTableCart').load('/pinjam/loadcart', function(){
                    $('#myTable').DataTable({
                        // "scrollX": true,
                        "bInfo": true,
                        "bPaginate": false,
                        "bFilter": false,
                        "ordering": false
                    });
                    calculateTotal();
                    // setTimeout(calculateTotal, 1000);
                });
                // $('tbody').parents("tr").remove();
                // $.ajax({
                //     type: 'GET',
                //     url: "/pinjam/refresh",
                //     data: {id: 0},
                //     dataType: 'json',
                //     ajaxasync: true,
                //     success: function (data) {
                //         console.log(data);
                //         for(var i = 0; i < data.length; i++) {
                //             $('tbody').append('<tr id="tr_' + data[i].id + '" name="cartData" index="' + i + '">' +
                //                 '<td>' +
                //                     '<input type="checkbox" class="custom-checkbox cekbox" data-id="' + data[i].id + '">' +
                //                 '</td>' +
                //                 '<td>' +
                //                     data[i].kode +
                //                     '<label for="a" name="idCart" style="display:none">' + data[i].id + '</label>' +
                //                     '<label for="b" name="idBuku" style="display:none">' + data[i].buku_id + '</label>' +
                //                 '</td>' +
                //                 '<td>' +
                //                     data[i].judul_buku +
                //                 '</td>' +
                //                 '<td name="harga">' + data[i].harga_sewa + '</td>' +
                //                 '<td name="stok">' + data[i].stok + '</td>' +
                //                 '<td>' +
                //                     '<input type="number" class="qty" value="' + data[i].qty + '" style="width:50px" min=1 max=10>' +
                //                 '</td>' +
                //                 '<td name="subtotal"></td>' +
                //                 '<td>' +
                //                     '<div class="btn-group" role="group" aria-label="Basic example">' +
                //                         '<button type="button" class="btn btn-outline-danger"><i class="fas fa-minus-circle"></i></button>' +
                //                     '</div>' +
                //                 '</td>' +
                //             '</tr>');
                //         }
                //     },
                //     error: function (data) {
                //         // console.log(data);
                //         Toast.fire({
                //             icon: 'error',
                //             title: data.responseText
                //         });
                //     }
                // });
            };

            $('body').on('click', '#btnUpdate', function (event) {
                event.preventDefault();
                var c = 0;
                var s = 0;
                $('.qty').each(function() {
                    if (($(this).val()).trim() == '' || ($(this).val()).trim() == 0) {
                        c += 1;
                    }
                });

                $('.qty').each(function() {
                    var a = parseInt($(this).val());
                    var b = parseInt($(this).closest('tr').find('td[name="stok"]').text());
                    if ( a > b) {
                        s += 1;
                    }
                });

                if (c > 0) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Qty cannot be empty!'
                    });
                }
                else if (s > 0) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Qty should not exceed the stock!'
                    });
                }
                else {
                    $('tr[name="cartData"]').each(function () {
                        var tr = $(this).closest('tr')
                        var id = tr.find('label[name="idCart"]').text();
                        var buku_id = tr.find('label[name="idBuku"]').text();
                        var qty = tr.find('.qty').val();
                        var method = $('input[name="_method"]').val();
                        $.ajax({
                            url: '/pinjam/updatecart/' + id,
                            type: 'PUT',
                            data: {'_token': $('meta[name="_token"]').attr('content'), '_method': method, 'id': id, 'buku_id': buku_id, 'qty': qty},
                            ajaxasync: true,
                            success: function (data) {
                                console.log(data['success']);
                            },
                            failure: function (response) {
                                console.log(response.responseText);
                                // Toast.fire({
                                //     icon: 'warning',
                                //     title: response.responseText
                                // });
                            },
                            error: function (response) {
                                console.log(response.responseText);
                                // Toast.fire({
                                //     icon: 'error',
                                //     title: response.responseText
                                // });
                            }
                        });
                    });

                    // setTimeout(refreshGrid, 1000);
                    refreshGrid();
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated'
                    });
                    qtychanged = false;
                }
            });

            $('body').on('click', '#btnCalc', function (event) {
                calculateTotal();
            });

            $('body').on('click', '#btnMember', function (event) {
                event.preventDefault();
                var route = '/pinjam/member';
                $('#divMember').load(route);
                $('#modalMember').modal('show');
            });

            $('body').on('click', '#btnTambah', function (event) {
                if (qtychanged == true) {
                    $('#btnUpdate').focus();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Update the data first!'
                    });
                }
                else {
                    event.preventDefault();
                    var route = '/pinjam/buku';
                    $('#divBuku').load(route);
                    $('#modalBuku').modal('show');
                }
            });
            
            $('body').on('click', '.btnDelCart', function (event) {
                var tr = $(this).closest('tr')
                var id = tr.find('label[name="idCart"]').text();
                $.ajax({
                    url: '/pinjam/deletecart/' + id,
                    type: 'GET',
                    data: {id:id},
                    ajaxasync: true,
                    success: function (response) {
                        Toast.fire({
                            icon: 'success',
                            title: response['success']
                        });
                        refreshGrid();
                    },
                    failure: function (response) {
                        Toast.fire({
                            icon: 'warning',
                            title: response['error']
                        });
                    },
                    error: function (response) {
                        Toast.fire({
                            icon: 'error',
                            title: response.responseText
                        });
                    }
                });
            });

            $('body').on('click', '#btnDelCartAll', function (e) {
                e.preventDefault();
                
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
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '/pinjam/deletecartall',
                        type: 'GET',
                        headers: {'_token': $('meta[name="_token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        ajaxasync: true,
                        success: function (response) {
                            if (response['success']) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response['success']
                                });
                                refreshGrid();
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
            });

            $('body').on('click', '#btnSave', function (event) {
                event.preventDefault();
                var c = 0;
                $('tr[name="cartData"]').each(function() {
                    c += 1;
                });
                if (($('#txtMember').val()).trim() == '') {
                    $('#btnMember').focus();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Please choose The Member!'
                    });
                }
                else if (c == 0) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'There is no book!'
                    });
                }
                else if (qtychanged == true) {
                    $('#btnUpdate').focus();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Update the data first!'
                    });
                }
                else {
                    $.ajax({
                        url: '/pinjam/storepinjam',
                        type: 'POST',
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'kode': $('#txtCode').val(), 'member_id': $('label[name="idMember"]').text(), 'total': $('#txtTotal').val()},
                        ajaxasync: true,
                        success: function (response) {
                            console.log(response['success']);
                            var pinjam_id = response['pinjam_id'];
                            $('tr[name="cartData"]').each(function() {
                                var buku_id = parseInt($(this).find('label[name="idBuku"]').text());
                                var harga = $(this).find('td[name="harga"]').text();
                                var qty = $(this).find('.qty').val();
                                $.ajax({
                                    url: '/pinjam/storepinjamdetails',
                                    type: 'POST',
                                    data: {'_token': $('meta[name="_token"]').attr('content'), 'pinjam_id': pinjam_id, 'buku_id': buku_id, 'harga': harga, 'qty': qty},
                                    ajaxasync: true,
                                    success: function (data) {
                                        console.log(data['success']);
                                    },
                                    failure: function (data) {
                                        Toast.fire({
                                            icon: 'warning',
                                            title: data.responseText
                                        });
                                    },
                                    error: function (data) {
                                        Toast.fire({
                                            icon: 'error',
                                            title: data.responseText
                                        });
                                    }
                                });
                            });
                            
                            qtychanged = false;
                            Toast.fire({
                                icon: 'success',
                                title: 'Successfully submit pinjam buku'
                            });
                            location.reload();
                        },
                        failure: function (response) {
                            Toast.fire({
                                icon: 'warning',
                                title: response.responseText
                            });
                        },
                        error: function (response) {
                            Toast.fire({
                                icon: 'error',
                                title: response.responseText
                            });
                        }
                    });
                }
            });

            $('body').on('click', '.btnSelectMember', function (event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="idm"]').text()).trim();
                var kode = (tr.find('label[name="kodeMember"]').text()).trim();
                var nama = (tr.find('td[name="namaMember"]').text()).trim();
                $('label[name="idMember"]').text(id);
                $('#txtMember').val(kode + ' - ' + nama);
                Toast.fire({
                    icon: 'success',
                    title: 'Member Selected'
                })
                $('#modalMember').modal('hide');
            });

            $('body').on('click', '.btnSelectBuku', function (event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var stok = (tr.find('label[name="stokBuku"]').text()).trim();
                var id = (tr.find('label[name="idb"]').text()).trim();
                var qty = 1;
                if (stok < 1) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Empty Stock!'
                    });
                }
                else {
                    // var rowCount = $('#myTable tr[name="cartData"]').length;
                    $.ajax({
                        url: '/pinjam/storecart',
                        type: 'POST',
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'id': id, 'qty': qty},
                        ajaxasync: true,
                        success: function (data) {
                            // console.log(data);
                            // for(var i = 0; i < data.length; i++) {
                            // $('tbody').append('<tr id="tr_' + data[i].id + '" name="cartData" index="' + rowCount + '">' +
                            //     '<td>' +
                            //         '<input type="checkbox" class="custom-checkbox cekbox" data-id="' + data[i].id + '">' +
                            //     '</td>' +
                            //     '<td>' +
                            //         data[i].kode +
                            //         '<label for="a" name="idCart" style="display:none">' + data[i].id + '</label>' +
                            //         '<label for="b" name="idBuku" style="display:none">' + data[i].buku_id + '</label>' +
                            //     '</td>' +
                            //     '<td>' +
                            //         data[i].judul_buku +
                            //     '</td>' +
                            //     '<td name="harga">' + data[i].harga_sewa + '</td>' +
                            //     '<td name="stok">' + data[i].stok + '</td>' +
                            //     '<td>' +
                            //         '<input type="number" class="qty" value="' + data[i].qty + '" style="width:50px" min=1 max=10>' +
                            //     '</td>' +
                            //     '<td name="subtotal"></td>' +
                            //     '<td>' +
                            //         '<div class="btn-group" role="group" aria-label="Basic example">' +
                            //             '<button type="button" class="btn btn-outline-danger"><i class="fas fa-minus-circle"></i></button>' +
                            //         '</div>' +
                            //     '</td>' +
                            // '</tr>');
                            // }
                            Toast.fire({
                                icon: 'success',
                                title: data['success']
                            });
                            qtychanged = false;
                            $('#modalBuku').modal('hide');
                            refreshGrid();
                        },
                        failure: function (response) {
                            Toast.fire({
                                icon: 'warning',
                                title: response.responseText
                            });
                        },
                        error: function (response) {
                            Toast.fire({
                                icon: 'error',
                                title: response.responseText
                            });
                        }
                    });
                }
            });
            
            // $('#checkBoxAll').click(function () {});
            $('body').on('click', '#checkBoxAll', function () {
                if ($(this).is(":checked")) {
                    $(".cekbox").prop("checked", true)
                }
                else {
                    $(".cekbox").prop("checked", false)
                }
            });

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