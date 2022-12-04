<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<h1 class="heading">Оформление покупки</h1>
<?= $this -> join("site/components/order/order-form.php", [
	"uadpost" => $uadpost
]) ?>