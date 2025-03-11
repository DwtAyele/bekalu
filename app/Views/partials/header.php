<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= csrf_meta() ?>
  <title><?= $title ?></title>
  <link rel="icon" type="image/x-icon" href="<?= base_url('public/asset/img/kal.ico'); ?>">
  
  <meta name="author" content="Dawit Ayele"> 
  <meta name="description" content="Amharic Dictionary. የአማርኛ መዝገበ ቃላት.">
  <meta name="keywords" content="Amharic Dictionary, Amharic Translator, አማርኛ, Amharic, የአማርኛ መዝገበ ቃላት, መዝገበ ቃላት, ቃል, ቃላት, የቃላት ትርጉም, Geez, Learn Amharic, Amharic Search, Geez-Amharic">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- overlayScrollbars-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.3/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('public/asset/adminlte/adminlte.min.css'); ?>">


  <?= $this->renderSection('stylesheet') ?>

</head>