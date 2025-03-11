<?= $this->extend('Views/default') ?>
<?= $this->section('stylesheet') ?>


<?= $this->endSection() ?>
<?= $this->section('content') ?>


<!-- Content Wrapper. Contains page content -->
<div class="content mb-2">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Word Meaning</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=<?= base_url('home') ?>>Home</a></li>
                        <li class="breadcrumb-item"><a href=<?= base_url('wordmeaninglist') ?>>
                                <?php if (isset($Breadcrumbs))   echo $Breadcrumbs;  ?></a></li>
                        <li class="breadcrumb-item active">Edit Word Meaning</li>
                    </ol>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo form_open_multipart('update'); ?>
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Word</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="word">ቃሉ</label>
                                    <input type="text" name="word" id="word" class="form-control" value="<?= set_value('word', $word) ?>" autocomplete="off">
                                    <div class="input-group">
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('word') : '' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pronunciation">አነባነቡ</label>
                                    <input type="text" name="pronunciation" id="word" class="form-control" value="<?= set_value('pronunciation', $pronunciation) ?>" autocomplete="off">
                                    <div class="input-group">
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('pronunciation') : '' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="accessibility">ተደራሽነት</label>
                                    <?php $style = 'class="form-control select2" style="width: 100%"'; ?>
                                    <?php echo form_dropdown('accessibility', $accessibility, set_value('accessibility', $accessibility2), 'class="form-control custom-select"'); ?>
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('accessibility') : '' ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="languagefrom">ቋንቋ</label>
                                    <?php echo form_dropdown('languagefrom', $languages, set_value('languagefrom', $languagefrom_id), 'class="form-control custom-select"'); ?>
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('languagefrom') : '' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="short_note">አጭር መግለጫ</label>
                                    <input type="text" name="short_note" id="short_note" class="form-control" value="<?= set_value('short_note', $short_note) ?>" autocomplete="off">
                                    <div class="input-group">
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('short_note') : '' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ትርጉም</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meaning">ትርጉሙ</label>
                            <textarea name="meaning" id="meaning" class="form-control" rows="3"><?= set_value('meaning', $meaning) ?></textarea>
                        </div>
                        <div class="input-group">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('meaning') : '' ?></span>
                        </div>


                        <div class="form-group">
                            <label for="example">ምሳሌ</label>
                            <textarea name="example" id="example" class="form-control" rows="3"><?= set_value('example', $example) ?></textarea>
                        </div>
                        <div class="input-group">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('example') : '' ?></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="homonyms">ጠብቆና ላልቶ</label>
                                    <?php $options = [0 => 'Select one', 'ጠብቆና ላልቶ የሚነበብ' => 'ጠብቆና ላልቶ የሚነበብ', 'ጠብቆና ላልቶ አይነበብም' => 'ጠብቆና ላልቶ አይነበብም'] ?>
                                    <?php echo form_dropdown('homonyms', $options, set_value('homonyms', $homonyms2), 'class="form-control custom-select"'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pspeech">ሰዋሰው</label>
                                    <?php echo form_dropdown('part_of_speech', $part_of_speech, set_value('part_of_speech', $part_of_speech2), 'class="form-control custom-select"'); ?>
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('part_of_speech') : '' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="languageto">የትርጉሙ ቋንቋ</label>
                                    <?php echo form_dropdown('languageto', $languages, set_value('languageto', $languageto_id), 'class="form-control custom-select"'); ?>
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('languageto') : '' ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="meaning_image">ምስል</label>
                                    <input type="file" name="meaning_image" id="meaning_image" class="form-control" value="<?= set_value('meaning_image', $meaning_image) ?>">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('meaning_image') : '' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>የፊደል ቤት</label>
                                    <input type="text" name="alphabet_order" id="alphabet_order" maxlength="1" size="1" class="form-control" value="<?= set_value('alphabet_order', $alphabet_order) ?>" autocomplete="off">
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('alphabet_order') : '' ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mflag">Flag</label>
                                    <input type="number" name="mflag" id="mflag" class="form-control" value="<?= set_value('mflag', $mflag) ?>" min="0" step="1">
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('mflag') : '' ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="card card-info col-md-6">
                <div class="card-header">
                    <h3 class="card-title">Tags</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <?php $style1 = 'class="form-control select2 js-example-basic-multiple" multiple="multiple" data-placeholder="Select more" style="width: 100%"'; ?>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>File Size</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Functional-requirements.docx</td>
                                <td>49.8005 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            <tr>
                                <td>UAT.pdf</td>
                                <td>28.4883 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            <tr>
                                <td>Email-from-flatbal.mln</td>
                                <td>57.9003 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            <tr>
                                <td>Logo.png</td>
                                <td>50.5190 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            <tr>
                                <td>Contract-10_12_2014.docx</td>
                                <td>44.9715 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>

                        </tbody>
                    </table>
                    <label>Tag</label>
                    <div class="form-group">
                        <!--select class="js-example-basic-multiple" multiple="multiple" data-placeholder="Select a .." style="width: 100%;"-->
                        <?php echo form_multiselect('tag[]', $tags, $tags_select, $style1); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('tag') : '' ?></span>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Dictionary</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="short_name">መዝገበ ቃሉ</label>
                            <?php echo form_dropdown('dictionary', $dictionary, set_value('dictionary', $dictionary_id), 'class="form-control custom-select"'); ?>
                            <div class="input-group">
                                <span class="text-danger"><?= isset($validation) ? $validation->getError('dictionary') : '' ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="page_no">ገጽ</label>
                                    <input type="text" name="page_no" id="page_no" class="form-control" value="<?= set_value('page_no', $page_no) ?>">
                                    <div class="input-group">
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('page_no') : '' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="user_report">የተጠቃሚ ጥቆማ</label>
                                    <input type="number" name="user_report" id="user_report" class="form-control" value="<?= set_value('user_report', $user_report) ?>" min="0" step="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="num_like">የተወደደው</label>
                                    <input type="number" name="num_like" id="num_like" class="form-control" value="<?= set_value('num_like', $num_like) ?>" min="0" step="1">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="num_dislike">ያልተወደደው</label>
                                    <input type="number" name="num_dislike" id="num_dislike" class="form-control" value="<?= set_value('num_dislike', $num_dislike) ?>" min="0" step="1">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">ማስታወሻ</label>
                            <input type="text" name="comment" id="comment" class="form-control" value="<?= set_value('comment', $comment) ?>">
                            <div class="input-group">
                                <span class="text-danger"><?= isset($validation) ? $validation->getError('comment') : '' ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>

        </div>

        <div class="row mb-2">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Words</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <form action="" method="post">
                    <?= $table; ?>
                </form>
            </div>
        </div>
        </br>
        <?php echo form_close(); ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: 'Please select',
            theme: "classic",
            width: 'resolve',
        });
        $('.js-example-basic-multiple').select2({
            theme: 'classic',
            placeholder: 'Select an option',
            width: '100%',
            dropdownAutoWidth: true,
            tags: true,
            tokenSeparators: [',', ' '],
        });

    });
</script>

<?= $this->endSection() ?>