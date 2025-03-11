<?= $this->extend('default') ?>
<?= $this->section('content') ?>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admin Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href=<?= base_url('home') ?>>Home</a></li>
                    <!--li class="breadcrumb-item active">User Profile</li-->
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>





<?= $this->endSection() ?>