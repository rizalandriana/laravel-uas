@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <form id="bukuEdit" method="post" action="/buku/update/{{ $buku->id }}" enctype="multipart/form-data" onsubmit="toastsuccess()">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Data - Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <img id="croppedImageEdit" width="160px" class="rounded" src="{{ $fotosrc }}">
                        </div>
                        <div class="form-row align-items-end">
                                <div class="form-group">
                                    <button type="button" id="btnRemoveFotoOnEdit" class="btn btn-outline-danger"><i class="fas fa-minus-circle"></i></button>
                                </div>
                                &nbsp;
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" name="photoEdit" class="custom-file-input photoEdit" id="photoEdit" accept=".jpg, .jpeg, .png">
                                        <label class="custom-file-label" for="photo">Choose file</label>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIB</label>
                            <input id="kodeEdit" name="kodeEdit" class="form-control" type="text" placeholder="NIB" required readonly value="{{ $buku->kode }}">
                            <input type="hidden" id="idEdit" value="{{ $buku->id }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Judul</label>
                            <input id="judulEdit" type="text" name="judulEdit" class="form-control" placeholder="Judul Buku" value="{{ $buku->judul_buku }}" required maxlength="30" minlength="1" autofocus>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Pengarang</label>
                            <input id="pengarangEdit" type="text" name="pengarangEdit" class="form-control" placeholder="Nama Pengarang" value="{{ $buku->pengarang }}" required maxlength="30" minlength="3">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Penerbit</label>
                            <input id="penerbitEdit" type="text" name="penerbitEdit" class="form-control" placeholder="Penerbit" value="{{ $buku->penerbit }}" required maxlength="30" minlength="3">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tempatEdit">Tempat Terbit</label>
                            <input type="text" class="form-control" id="tempatEdit" name="tempatEdit" placeholder="Tempat Terbit" value="{{ $buku->tempat }}" required maxlength="30" minlength="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tahunEdit">Tahun</label>
                            <input class="date form-control" type="number" id="tahunEdit" name="tahunEdit" value="{{ $buku->tahun }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hargaEdit">Harga Sewa</label>
                            <input type="number" class="form-control" id="hargaEdit" name="hargaEdit" placeholder="Harga Sewa" value="{{ $buku->harga_sewa }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stokEdit">Stock</label>
                            <input type="number" class="form-control" id="stokEdit" name="stokEdit" placeholder="Qty" value="{{ $buku->stok }}" required>
                        </div>
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" id="btnSaveEdit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>
        </form>

<div class="modal fade" id="modalCropEdit" tabindex="-1" role="dialog" aria-labelledby="modalCropEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCropEditLabel">Crop Image</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="imageEdit" class="my-img" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
        <button type="button" class="btn btn-outline-primary" id="cropEdit"><i class="fas fa-crop"></i> Crop</button>
      </div>
    </div>
  </div>
</div>

<script>
            var $modalEdit = $('#modalCropEdit');
            var imageEdit = document.getElementById('imageEdit');
            var cropperEdit;

            $("#tahunEdit").datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });

            $("body").on("change", ".photoEdit", function(e){
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
                        imageEdit.src = url;
                        $modalEdit.modal('show');
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

            $modalEdit.on('shown.bs.modal', function () {
                cropperEdit = new Cropper(imageEdit, {
	            aspectRatio: 1,
	            viewMode: 3,
	            preview: '.preview'
            });
            }).on('hidden.bs.modal', function () {
                cropperEdit.destroy();
                cropperEdit = null;
            });

            $("#cropEdit").click(function(){
                canvasEdit = cropperEdit.getCroppedCanvas({
                    width: 160,
                    height: 160,
                });
                
                canvasEdit.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        base64dataEdit = reader.result;
                        $('#croppedImageEdit').attr('src', base64dataEdit);
                        $modalEdit.modal('hide');
                    }
                });
                photoChanged = 'true';
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