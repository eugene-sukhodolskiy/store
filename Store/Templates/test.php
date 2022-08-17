<? $this -> extends_from("\Store\Templates\Logic\SiteBase:site.base") ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search page | Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="/Store/Resources/libs/materialdesign-icons/css/materialdesignicons.min.css">
	<link rel="stylesheet" type="text/css" href="/Store/Resources/css/style.min.css">
	<!-- <link rel="icon" href="/favicon.png"> -->
</head>
<body class="page search">
<script>
	const ISAUTH = true</script>

<div class="component navbar">
	<div class="container navbar-container">
		<div class="logo-wrapper">
			<div class="logo">
				<a href="/" class="logo-link">Logo</a>
			</div>
		</div>

		<div class="search-bar-wrapper">
			<div class="component search-bar">
	<div class="form-group search-field-container">
		<input 
			type="text" 
			name="search" 
			class="std-input search-field"
			placeholder="Поиск"
		>
		<button class="submit">
			<span class="mdi mdi-magnify"></span>
		</button>
	</div>
</div>		</div>

		<div class="navigation-main-wrapper">
			<nav class="component navigation-main">
	<ul class="nav-list">
		<li class="nav-list-item">
			<a href="/" class="nav-link">Главная</a>
		</li>
		<li class="nav-list-item">
			<a href="#" class="nav-link">Избранное</a>
		</li>
		<li class="nav-list-item">
			<a href="#" class="nav-link">Сообщения</a>
		</li>
		<li class="nav-list-item">
			<a 
				href="/uadpost/create.html" 
				class="std-btn btn-primary create-uadpost"
			>
				<span class="mdi mdi-plus"></span>
				Новое объявление
			</a>
		</li>
	</ul>
</nav>		</div>

		<div class="userbar-wrapper">
							<div class="component userbar">
	<div class="userpic-wrapper">
		<a href="#" class="userpic-link">
			<img src="/Store/Resources/img/placeholder-150x150.png" alt="" class="userpic">
		</a>
	</div>
	<div class="user-name">
		<a href="#" class="user-name-link">
								</a>
	<span class="mdi mdi-chevron-down"></span>
	</div>
	<div class="user-nav-wrapper">
		<nav class="component user-nav">
	<ul class="user-nav-list">
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Профиль</a>
		</li>
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Тест 1</a>
		</li>
		<li class="user-nav-item">
			<a href="#" class="user-nav-link">Двинное слово</a>
		</li>
		<li class="user-nav-item">
			<a 
				href="/auth/signout.html?redirect_to=%2F" 
				class="user-nav-link"
			>Выйти</a>
		</li>
	</ul>
</nav>	</div>
</div>					</div>

		<button class="btn-nav-on-mob-show">
			<span class="mdi mdi-menu state-inactive"></span>	
			<span class="mdi mdi-close state-active"></span>	
		</button>
	</div>
</div>
<div class="dnone">
	
<div class="component alert type-default" data-id="alert-id-reference">
	<div class="content"></div>
			<button class="close-alert" data-close-alert-id="alert-id-reference">
			<span class="mdi mdi-close"></span>
		</button>
	</div></div>

<div class="container">
	<div class="page-content">
		
