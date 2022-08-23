<?
	/**
	 * @var Int $number_images
	 * @var Array $images
	 */
?>
<div class="component img-uploader">
	<div class="img-uploader-container">
		<input 
			type="file" 
			class="dnone" 
			name="imgs" 
			accept="image/jpeg"
			multiple
		>

		<div class="drag-and-drop-curtain">
			<span class="mdi mdi-upload-outline"></span>
			<span>Отпустите для загрузки <strong>JPEG</strong> файла</span>
		</div>

		<div class="reference-selected-img dnone">
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
				<div class="upload-progress-bar">
					<div class="bar"></div>
				</div>
			</div>
		</div>
		
		<div class="selected-imgs-grid">
			<div class="add-img <? if(count($images) >= $number_images): ?>dnone<? endif ?>">
				<span class="mdi mdi-plus"></span>
				Добавить фото
			</div>

			<? for($i = 0; $i < $number_images; $i++): ?>
				<div class="selected-img <? if(!isset($images[$i]) or !$images[$i]): ?>empty<? endif ?>">
					<span class="mdi mdi-camera"></span>
					<div class="btns-group">
						<button class="std-btn btn-circle btn-move-left">
							<span class="mdi mdi-arrow-left"></span>
						</button>
						
						<button class="std-btn btn-circle btn-remove">
							<span class="mdi mdi-trash-can-outline"></span>
						</button>
					</div>
					<div class="upload-progress-bar">
						<div class="bar"></div>
					</div>
					<? if(isset($images[$i]) and $images[$i]): ?>
						<img 
							src="<?= $images[$i] -> get_url("sm") ?>" 
							data-alias="<?= $images[$i] -> alias ?>" 
							data-path="<?= $images[$i] -> get_path_to_image() ?>" 
							data-url="<?= $images[$i] -> get_url("original") ?>"
						>
					<? endif ?>
				</div>
			<? endfor ?>
		</div>

	</div>
</div>

<script type="text/javascript" src="/Store/Resources/js/ImgUploader.js"></script>

<script>
	document.addEventListener("DOMContentLoaded", e => {
		new ImgUploader(".img-uploader-container", <?= $number_images ?>, "<?= app() -> routes -> urlto("ImgUploaderController@upload_img") ?>");
	});
</script>