<?= $this->extend('default') ?>

<?= $this->section('stylesheet') ?>



<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>የቃል ትርጉም ማስገቢያ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href=<?= base_url('home') ?>>Home</a></li>
                    <li class="breadcrumb-item active">Add meaning</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="container-fluid">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">
                ትርጉሙን ያስገቡ - Add Meaning
            </h3>
        </div>

        <?php if (!empty($meaning_message) && isset($meaning_message)) : ?>
            <?php echo '<p class="alert alert-success alert-dismissible"><i class="icon fa fa-check"></i>'; ?>
            <?php echo $meaning_message . '</p>'; ?>
        <?php endif; ?>

        <!-- /.card-header autofocus -->
        <div class="card-body">
            <?php echo form_open_multipart('addmeaning'); ?>
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-12 col-sm-10">
                    <label>Word - ቃሉ</label>
                    <div class="input-group mb-3">
                        <input type="text" name="word" value="<?= set_value('word') ?>" size="12" class="form-control" placeholder="ቃሉ - Word" autocomplete="off">
                        <div class="input-group">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('word') : '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 float-sm-right">
                    <label>ጠብቆና ላልቶ የሚነበብ</label>
                    <div class="form-check">
                        <input type="checkbox" name="homonyms[]" class="form-check-input" value="Yes" <?php echo set_checkbox('homonyms[]', 'Yes', false); ?> />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Word Usage</label>
                        <?php $style = 'class="form-control select2" style="width: 100%"'; ?>
                        <?php $style1 = 'class="form-control select2 js-example-basic-multiple" multiple="multiple" data-placeholder="Select more" style="width: 100%"'; ?>

                        <?php echo form_dropdown('accessibility', $accessibility, set_value('accessibility'), $style); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('accessibility') : '' ?></span>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Word Language</label>
                        <?php echo form_dropdown('languagefrom', $languages, set_value('languagefrom'), $style); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('languagefrom') : '' ?></span>
                    </div>
                </div>
            </div>
            <label>Word Meaning</label>
            <div class="tab-custom-content">
            </div>
            <div class="input-group mb-3">
                <textarea name="meaning" rows="8" style="width:100%;display:block;" placeholder="ትርጉሙን ያስገቡ - Add Meaning here"><?= trim(set_value('meaning')) ?></textarea>
                <div class="input-group">
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('meaning') : '' ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Meaning Language</label>
                        <?php echo form_dropdown('languageto', $languages, set_value('languageto'), $style); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('languageto') : '' ?></span>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <label>Tag</label>
                    <div class="form-group">
                        <!--select class="js-example-basic-multiple" multiple="multiple" data-placeholder="Select a .." style="width: 100%;"-->
                        <?php echo form_multiselect('tag[]', $tags, $tags_select, $style1); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('tag') : '' ?></span>
                    </div>
                </div>
            </div>
            <label>Meaning example</label>
            <div class="tab-custom-content">
            </div>
            <div class="input-group mb-3">
                <textarea name="example" rows="8" style="width:100%;display:block;" placeholder="ምሳሌ የቃሉን አገባብ በአርፍተ ነገር አሳይ - Type an examples of how it's used in a sentence here"><?= trim(set_value('example')) ?></textarea>
                <div class="input-group">
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('example') : '' ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Dictionary</label>

                        <?php echo form_dropdown('dictionary_id', $dictionary, set_value('dictionary_id'), $style); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('dictionary_id') : '' ?></span>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Word part of speech</label>
                        <?php echo form_dropdown('part_of_speech', $part_of_speech, set_value('part_of_speech'), $style); ?>
                    </div>
                    <div class="input-group">
                        <span class="text-danger"><?= isset($validation) ? $validation->getError('part_of_speech') : '' ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 ">
                    <label for="meaning_image " class="col-sm-2 col-form-label">Image</label>
                    <div class="form-group">
                        <input type="file" name="meaning_image" value="<?= set_value('meaning_image') ?>" class="form-control" id="meaning_image" placeholder="ምስል ያስገቡ">
                        <div class="input-group">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('meaning_image') : '' ?></span>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                </div>
            </div>
            <div class="row float-sm-right">
                <div class="float-sm-right form-group ">
                    <button type="submit" class="btn btn-primary btn-block">submit</button>
                </div>
            </div>
            <!-- /.col -->
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

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