<div class="page-content-wrap">
	<div class="filters-container"></div>
	<div class="search-result">
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/sed-gravida-erat-sit-amet-neque-rutrum-mattis.html/p.html" class="title">
				Sed gravida erat sit amet neque rutrum mattis.			</a>

			<div class="price-container">
				<span class="price">1726</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Liam">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Liam Landyn</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21201"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/sed-gravida-erat-sit-amet-neque-rutrum-mattis.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Liam">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Liam Landyn</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/sed-non-justo-enim.html/p.html" class="title">
				Sed non justo enim.			</a>

			<div class="price-container">
				<span class="price">8354</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="William">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">William Johnathan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21200"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/sed-non-justo-enim.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="William">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">William Johnathan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/pellentesque-quis-purus-nec-odio-aliquet-bibendum-ut-vitae-risus.html/p.html" class="title">
				Pellentesque quis purus nec odio aliquet bibendum ut vitae risus.			</a>

			<div class="price-container">
				<span class="price">3372</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Liam">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Liam Bowen</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21199"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/pellentesque-quis-purus-nec-odio-aliquet-bibendum-ut-vitae-risus.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Liam">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Liam Bowen</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/etiam-sagittis-tellus-sapien.html/p.html" class="title">
				Etiam sagittis tellus sapien.			</a>

			<div class="price-container">
				<span class="price">689</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Leo">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Leo Crew</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21198"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/etiam-sagittis-tellus-sapien.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Leo">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Leo Crew</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/sed-gravida-erat-sit-amet-neque-rutrum-mattis.html/p.html" class="title">
				Sed gravida erat sit amet neque rutrum mattis.			</a>

			<div class="price-container">
				<span class="price">8922</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="August">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">August Cillian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21197"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/sed-gravida-erat-sit-amet-neque-rutrum-mattis.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="August">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">August Cillian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/pellentesque-quis-purus-nec-odio-aliquet-bibendum-ut-vitae-risus.html/p.html" class="title">
				Pellentesque quis purus nec odio aliquet bibendum ut vitae risus.			</a>

			<div class="price-container">
				<span class="price">7715</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Ava">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Ava Legacy</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21196"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/pellentesque-quis-purus-nec-odio-aliquet-bibendum-ut-vitae-risus.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Ava">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Ava Legacy</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/proin-scelerisque-sapien-et-augue-sodales-auctor.html/p.html" class="title">
				Proin scelerisque sapien et augue sodales auctor.			</a>

			<div class="price-container">
				<span class="price">223</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Abigail">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Abigail Turner</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21195"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/proin-scelerisque-sapien-et-augue-sodales-auctor.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Abigail">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Abigail Turner</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/donec-nec-velit-eget-tellus-adipiscing-iaculis-eu-non-lorem.html/p.html" class="title">
				Donec nec velit eget tellus adipiscing iaculis eu non lorem.			</a>

			<div class="price-container">
				<span class="price">8697</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Owen">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Owen Fabian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21194"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/donec-nec-velit-eget-tellus-adipiscing-iaculis-eu-non-lorem.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Owen">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Owen Fabian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/in-accumsan-bibendum-magna-a-egestas.html/p.html" class="title">
				In accumsan bibendum magna a egestas.			</a>

			<div class="price-container">
				<span class="price">9782</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Owen">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Owen Castiel</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21193"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/in-accumsan-bibendum-magna-a-egestas.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Owen">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Owen Castiel</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="title">
				Vivamus ultricies iaculis arcu, vitae bibendum tellus feugiat venenatis.			</a>

			<div class="price-container">
				<span class="price">9420</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Grace">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Grace Forest</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21192"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Grace">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Grace Forest</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/nulla-pellentesque-dolor-at-metus-molestie-ultrices-nec-vitae-metus.html/p.html" class="title">
				Nulla pellentesque dolor at metus molestie ultrices nec vitae metus.			</a>

			<div class="price-container">
				<span class="price">5895</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Isaiah">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Isaiah Jesiah</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21191"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/nulla-pellentesque-dolor-at-metus-molestie-ultrices-nec-vitae-metus.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Isaiah">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Isaiah Jesiah</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="title">
				Vivamus ultricies iaculis arcu, vitae bibendum tellus feugiat venenatis.			</a>

			<div class="price-container">
				<span class="price">9126</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Emma">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Emma Tobias</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21190"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Emma">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Emma Tobias</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/proin-scelerisque-sapien-et-augue-sodales-auctor.html/p.html" class="title">
				Proin scelerisque sapien et augue sodales auctor.			</a>

			<div class="price-container">
				<span class="price">2970</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Zoey">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Zoey Rohan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21189"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/proin-scelerisque-sapien-et-augue-sodales-auctor.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Zoey">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Zoey Rohan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/integer-at-ex-nec-nunc-euismod-scelerisque.html/p.html" class="title">
				Integer at ex nec nunc euismod scelerisque.			</a>

			<div class="price-container">
				<span class="price">7532</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="James">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">James Harley</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21188"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/integer-at-ex-nec-nunc-euismod-scelerisque.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="James">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">James Harley</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/phasellus-sed-felis-vitae-purus-dictum-fermentum.html/p.html" class="title">
				Phasellus sed felis vitae purus dictum fermentum.			</a>

			<div class="price-container">
				<span class="price">2640</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Matthew">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Matthew Brian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21187"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/phasellus-sed-felis-vitae-purus-dictum-fermentum.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Matthew">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Matthew Brian</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/vestibulum-imperdiet-nunc-id-metus-pellentesque-eleifend.html/p.html" class="title">
				Vestibulum imperdiet nunc id metus pellentesque eleifend.			</a>

			<div class="price-container">
				<span class="price">4935</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Lincoln">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Lincoln Mark</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21186"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/vestibulum-imperdiet-nunc-id-metus-pellentesque-eleifend.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Lincoln">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Lincoln Mark</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="title">
				Vivamus ultricies iaculis arcu, vitae bibendum tellus feugiat venenatis.			</a>

			<div class="price-container">
				<span class="price">7642</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Zion">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Zion Turner</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21185"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/vivamus-ultricies-iaculis-arcu-vitae-bibendum-tellus-feugiat-venenatis.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Zion">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Zion Turner</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/donec-nec-velit-eget-tellus-adipiscing-iaculis-eu-non-lorem.html/p.html" class="title">
				Donec nec velit eget tellus adipiscing iaculis eu non lorem.			</a>

			<div class="price-container">
				<span class="price">1099</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Harper">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Harper Corey</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21184"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/donec-nec-velit-eget-tellus-adipiscing-iaculis-eu-non-lorem.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Harper">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Harper Corey</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/sed-non-justo-enim.html/p.html" class="title">
				Sed non justo enim.			</a>

			<div class="price-container">
				<span class="price">4729</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Ellie">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Ellie Maximiliano</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21183"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/sed-non-justo-enim.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Ellie">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Ellie Maximiliano</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
					<div class="search-item">
				<div class="component uadpost-card">
	<div class="struct ">
		
		
		<div class="description">
			<a href="/uadpost/praesent-ac-tellus-dui-in-euismod-leo.html/p.html" class="title">
				Praesent ac tellus dui, in euismod leo.			</a>

			<div class="price-container">
				<span class="price">8924</span> 
				<span class="currency">UAH</span>
			</div>

			<div class="std-row meta-info">
				<div class="location" title="TestRegion">
					<span class="mdi mdi-map-marker-outline"></span>
											<span class="city">TestCity</span>,
										
											<span class="country">Ukraine</span>
									</div>
				
				<div class="timestamp">
					<span class="mdi mdi-calendar"></span>
					<span class="create-at">
						17.08.2022					</span>
				</div>
			</div>

							<div class="saler">
					<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Bryson">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Bryson Kylan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>				</div>
			
			<div class="control-bar">
				
