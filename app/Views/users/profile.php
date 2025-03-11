<?= $this->extend('Views\default') ?>
<?= $this->section('content') ?>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=<?= base_url('home') ?>>Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= base_url($image); ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= $firstname . " " . $lastname ?></h3>

                        <p class="text-muted text-center"><?= $role ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Last Login</b> <a class="float-right"><?= $last_login ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right"><?= $email ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Created</b> <a class="float-right"><?= $created_at ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Role</b> <a class="float-right">User Role<?= " { " . $role ." } "?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Dictionary Role</b> <a class="float-right">D. Role<?= " => " . $dictionary_flag ." <= "?></a>
                            </li>
                            <li class="list-group-item">
                                <b>My Wiki</b> <a class="float-right" target = '_blank' href=<?= base_url('mywiki') ?>>MyWiki</a>
                                 
                            </li>
                        </ul>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="active tab-pane" id="settings">
                                <form class="form-horizontal" action="profile" method="post" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="form-group row">
                                        <label for="firstname" class="col-sm-2 col-form-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="firstname" value="<?= set_value('firstname') ?>" size="12" class="form-control" id="firstname" placeholder="First name" autocomplete="off">
                                            <div class="input-group">
                                                <span class="text-danger"><?= isset($validation) ? $validation->getError('firstname') : '' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lastname" class="col-sm-2 col-form-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="lastname" value="<?= set_value('lastname') ?>" size="12" class="form-control" id="lastname" placeholder="Last name" - autocomplete="off">
                                            <div class="input-group">
                                                <span class="text-danger"><?= isset($validation) ? $validation->getError('lastname') : '' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="profilepicture" class="col-sm-2 col-form-label">Profile Picture</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="profilepicture" value="<?= set_value('profilepicture') ?>" class="form-control" id="profilepicture" placeholder="Profile Picture">

                                            <div class="input-group">
                                                <span class="text-danger"><?= isset($validation) ? $validation->getError('profilepicture') : '' ?></span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<?= $this->endSection() ?>