@extends('welcome')

@section('title', 'Kas')

@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@if (Route::has('login'))
    @auth

    @section('konten')
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Report Kas Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="text-left">
                                <h3><label><i class="fas fa-dollar-sign"></i> Total:&nbsp;</label><label id="totalKas"></label></h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <button class="btn btn-outline-secondary" onclick="window.open('/kas/cetakpdf');"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
                    <table id="myTableKas" class="table table-bordered table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>ID Pinjam</th>
                                <th>Member</th>
                                <th>Tgl Pinjam</th>
                                <th>Duedate</th>
                                <th>Tgl Kembali</th>
                                <th>Total</th>
                                <th>Denda</th>
                                <th>Bayar</th>
                                <th>Kas</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kembali as $k)
                            <tr id="tr_{{$k->id}}" name="kasData">
                                <td>
                                    {{ $k->pinjam->kode }}
                                    <label for="a" name="idp" style="display:none">{{ $k->pinjam_id }}</label>
                                    <label for="d" name="idk" style="display:none">{{ $k->id }}</label>
                                </td>
                                <td>
                                    <label for="b" name="kodeMember">{{ $k->pinjam->member->kode }}</label> - <label for="c" name="namaMember">{{ $k->pinjam->member->nama }}</label>
                                </td>
                                <td>{{ $k->pinjam->tgl }}</td>
                                <td>{{ $k->pinjam->duedate }}</td>
                                <td>{{ $k->tgl }}</td>
                                <td>{{ $k->pinjam->total }}</td>
                                <td>{{ $k->denda }}</td>
                                <td name="bayar">{{ $k->bayar }}</td>
                                <td name="kas"></td>
                                <!-- <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary btnViewDetail"><i class="fas fa-book-reader"></i></button>
                                        <button type="button" class="btn btn-outline-secondary btnAccept"><i class="fas fa-search"></i></button>
                                    </div>
                                </td> -->
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
    @endsection

    @section('script')

        <script>

            $(document).ready( function () {
                $('#myTableKas').DataTable({
                    "scrollX": true
                });

                calculate();
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

            $('td').click(function(event){
                event.preventDefault();
                var obj = $(this);
                viewdetail(obj);
            });

            // $('.btnViewDetail').click(function(event) {
            //     event.preventDefault();
            //     var obj = $(this);
            //     viewdetail(obj);
            // });

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

            function calculate() {
                var kas = 0;
                $('tr[name="kasData"]').each(function () {
                    var tr = $(this).closest('tr');
                    var bayar = parseFloat(tr.find('td[name="bayar"]').text());
                    kas += bayar;
                    tr.find('td[name="kas"]').text(kas);
                });
                $('#totalKas').text(kas);
            };

            // $('.btnAccept').click(function(event) {
            //     event.preventDefault();
            //     var tr = $(this).closest('tr');
            //     var id = (tr.find('label[name="idp"]').text()).trim();
            //     var route = '/pinjam/reportdetail/' + id;
            //     $('#divAccept').load(route);
            //     $('#modalAccept').modal('show');
            // });

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