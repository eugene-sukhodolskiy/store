<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h1 class="heading">Новое объявление</h1>
<?= $this -> join("site/components/uadpost/uadpost-form") ?>