<button 
	class="component std-btn btn-favorite "
	data-uadpost-id="21182"
	data-make-favorite
	title="Добавить в избранное"
>
	<span class="mdi mdi-star-outline for-state-unactive"></span>
	<span class="mdi mdi-star-check for-state-active"></span>
	<span class="btn-label for-state-active">Сохранено</span>
</button>				<a href="/uadpost/praesent-ac-tellus-dui-in-euismod-leo.html/p.html" class="std-btn btn-primary">Открыть</a>
			</div>
		</div>
	</div>
</div>				
				<div class="component compact-user-card">
	<div class="std-row">
		<div class="userpic">
			<a href="#" class="no-decoration">
				<img src="https://randomuser.me/api/portraits/women/90.jpg" alt="Bryson">
			</a>
		</div>
		<div class="user-info">
			<div class="user-name">
				<a href="#">Bryson Kylan</a>
			</div>
			<div class="no-matter-text">34 продано / 3 в продаже</div>
		</div>
	</div>
</div>			</div>
			</div>
</div>
	

	<div class="component paginator" id="search-result-paginator">
		
		<div class="page-num-selector-wrap">
			<input 
				type="number" 
				class="std-input page-num-selector" 
				step="1"
				min="1"
				data-current-url="/"
				max="7"
				value="1"
			>
			<span class="no-matter-text total-pages">из 7</span>
		</div>

					<div class="next-page">
				<a href="/?pn=2" class="std-btn btn-default btn-next-page">
					<span class="mdi mdi-chevron-right"></span>
				</a>
			</div>
			</div>

	<script src="/Store/Resources/js/Paginator.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", e => {
			new Paginator("search-result-paginator");
		});
	</script>
	</div>
	
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
		<p>Сгенерировано за 0.207 сек.</p>
		<p>&copy; 2022</p>
	</div>
</footer></div>

<script type="text/javascript" src="/Store/Resources/libs/autosize.min.js"></script>
<script type="text/javascript" src="/Store/Resources/js/Alert.js"></script>
<script type="text/javascript" src="/Store/Resources/js/Auth.js"></script>
<script type="text/javascript" src="/Store/Resources/js/App.js"></script>

</body>
</html>
