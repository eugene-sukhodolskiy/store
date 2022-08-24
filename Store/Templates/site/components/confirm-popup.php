<div class="component confirm-popup">
	<div class="popup-card">
		<button class="std-btn btn-popup-close">
			<span class="mdi mdi-close"></span>
		</button>

		<div class="header">
			<h3 class="heading"></h3>
		</div>
		<div class="body"></div>
		<div class="control">
			<button class="std-btn btn-primary apply"></button>
			<button class="std-btn btn-default cancel"></button>
		</div>
	</div>
	<div class="popup-back-blur"></div>
</div>

<script src="/Store/Resources/js/ConfirmPopup.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", e => {
		window.confirmPopup = new ConfirmPopup(".confirm-popup");
	});
</script>