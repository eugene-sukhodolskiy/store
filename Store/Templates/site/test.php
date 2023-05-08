<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<div style="margin-top: 100px"></div>

<?= $this -> join("site/components/searchable-dropdown.php", [
	"id" => "test-component",
	"name" => "test",
	"placeholder_text" => "test field",
	"items" => [
		[
			"attrs" => [
				"data-value" => "hello"
			],
			"text" => "<button>hello world</button>"
		],
		[
			"attrs" => [
				"data-value" => "hello2"
			],
			"text" => "<button>hello world again</button>"
		],
		[
			"attrs" => [
				"data-value" => "hello3"
			],
			"text" => "<button>This is result again</button>"
		],
		[
			"attrs" => [
				"data-value" => "hello4"
			],
			"text" => "<button>This world great again</button>"
		],
	],
	"tabindex" => "1"
]) ?>

<script>
	let sd;
	document.addEventListener("DOMContentLoaded", e => {
		sd = new SearchableDropdown(document.querySelector("#test-component"));

		sd.addEventOnChange((dropdown, data) => {
			console.log(data);
		});
	});
</script>