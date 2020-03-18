<div class = "container-fluid">
    <h3><i class="fas fa-edit"></i>EDIT DATA BARANG</h3>

    <?php foreach($pelanggan as $plg): ?>
        <form method="post"action="<?php echo base_url().'admin/data_pelanggan/update' ?>"> <!--memanggil controller admin/data_pelanggans dengan fungsi update-->

        <div class="for-group"> <!--echo $brg ->(nama field) untuk menampilkan datanya-->
                <label>Nama Pelanggan</label>
               <input type="hidden" name="id_plg" class="form-control" value="<?php echo $plg->id_plg ?>">
               <label>Nama Pelanggan</label>
               <input type="text" name="nama_plg" class="form-control" value="<?php echo $plg->nama_plg ?>">

           </div>
           <div class="for-group">
               <label>Alamat</label>
               <input type="text" name="alamat" class="form-control" value="<?php echo $plg->alamat ?>">

           </div>
           <div class="for-group">
               <label>Username</label>
               <input type="text" name="username" class="form-control" value="<?php echo $plg->username ?>">

           </div>
           <div class="for-group">
               <label>Password</label>
               <input type="text" name="password" class="form-control" value="<?php echo $plg->password ?>">

           </div>
           
           <button type="submit" class="btn btn-primary btn-sm">Simpan</button>

        </form>


        <?php endforeach;?>
</div>