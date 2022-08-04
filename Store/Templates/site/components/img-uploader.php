<div class="component img-uploader">
	<div class="img-uploader-container">
		<input 
			type="file" 
			class="dnone" 
			name="imgs" 
			accept="image/jpeg"
			multiple
		>
		
		<div class="selected-imgs-grid">
			<div class="add-img">
				<span class="mdi mdi-plus"></span>
				Добавить фото
			</div>

			<? for($i = 0; $i < 8; $i++): ?>
				<div class="selected-img empty">
					<span class="mdi mdi-camera"></span>
					<div class="btns-group">
						<button class="std-btn btn-circle btn-move-left">
							<span class="mdi mdi-arrow-left"></span>
						</button>
						
						<button class="std-btn btn-circle btn-remove">
							<span class="mdi mdi-trash-can-outline"></span>
						</button>
					</div>
				</div>
			<? endfor ?>
		</div>

	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		new ImgUploader(".img-uploader-container", 8);
	});
</script>