@extends('welcome')

@section('title', 'Pengembalian Buku')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Pengembalian Buku</h5>
                </div>
                <div class="card-body">
                    {{ method_field('PUT') }}
                    <table id="myTablePinjam" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Member</th>
                                <th>Tgl Pinjam</th>
                                <th>Duedate</th>
                                <th>Total</th>
                                <th>Tgl Kembali</th>
                                <th>Denda</th>
                                <th>Bayar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjam as $p)
                            <tr id="tr_{{$p->id}}">
                                <td>
                                    {{ $p->kode }}
                                    <label for="a" name="idp" style="display:none">{{ $p->id }}</label>
                                    @if (empty($p->kembali->id))
                                    <label for="d" name="idk" style="display:none"></label>
                                    @else
                                    <label for="d" name="idk" style="display:none">{{ $p->kembali->id }}</label>
                                    @endif
                                </td>
                                <td>
                                    <label for="b" name="kodeMember">{{ $p->member->kode }}</label> - <label for="c" name="namaMember">{{ $p->member->nama }}</label>
                                </td>
                                <td>{{ $p->tgl }}</td>
                                <td>{{ $p->duedate }}</td>
                                <td>{{ $p->total }}</td>
                                @if (empty($p->kembali->id))
                                <td><span class="badge badge-pill badge-danger">Pending</span></td>
                                <td><span class="badge badge-pill badge-danger">No Data</span></td>
                                <td><span class="badge badge-pill badge-danger">No Data</span></td>
                                @else
                                <td>{{ $p->kembali->tgl }}</td>
                                <td>{{ $p->kembali->denda }}</td>
                                <td>{{ $p->kembali->bayar }}</td>
                                @endif
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btnViewDetail"><i class="fas fa-search"></i></button>
                                        <button type="button" class="btn btn-outline-primary btnAccept"><i class="fas fa-arrow-circle-right"></i></button>
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
    <!-- Modal untuk Search Member -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="divDetail">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Search Buku -->
    <div class="modal fade" id="modalAccept" tabindex="-1" role="dialog" aria-labelledby="modalAcceptTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="divAccept">
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')

        <script>

            $(document).ready( function () {
                $('#myTablePinjam').DataTable({
                    "scrollX": true
                });
            });

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

            // $('td').click(function(event){
            //     event.preventDefault();
            //     var obj = $(this);
            //     viewdetail(obj);
            // });

            $('.btnViewDetail').click(function(event) {
                event.preventDefault();
                var obj = $(this);
                viewdetail(obj);
            });

            function viewdetail(obj) {
                // var row_index = $(this).parent().index();
                // var col_index = $(this).index();
                // var td_length = $('td').length;
                var tr = obj.closest('tr');
                var id = (tr.find('label[name="idp"]').text()).trim();
                var route = '/kembali/pinjamdetail/' + id;
                $('#divDetail').load(route);
                $('#modalDetail').modal('show');
            }

            $('.btnAccept').click(function(event) {
                event.preventDefault();
                var tr = $(this).closest('tr');
                var id = (tr.find('label[name="idp"]').text()).trim();
                var route = '/kembali/accept/' + id;
                $('#divAccept').load(route);
                $('#modalAccept').modal('show');
            });

            $('body').on('click', '#btnSaveAccept', function() {
                if (confirm('Sure to accept this transaction?')) {
                    var id = parseInt($('label[name="idpp"]').text());
                    var denda = parseFloat($('#txtDenda').val());
                    var bayar = parseFloat($('#txtBayar').val());
                    $.ajax({
                        url: '/kembali/store',
                        type: 'POST',
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'id': id, 'denda': denda, 'bayar': bayar},
                        ajaxasync: true,
                        success: function (response) {
                            // console.log(response['success']);
                            Toast.fire({
                                icon: 'success',
                                title: response['success']
                            });
                            location.reload();
                        },
                        failure: function (response) {
                            // console.log(response.responseText);
                            Toast.fire({
                                icon: 'warning',
                                title: response.responseText
                            });
                        },
                        error: function (response) {
                            // console.log(response.responseText);
                            Toast.fire({
                                icon: 'error',
                                title: response.responseText
                            });
                        }
                    });
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