

<?php $__env->startSection('content'); ?>
<div class="col-lg grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Departemen</h4>
        <p class="card-description">
          Add class <code>.table-hover</code>
        </p>
        <div class="btn-group float-sm-right">
            <button type="button" class="btn btn-success waves-effect waves-light m-1" data-toggle="modal" data-target="#modaltambah"> <i class="fa fa fa-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width:5px;">No</th>
                    <th>Nama Departemen</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                <?php $__currentLoopData = $departemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i); ?></td>
                    <td><?php echo e($dep->nama_departemen); ?></td>
                   
                    <td style="text-align:center;">
                    <button type="button"  class="btn btn-warning waves-effect waves-light btn-edit" data-toggle="modal" data-target="#modalubah" data-id="<?php echo e($dep->id_departemen); ?>">  Ubah</button>
                    <button type="button"  class="btn btn-danger waves-effect waves-light btn-delete" data-id="<?php echo e($dep->id_departemen); ?>"> Hapus</button>
                    </td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade" id="modaltambah">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Tambah Data Departemen Baru</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <form method="POST" name="tbhDepartemen" action="<?php echo e(route('departemen.tambah')); ?>">
              <?php echo e(csrf_field()); ?>

              <div class="form-group">
                  <label for="input-1">Nama Departemen<span style="color: #ff5252;">*</span></label>
                  <input type="text" class="form-control" id="input-1" required name="nama_departemen" placeholder="Nama Departemen....">
              </div>

              <small style="color: #ff5252;">* Wajib Diisi</small>
              <div class="btn-group float-sm-right mt-2">
                  <button onclick="validateForm('ubhDepartemen','nama_departemen')" type="submit" class="btn btn-success px-5">Simpan</button>
              </div>
          </form>
      </div>
  </div>
  </div>
</div>

<div class="modal fade" id="modalubah">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Ubah Data Departemen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form method="POST" name="ubhDepartemen" action="<?php echo e(route('departemen.ubah')); ?>">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="id_departemen" value="<?php echo e($dep->id_departemen); ?>">
                <div class="form-group">
                    <label for="input-11">Nama Departemen<span style="color: #ff5252;">*</span></label>
                    <input type="text" class="form-control" required value="<?php echo e($dep->nama_departemen); ?>" id="input-11" name="nama_departemen_ubah" placeholder="Nama Departemen....">
                </div>
                <small style="color: #ff5252;">* Wajib Diisi</small>
                <div class="btn-group float-sm-right mt-2">
                    <button onclick="validateForm('ubhDepartemen','nama_departemen_ubah')" type="submit" class="btn btn-warning px-5">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    </div>
  </div>




  
<!-- End Modal -->


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script>
//   $('#default-datatable').DataTable();

  function validateForm($formx, $inpux){

      $inputs = $inpux.split(';');
      $valid = true;

      for (let i = 0; i < $inputs.length; i++) {
          
          $isi = document.forms[$formx][$inputs[i]].value;
          if ($isi == "") {
              alert($inputs[i].toUpperCase()+" tidak boleh kosong!");
              $loader = false;
              return false;
          }
      }

      if($valid){
          pageloader();
      }

  }

  function ubah($id_departemen) {
      $.ajax({
          url: "<?php echo e(url('get_ubah_departemen')); ?>/"+$id_departemen,
          type: 'get',
          dataType: 'json',
          success: function(res){
            // alert($re);
            
              $('id_departemen').val($id_departemen);
              $('input[name*="nama_departemen_ubah"]').val(res['nama_departemen']);
          }
      });
  }


  function hapus($id_departemen){
    swal({ 
    title: "Apakah anda yakin?",
    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location.href="<?php echo e(url('hapus_departemen')); ?>/"+$id_departemen;
            pageloader();
        } 
    });
}

  $( ".btn-edit" ).each(function(index) {
    $(this).on("click", function(){
       ubah($(this).data('id'));
    });
});

$( ".btn-delete" ).each(function(index) {
    $(this).on("click", function(){
       hapus($(this).data('id'));
    });
});

// function hapus($id_departemen){
//     Swal.fire({ 
//       title: "Apakah anda yakin?",
//       text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
//       icon: "warning",
//       buttons: true,
//       dangerMode: true,
//       }).then((result) => {
//           if (result.isConfirmed) {
//             //   pageloader();
//               console.log('test');
//               $.ajax({
                    
//                 url: "<?php echo e('hapus_departemen'); ?>/"+$id_departemen;
//                 type: "DELETE"
//                 cache: false;
//                 data: {
//                         "_token": token
//                     },
//                     success:function(response){
//                         Swal.fire({
//                             type: 'success',
//                             icon: 'success',
//                             title: `${response.message}`,
//                             showConfirmButton: false,
//                             timer: 3000
//                     });

//                     $(`#index_${$id_departemen}`).remove();
//                  }
//               })
//           } 
//       });
//   }

//   function hapus($id_departemen){
//     Swal.fire({
//             title: 'Apakah Kamu Yakin?',
//             text: "ingin menghapus data ini!",
//             icon: 'warning',
//             showCancelButton: true,
//             cancelButtonText: 'TIDAK',
//             confirmButtonText: 'YA, HAPUS!'
//         }).then((result) => {
//             if (result.isConfirmed) {

//                 console.log('test');

//                 //fetch to delete data
//                 $.ajax({

//                     url: `/posts/${post_id}`,
//                     type: "DELETE",
//                     cache: false,
//                     data: {
//                         "_token": token
//                     },
//                     success:function(response){ 

//                         //show success message
//                         Swal.fire({
//                             type: 'success',
//                             icon: 'success',
//                             title: `${response.message}`,
//                             showConfirmButton: false,
//                             timer: 3000
//                         });

//                         //remove post on table
//                         $(`#index_${post_id}`).remove();
//                     }
//                 });

                
//         )}
                
//             }

//   }
   
  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SMT 10\TA\Program\cobabaru\blog\resources\views/departemen.blade.php ENDPATH**/ ?>