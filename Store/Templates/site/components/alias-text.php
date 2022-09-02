<script>
	const ALIASTEXT = JSON.parse(`<?= json_encode(FCONF["text_msgs"]) ?>`);
	const _atxt = (alias) => ALIASTEXT[alias];
</script>