@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <form id="bukuTambah" method="post" action="/buku/store" enctype="multipart/form-data" onsubmit="toastsuccess()">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahTitle">Tambah Data - Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <img id="croppedImage" width="160px" class="rounded" src="/data_file/book_cover.png">
                        </div>
                        <div class="form-row align-items-end">
                                <div class="form-group">
                                    <button type="button" id="btnRemoveFotoOnTambah" class="btn btn-outline-danger btnRemove"><i class="fas fa-minus-circle"></i></button>
                                </div>
                                &nbsp;
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="photo" class="custom-file-input photo" id="photo" accept=".jpg, .jpeg, .png">
                                        <label class="custom-file-label" for="photo">Choose file</label>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIB</label>
                            <input id="kode" name="kode" class="form-control" type="text" placeholder="NIB" required readonly value="{{ $kode }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Judul</label>
                            <input id="judul" type="text" name="judul" class="form-control" placeholder="Judul Buku" value="{{ old('judul') }}" required maxlength="30" minlength="1" autofocus>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Pengarang</label>
                            <input id="pengarang" type="text" name="pengarang" class="form-control" placeholder="Nama Pengarang" value="{{ old('pengarang') }}" required maxlength="30" minlength="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Penerbit</label>
                            <input id="penerbit" type="text" name="penerbit" class="form-control" placeholder="Penerbit" value="{{ old('penerbit') }}" required maxlength="30" minlength="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tempat">Tempat Terbit</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Tempat Terbit" value="{{ old('tempat') }}" required maxlength="30" minlength="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tahun">Tahun</label>
                            <input class="date form-control" type="number" id="tahun" name="tahun" value="{{ old('tahun') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="harga">Harga Sewa</label>
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Sewa" value="{{ old('harga') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stok">Stock</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="Qty" value="{{ old('stok') }}" required>
                        </div>
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" id="btnSave" class="btn btn-outline-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </form>

<div class="modal fade" id="modalCrop" tabindex="-1" role="dialog" aria-labelledby="modalCropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCropLabel">Crop Image</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" class="my-img" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
        <button type="button" class="btn btn-outline-primary" id="crop"><i class="fas fa-crop"></i> Crop</button>
      </div>
    </div>
  </div>
</div>

<script>
            var $modal = $('#modalCrop');
            var image = document.getElementById('image');
            var cropper;

            $("#tahun").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });

            $("body").on("change", ".photo", function(e){
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

                const allowedExtensions =  ['jpg','jpeg','png'],
                sizeLimit = 1000000; // 1 megabyte
  
                // destructuring file name and size from file object
                const { name:fileName, size:fileSize } = this.files[0];
  
                /*
                * if the filename is apple.png, we split the string to get ["apple","png"]
                * then apply the pop() method to return the file extension (png)
                *
                */
                const fileExtension = fileName.split(".").pop();
  
                /* 
                * check if the extension of the uploaded file is included 
                * in our array of allowed file extensions
                */
                if(!allowedExtensions.includes(fileExtension)){
                    // alert("Please upload only jpg, jpeg and png file!");
                    Toast.fire({
                        icon: 'warning',
                        title: "Please upload only jpg, jpeg and png file!"
                    });
                    this.value = null;
                    return false;
                }else if(fileSize > sizeLimit){
                    // alert("File size too large!")
                    Toast.fire({
                        icon: 'warning',
                        title: "File size too large!"
                    });
                    this.value = null;
                    return false;
                }else{
                    var files = e.target.files;
                    var done = function (url) {
                        image.src = url;
                        $modal.modal('show');
                    };
                    var reader;
                    var file;
                    var url;

                    if (files && files.length > 0) {
                        file = files[0];

                        if (URL) {
                            done(URL.createObjectURL(file));
                        } else if (FileReader) {
                            reader = new FileReader();
                            reader.onload = function (e) {
                                done(reader.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                    return true;
                }    
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
	            aspectRatio: 1,
	            viewMode: 3,
	            preview: '.preview'
            });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $("#crop").click(function(){
                canvas = cropper.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });
                
                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        base64data = reader.result;
                        $('#croppedImage').attr('src', base64data);
                        $modal.modal('hide');
                    }
                });
            });
</script>

    @else
        
            <div class="alert alert-danger" role="alert">
                You don't have any access!
            </div>
        
        @if (Route::has('register'))

        @endif
    @endauth
@endif