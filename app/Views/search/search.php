<?= $this->section('stylesheet') ?>
<style>
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
        font-size: 22px;
        border-radius: 5px;
    }

    .pagination li.active {
        background-color: #fff;
        color: white;
        border: 1px solid #007bff;
        border-radius: 5px;
    }

    .pagination li:hover:not(.active) {
        background-color: #ddd;

    }

    .button {
        background-color: white;
        color: #007bff;
        border: 2px solid #fff;
        border-radius: 12px;
    }

    .button:hover {
        background-color: #4CAF50;
        color: white;
    }

    .active {
        background-color: #fff;
        color: #4CAF50;
        border: 1px solid #007bff;
    }

    .btn:focus {
        outline: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->include('partials/header') ?>

<body>
    <!-- Site wrapper layout-boxed -->
    <div class="wrapper breadcrumb">

        <div class="container-fluid">
            <h2 class="text-center display-4"><a href=<?= base_url() ?>>መዝገበ ቃላት</a></h2>
            <?= isset($validation) ? $validation->getErrors() : '' ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="<?= base_url('search') ?>" method="get">
                        <!-- results ,'Type your keywords here'-->
                        <div class="input-group">
                            <input type="search" name="searctext" value="<?= set_value('searctext') ?>" size="60" class="form-control form-control-lg">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                                <span class="text-danger"><?= isset($validation) ? $validation->getError('searctext') : '' ?></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2"> </div>
                <div class="col-sm-8 mt-3">
                    <div class="row">
                        <?php if (isset($pager)) {
                            echo '<h3> ' . $pager->Links() . '</h3>';
                        } ?>
                    </div>
                    <div class="post ">
                        <?php foreach ($meanings as $meaning) : ?>
                            <div class="col-lg-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <div class="row mt-o mb-0">
                                            <div class="col-sm-9">
                                                <h1 class="mt-o mb-0 ml-4 text-primary">
                                                    <a href="<?php echo site_url('kalat?searctext=' . $meaning->word); ?>"><?php echo $meaning->word;
                                                                                                                            ?></a>
                                                </h1>
                                            </div>
                                            <div class="mt-o mb-0 col-sm-3">
                                                <ol class="float-right">
                                                    <i class="fa fa-clock-o mr-1"> <?php echo $meaning->created_at->humanize(); ?></i>
                                                </ol>
                                            </div>
                                        </div>
                                        <blockquote class="quote-secondary  mt-0 mb-0">
                                            <p class="mt-o mb-0">
                                                <?php if (!empty($meaning->part_of_speech) && isset($meaning->part_of_speech))
                                                    echo '<abbr title=' . $meaning->part_of_speech . '>'; ?>
                                                <?php if (!empty($meaning->abbreviation) && isset($meaning->abbreviation))
                                                    echo $meaning->abbreviation . '</abbr>&emsp;|&nbsp;'; ?>

                                                <?php if (!empty($meaning->pronunciation) && isset($meaning->pronunciation))
                                                    echo '<abbr title= "አነባበቡ"><u>' . $meaning->pronunciation . '</u></abbr>&emsp;|&nbsp;'; ?>
                                                <?php if (!empty($meaning->homonyms) && isset($meaning->homonyms) && $meaning->homonyms === "ጠብቆና ላልቶ የሚነበብ")
                                                    echo '<a href="#"><abbr title= "ቃሉን በማጥበቅና በማላላት የተለያየ ትርጉም ይሰጣል"><u>' . $meaning->homonyms . '</u></abbr>&emsp;|&nbsp;</a>'; ?>
                                                <?php if (isset($meaning->accessibility) && $meaning->accessibility != 0)
                                                    echo '<abbr title= "ተደራሽነቱ"><u>' . $meaning->accessibility . '</u></abbr>&emsp;'; ?>
                                            </p>
                                        </blockquote>
                                        <blockquote class="mt-0 mb-0">
                                            <div class="meaning_text row mt-0 mb-0">
                                                <p class="meaning_text card-text mt-0 mb-0 " id="meaning_text">
                                                    <?php if (isset($meaning->short_name) && !empty($meaning->short_name)) //echo '<u>' . $meaning->short_name . '</u>'; ?>
                                                    <?php if (isset($meaning->meaning) && !empty($meaning->meaning)) echo '<b><u>ትርጉሙ፦</b></u>' . $meaning->meaning; ?>
                                                </p>
                                            </div>
                                        </blockquote>
                                        <blockquote class="quote-secondary mt-0 mb-0">
                                            <div class="row mt-0 mb-0">

                                                <?php if (isset($meaning->example) && !empty($meaning->example))
                                                    echo '<div class="col-sm-8 mt-0 mb-0"><p class="card-text mt-0 mb-0"><b><u>ምሳሌ፦</u><br></b>' . $meaning->example . '</p></div>'; ?>
                                                <?php if (isset($meaning->meaning_image) && !empty($meaning->meaning_image)) {
                                                    echo '<div class="col-sm-4 mt-0 mb-0">';
                                                    echo '<div class="image">  <img class="img-fluid" src="' . base_url('public/asset/img/dictionary') . '/' .
                                                        $meaning->meaning_image . '" height= 400px width=286px " alt="Meaning Image"> </div>';
                                                    echo ' </div>';
                                                } ?>

                                            </div>
                                        </blockquote>
                                        <blockquote class="mt-0 mb-0">
                                            <?php $tags = $wordtags->getwordtags('wmt.word_meaning_id = ' . $meaning->word_meaning_id);
                                            foreach (array_keys($tags) as $tag) {
                                                echo $tag . '&emsp;';
                                            }
                                            ?>
                                        </blockquote>
                                        <h5 class="mt-0 mb-0">
                                            <p class="text-primary ml-3 mt-0 mb-1"> by <a href="#"><?php //echo $meaning->email; 
                                                                                                    ?> </a>
                                                <span class=" time"><i class="fa fa-clock"></i> </span>
                                            </p>
                                        </h5>
                                        <form action="" method="post">
                                            <div class="row mt-0 mb-0">
                                                <div class="col-sm-6">


                                                    <button class="button <?php if (isset($like) && $meaning->word_meaning_id == $id_) echo $like; ?>" value="<?= $meaning->num_like ?>,<?= $meaning->word_meaning_id ?>,<?= $session_for ?>" name="like" formmethod="post">
                                                        <i class="fa fa-thumbs-up " style="font-size:26px">
                                                            <?php if ($meaning->num_like != 0) echo $meaning->num_like; ?>
                                                        </i>
                                                    </button>

                                                    <button class="button <?php if (isset($dislike) && $meaning->word_meaning_id == $id_) echo $dislike; ?>" value="<?= $meaning->num_dislike ?>,<?= $meaning->word_meaning_id ?>,<?= $session_for ?>" name="dislike" formmethod="post">
                                                        <i class="fa fa-thumbs-down fa-flip-horizontal" style="font-size:26px"></i>
                                                        <i style="font-size:26px">
                                                            <?php if ($meaning->num_dislike != 0) echo $meaning->num_dislike; ?></i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="float-right">
                                                        <a href="<?php echo site_url('kalat?searctext=' . $meaning->word . '&wm_id=' . $meaning->word_meaning_id); ?>">
                                                            <abbr title="ትርጉሙን ያጋሩ"><i class="fa fa-share" style="font-size:26px"></i></abbr></a> |
                                                        <!-- <a href="#">
                                                        <abbr title="የተሳሳተ / ያልተገባ ትርጉም"><i class="fa fa-bug mr-3" aria-hidden="true" style="font-size:26px"></i></abbr></a>
                                                    i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:26px"></i-->
                                                        <button class="button" value="<?= $meaning->user_report ?>,<?= $meaning->word_meaning_id ?>" name="user_report" formmethod="post">
                                                            <abbr title="የተሳሳተ / ያልተገባ ትርጉም"><i class="fa fa-bug" aria-hidden="true" style="font-size:26px"></i></abbr>
                                                        </button>
                                                    </ol>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.card -->
                        <?php endforeach; ?>
                        <div id="center">
                            <div class="row">
                                <?php if (isset($pager)) {
                                    echo '<h3> ' . $pager->Links() . '</h3>';
                                } ?>
                            </div>
                        </div>

                    </div>
                    <!-- /.col-md-6 -->

                </div>
                <div class="col-sm-2"> </div>
            </div>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">

                <b>Version</b> <?= esc($etkalversion) ?>
            </div>
            <strong>Copyright &copy; <?= $copyright ?> <a href=<?= base_url('kalat') ?>> <?= $short_name ?> </a>.</strong> All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <script>

    </script>
</body>

</html>