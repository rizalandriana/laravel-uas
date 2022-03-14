@if (Route::has('login'))
    @auth

        <!-- Konten -->
        <form id="memberEdit" method="post" action="/member/update/{{ $member->id }}" enctype="multipart/form-data" onsubmit="toastsuccess()">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Data - Member</h5>
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
                                    <!-- <label for="photo">Photo</label> -->
                                    <!-- <input type="file" name="photo" class="form-control-file photo" id="photoEdit" accept=".jpg, .jpeg, .png"> -->
                                    <!-- <input type="file" class="form-control-file" id="file1" accept=".jpg, .jpeg, .png" multiple required> -->
                                </div>
                        </div>
                    </div>
                    <!-- <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div> -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>NIM</label>
                            <input id="kodeEdit" name="kodeEdit" class="form-control" type="text" placeholder="NIM" required readonly value="{{ $member->kode }}">
                            <input type="hidden" id="idEdit" value="{{ $member->id }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="selectKategoriEdit">Kategori</label>
                            <select class="custom-select" id="selectKategoriEdit" name="kategoriEdit" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ $k->id == $member->kategori_id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input id="namaEdit" type="text" name="namaEdit" class="form-control" placeholder="Nama" value="{{ $member->nama }}" required maxlength="30" minlength="3" autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label>HP</label>
                            <input id="hpEdit" type="number" name="hpEdit" class="form-control" placeholder="HP" value="{{ $member->hp }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="emailEdit">Email address</label>
                            <input type="email" class="form-control" id="emailEdit" name="emailEdit" aria-describedby="emailHelp" placeholder="Email" value="{{ $member->email }}">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="alamatEdit">Alamat</label>
                            <textarea class="form-control" id="alamatEdit" name="alamatEdit" rows="3" minlength="10" required>{{ $member->alamat }}</textarea>
                        </div>
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <div class="btn-group" role="group">
                    <button type="button" id="btnSaveEdit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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