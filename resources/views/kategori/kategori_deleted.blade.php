<!-- Gak dipakai! -->

@extends('welcome')

<!-- @section('title', 'Kategori Member (Dihapus)') -->

@if (Route::has('login'))
    @auth

    @section('modal')
    
    @endsection

    @section('script')
        <script>
            $(document).ready( function () {
            $('#myTable').DataTable();
            } );
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