<?php
include_once('db.php');
include_once('function.php');
include_once('templates/header.php');
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    $data = query("SELECT * FROM users WHERE id = '$id_user'")
    [0];
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
if (isset($_POST['simpan'])) {
    if (ubah_user($_POST) > 0) {
?>
        <div class="alert alert-success" role="alert">
            Data berhasil disimpan!
        </div>
    <?php
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Data gagal diubah!
        </div>
<?php
    }
}
?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Incomes
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <input type="hidden" name="id_user" value="<?= $id_user ?>">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
        <label for="username">Username</label>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="username" name="username" value="<?= $data['username'] ?>">
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
        <label for="gambar">Unggah Foto</label>
          <input type="file" class="custom-file-input" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="gambar" id="gambar" required>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="simpan">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php
include_once('templates/footer.php');
?>