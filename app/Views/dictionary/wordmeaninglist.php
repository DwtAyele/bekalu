<?= $this->extend('Views\default') ?>

<?= $this->section('stylesheet') ?>
<style>
    .csv button {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #007bff;
        margin: 0 1px;
        font-size: 18px;
        border-radius: 5px;
    }

    .csv button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .csv button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .csv button:hover span {
        padding-right: 25px;
    }

    .csv button:hover span:after {
        opacity: 1;
        right: 0;
    }

    .center {
        text-align: center;
    }

    .pagination {
        display: inline-block;
    }

    .pagination li {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #007bff;
        margin: 0 1px;
        font-size: 18px;
        border-radius: 5px;
    }

    .pagination li.active {
        background-color: #dee2e6;
        /*#17a2b8, 212529, dee2e6*/
        color: white;
        border: 1px solid #4CAF50;
        border-radius: 5px;
    }

    .pagination li:hover:not(.active) {
        background-color: #ddd;

    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>የቃላት ትርጉም ዝርዝር</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=<?= base_url('home') ?>>Home</a></li>
                    <li class="breadcrumb-item active">የቃላት ትርጉም ዝርዝር</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="container-fluid">
    <div class="row">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-center">
                    <strong>የቃላት ትርጉም ዝርዝር</strong>
                </div>
                <div class="card-header">
                    <form action="<?php echo base_url('wordmeaninglist'); ?>" method="post" enctype="multipart/form-data">
                        <?php $style = 'class="form-control select2" style="width: 100%"'; ?>
                        <div class="row col-12 col-sm-12" style="column-width:100px;">
                            <div class="col-6 col-sm-3">
                                <label>Word - ቃሉ</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="word" value="<?= set_value('word') ?>" size="12" class="form-control" placeholder="ቃሉ - Word" autocomplete="off">
                                    <div class="input-group">
                                        <span class="text-danger"><?= isset($validation) ? $validation->getError('word') : '' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-group">
                                    <label>Dictionary</label>
                                    <?php echo form_dropdown('dictionary_id', $dictionary, set_value('dictionary_id'), $style); ?>
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('dictionary_id') : '' ?></span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-group">
                                    <label>Page Number</label>
                                    <input type="number" name="pagenumber" value="<?= set_value('pagenumber', 0) ?>" class="form-control" id="pagenumber" min="0">
                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('pagenumber') : '' ?></span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="form-group">
                                    <label>Alphabet Order</label>
                                    <?php echo form_dropdown('alphabet_order', $alphabet_order, set_value('alphabet_order'), $style); ?>

                                </div>
                                <div class="input-group">
                                    <span class="text-danger"><?= isset($validation) ? $validation->getError('alphabet_order') : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-grid">
                                <input type="submit" name="submit" value="Search" class="btn btn-dark" />
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-header">
                    <!-- Pagination -->
                    <div class="row" style="column-width:100px;">
                        <div class="col-4 csv">
                            <?php if (isset($pager)) { ?>
                                <form action="" method="post">
                                    <button name="CSV" value="CSV">CSV</button>
                                    <button name="CSVonlythispage" value="CSVonlythispage">CSV Only this Page</button>
                                </form><?php } ?>
                        </div>
                        <div class="col-8 float-right">
                            <div class="float-right" style="color:blue;">
                                <?php if (isset($pager)) {
                                    echo $pager->links();
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">የቃላት ትርጉም፦</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ቃል</th>
                                                <th>ሰዋሰው</th>
                                                <th>ጠብቆና ላልቶ የሚነበብ</th>
                                                <th style="width:35%">ትርጉም</th>
                                                <th style="width:15%">ምሳሌ</th>
                                                <th style="width:10%">ምስል</th>
                                                <th>ተጨማሪ መረጃ</th>
                                                <th>የፊደል ቤት</th>
                                                <th>ገጽ</th>
                                                <th>መዝገበ ቃል</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($meanings as $meaning) : ?>
                                                <tr data-widget="expandable-table" aria-expanded="true">
                                                    <td><?= $meaning->row_num; ?></td>
                                                    <td><?= $meaning->word; ?></td>
                                                    <td><?= $meaning->short_note; ?></td>
                                                    <td>
                                                        <?php if (!empty($meaning->homonyms) && isset($meaning->homonyms) && $meaning->homonyms === "ጠብቆና ላልቶ የሚነበብ") echo 'አው'; ?>
                                                    </td>
                                                    <td><?= $meaning->meaning; ?></td>
                                                    <td><?= $meaning->example; ?></td>
                                                    <td><?php if (isset($meaning->meaning_image) && !empty($meaning->meaning_image)) {
                                                            echo '<div class="image">  <img class="img-fluid" src="' . base_url() . '/public/asset/img/dictionary/' .
                                                                $meaning->meaning_image . '" height= 400px width=286px " alt="Meaning Image"> </div>';
                                                            echo ' </div>';
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $meaning->comment; ?></td>
                                                    <td><?php echo empty($meaning->alphabet_order) ? "" : $meaning->alphabet_order; ?></td>
                                                    <td><?php echo $meaning->page_no; ?></td>
                                                    <td><?php echo $meaning->short_name; ?></td>
                                                    <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('edit') . '/' . $meaning->word_id; ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="row float-right">
                        <?php if (isset($pager)) {
                            echo $pager->links();
                        }
                        ?>
                    </div>
                    <!-- Pagination -->

                </div>
            </div>
        </div>
    </div>

</section>



<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<?= $this->endSection() ?>