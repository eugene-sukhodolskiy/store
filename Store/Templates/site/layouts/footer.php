<footer class="footer">
	<nav class="footer-nav">
		<ul class="nav-list">
			<li class="nav-item">
				<a href="#" class="nav-link">Вопросы и ответы</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Наш блог</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Наш твиттер</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">О нас</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Политика конфиденциальности</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Публичный договор</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">Обратная связь</a>
			</li>
		</ul>
	</nav>

	<div class="copyright">
		<p>Сгенерировано за <?= round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) ?> сек.</p>
		<p>&copy; <?= date("Y") ?></p>
	</div>
</footer>