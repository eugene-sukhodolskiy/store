<?php

namespace Fury\Libs;

class LoremIpsum {
	/**
	 * Array sentences
	 */
	private Array $vocabulary;

	/**
	 * Language for text
	 */
	public String $lang;

	/**
	 * Cache count items in vocabulary
	 */
	private Int $count_sentence;

	/**
	 * Array of human names
	 */
	private Array $names;

	/**
	 * Array of human surnames
	 */
	private Array $surnames;

	private Array $phone_numbers;

	private Array $email_domen_list;

	public function __construct($lang = "en"){
		$this -> lang = $lang;
		$this -> vocabulary = ["en" => [
			"Aenean facilisis venenatis ipsum vel aliquet.",
			"Aenean rhoncus malesuada auctor.",
			"Cras sit amet magna sit amet felis eleifend lacinia.",
			"Donec nec velit eget tellus adipiscing iaculis eu non lorem.",
			"Donec ac tellus eu tellus dignissim blandit.",
			"Donec diam dui, mollis venenatis lacinia ac, pretium id augue.",
			"Donec lectus dolor, cursus eget facilisis id, ultrices ac mauris.",
			"Duis sem quam, euismod ac rhoncus id, adipiscing sed sem.",
			"Etiam sagittis tellus sapien.",
			"In accumsan bibendum magna a egestas.",
			"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
			"Maecenas tristique magna nulla, in fringilla purus.",
			"Nulla eleifend velit faucibus eros rhoncus molestie.",
			"Nulla pellentesque dolor at metus molestie ultrices nec vitae metus.",
			"Pellentesque vel felis purus, ut dignissim erat.",
			"Pellentesque quis purus nec odio aliquet bibendum ut vitae risus.",
			"Phasellus sed felis vitae purus dictum fermentum.",
			"Praesent ac tellus dui, in euismod leo.",
			"Proin vulputate tincidunt erat id auctor.",
			"Sed non justo enim.",
			"Vestibulum imperdiet nunc id metus pellentesque eleifend.",
			"Vivamus ultricies iaculis arcu, vitae bibendum tellus feugiat venenatis.",
			"Sed ultricies mi vel aliquet eleifend.",
			"Ut egestas est id ligula gravida, quis lobortis lacus consectetur.",
			"Cras ac urna fringilla, bibendum leo sit amet, suscipit nisi.",
			"Sed gravida erat sit amet neque rutrum mattis.",
			"Integer at ex nec nunc euismod scelerisque.",
			"Nullam faucibus dui imperdiet rutrum rhoncus.",
			"Proin scelerisque sapien et augue sodales auctor.",
			"In posuere erat ut posuere mollis.",
			"Morbi lobortis ipsum eu ipsum eleifend, eu tincidunt arcu sagittis."
		],
		"ru" => [
			"Интеллект естественно понимает под собой интеллигибельный закон внешнего мира, открывая новые горизонты.",
			"Гедонизм осмысляет дедуктивный метод. Надстройка нетривиальна.",
			"Дискретность амбивалентно транспонирует гравитационный парадокс.",
			"Смысл жизни, следовательно, творит данный закон внешнего мира.",
			"Дедуктивный метод решительно представляет собой бабувизм.",
			"Имеется спорная точка зрения, гласящая примерно следующее: элементы политического процесса, превозмогая сложившуюся непростую экономическую ситуацию, превращены в посмешище, хотя само их существование приносит несомненную пользу обществу.",
			"Но явные признаки победы институционализации в равной степени предоставлены сами себе.",
			"В своём стремлении повысить качество жизни, они забывают, что существующая теория предоставляет широкие возможности для экономической целесообразности принимаемых решений.",
			"Не следует, однако, забывать, что глубокий уровень погружения не оставляет шанса для экспериментов, поражающих по своей масштабности и грандиозности.",
			"Сложно сказать, почему некоторые особенности внутренней политики и по сей день остаются уделом либералов, которые жаждут быть ограничены исключительно образом мышления!",
			"В целом, конечно, социально-экономическое развитие выявляет срочную потребность первоочередных требований.",
			"Каждый из нас понимает очевидную вещь: социально-экономическое развитие позволяет выполнить важные задания по разработке инновационных методов управления процессами.",
			"Предварительные выводы неутешительны: новая модель организационной деятельности, а также свежий взгляд на привычные вещи - безусловно открывает новые горизонты для позиций, занимаемых участниками в отношении поставленных задач!",
			"А также элементы политического процесса преданы социально-демократической анафеме.",
			"В частности, убеждённость некоторых оппонентов предполагает независимые способы реализации глубокомысленных рассуждений.",
			"Задача организации, в особенности же консультация с широким активом позволяет выполнить важные задания по разработке системы массового участия.",
			"Таким образом, граница обучения кадров способствует подготовке и реализации переосмысления внешнеэкономических политик.",
			"Есть над чем задуматься: независимые государства формируют глобальную экономическую сеть и при этом - преданы социально-демократической анафеме.",
			"Предприниматели в сети интернет освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, преданы социально-демократической анафеме.",
			"Принимая во внимание показатели успешности, консультация с широким активом представляет собой интересный эксперимент проверки первоочередных требований.",
			"Как уже неоднократно упомянуто, стремящиеся вытеснить традиционное производство, нанотехнологии, инициированные исключительно синтетически, объединены в целые кластеры себе подобных.",
			"Учитывая ключевые сценарии поведения, высококачественный прототип будущего проекта напрямую зависит от экспериментов, поражающих по своей масштабности и грандиозности.",
			"Идейные соображения высшего порядка, а также граница обучения кадров предопределяет высокую востребованность дальнейших направлений развития.",
			"В частности, постоянный количественный рост и сфера нашей активности, в своём классическом представлении, допускает внедрение приоритизации разума над эмоциями.",
			"Для современного мира курс на социально-ориентированный национальный проект обеспечивает актуальность глубокомысленных рассуждений.",
			"И нет сомнений, что некоторые особенности внутренней политики объявлены нарушающими общечеловеческие нормы этики и морали.",
			"С другой стороны, перспективное планирование представляет собой интересный эксперимент проверки анализа существующих паттернов поведения.",
			"Мы вынуждены отталкиваться от того, что реализация намеченных плановых заданий однозначно определяет каждого участника как способного принимать собственные решения касаемо прогресса профессионального сообщества.",
			"Значимость этих проблем настолько очевидна, что убеждённость некоторых оппонентов представляет собой интересный эксперимент проверки экономической целесообразности принимаемых решений.",
			"Учитывая ключевые сценарии поведения, экономическая повестка сегодняшнего дня требует анализа системы массового участия."
		]
	];

		$this -> count_sentence = count($this -> vocabulary[$this -> lang]);

		$this -> names = ["male" => [], "female" => []];
		$this -> names["male"] = [
			"Liam", "Noah", "Mason", "Ethan", "Logan",
			"Lucas", "Jackson", "Aiden", "Oliver", "Jacob",
			"Elijah", "Alexander", "James", "Benjamin", "Jack",
			"Luke", "William", "Michael", "Owen", "Daniel",
			"Carter", "Gabriel", "Henry", "Matthew", "Wyatt",
			"Caleb", "Jayden", "Nathan", "Ryan", "Isaac",
			"Liam","Noah","Oliver","Elijah","James","William","Benjamin","Lucas","Henry","Theodore","Jack","Levi",
			"Alexander","Jackson","Mateo","Daniel","Michael","Mason","Sebastian","Ethan","Logan","Owen","Samuel",
			"Jacob","Asher","Aiden","John","Joseph","Wyatt","David","Leo","Luke","Julian","Hudson","Grayson","Matthew",
			"Ezra","Gabriel","Carter","Isaac","Jayden","Luca","Anthony","Dylan","Lincoln","Thomas","Maverick",
			"Elias","Josiah","Charles","Caleb","Christopher","Ezekiel","Miles","Jaxon","Isaiah","Andrew",
			"Joshua","Nathan","Nolan","Adrian","Cameron","Santiago","Eli","Aaron","Ryan","Angel","Cooper",
			"Waylon","Easton","Kai","Christian","Landon","Colton","Roman","Axel","Brooks","Jonathan","Robert",
			"Jameson","Ian","Everett","Greyson","Wesley","Jeremiah","Hunter","Leonardo","Jordan","Jose","Bennett",
			"Silas","Nicholas","Parker","Beau","Weston","Austin","Connor","Carson","Dominic","Xavier","Jaxson",
			"Jace","Emmett","Adam","Declan","Rowan","Micah","Kayden","Gael","River","Ryder","Kingston","Damian",
			"Sawyer","Luka","Evan","Vincent","Legend","Myles","Harrison","August","Bryson","Amir","Giovanni",
			"Chase","Diego","Milo","Jasper","Walker","Jason","Brayden","Cole","Nathaniel","George","Lorenzo",
			"Zion","Luis","Archer","Enzo","Jonah","Thiago","Theo","Ayden","Zachary","Calvin","Braxton","Ashton",
			"Rhett","Atlas","Jude","Bentley","Carlos","Ryker","Adriel","Arthur","Ace","Tyler","Jayce","Max",
		];
		$this -> names["female"] = [
			"Emma", "Olivia", "Ava", "Sophia", "Isabella",
			"Mia", "Charlotte", "Amelia", "Emily", "Madison",
			"Harper", "Abigail", "Avery", "Lily", "Ella",
			"Chloe", "Evelyn", "Sofia", "Aria", "Ellie",
			"Aubrey", "Scarlett", "Zoey", "Hannah", "Audrey",
			"Grace", "Addison", "Zoe", "Elizabeth", "Nora"
		];

		$this -> surnames = [
			"Smith", "Johnson", "Williams", "Jones", "Brown", 
			"Davis", "Miller", "Wilson", "Moore", "Taylor", 
			"Anderson", "Thomas", "Jackson", "White", "Harris", 
			"Martin", "Thompson", "Garcia", "Martinez", "Robinson", 
			"Clark", "Rodriguez", "Lewis", "Lee", "Walker", 
			"Hall", "Allen", "Young", "Hernandez", "King", 
			"Wright", "Lopez", "Hill", "Scott", "Green", 
			"Adams", "Baker", "Gonzalez", "Nelson", "Carter",
			"Mitchell", "Perez", "Roberts", "Turner", "Phillips", 
			"Campbell", "Parker", "Evans", "Edwards", "Collins", 
			"Stewart", "Sanchez", "Morris", "Rogers", "Reed", 
			"Cook", "Morgan", "Bell", "Murphy", "Bailey", 
			"Rivera", "Cooper", "Richardson", "Cox", "Howard", 
			"Ward", "Torres", "Peterson", "Gray", "Ramirez", 
			"James", "Watson", "Brooks", "Kelly", "Sanders", 
			"Price", "Bennett", "Wood", "Barnes", "Ross", 
			"Henderson", "Coleman", "Jenkins", "Perry", "Powell", 
			"Long", "Patterson", "Flores", "Washington", "Hughes",
			"Butler", "Simmons", "Gonzales", "Foster", "Bryant", 
			"Alexander", "Russell", "Griffin", "Diaz", "Hayes",
			"Elliot","Graham","Kaiden","Maxwell","Juan","Dean","Matteo","Malachi","Ivan","Elliott","Jesus",
			"Emiliano","Messiah","Gavin","Maddox","Camden","Hayden","Leon","Antonio","Justin","Tucker","Brandon",
			"Kevin","Judah","Finn","King","Brody","Xander","Nicolas","Charlie","Arlo","Emmanuel","Barrett",
			"Felix","Alex","Miguel","Abel","Alan","Beckett","Amari","Karter","Timothy","Abraham","Jesse",
			"Zayden","Blake","Alejandro","Dawson","Tristan","Victor","Avery","Joel","Grant","Eric","Patrick",
			"Peter","Richard","Edward","Andres","Emilio","Colt","Knox","Beckham","Adonis","Kyrie","Matias",
			"Oscar","Lukas","Marcus","Hayes","Caden","Remington","Griffin","Nash","Israel","Steven","Holden",
			"Rafael","Zane","Jeremy","Kash","Preston","Kyler","Jax","Jett","Kaleb","Riley","Simon","Phoenix",
			"Javier","Bryce","Louis","Mark","Cash","Lennox","Paxton","Malakai","Paul","Kenneth","Nico","Kaden",
			"Lane","Kairo","Maximus","Omar","Finley","Atticus","Crew","Brantley","Colin","Dallas","Walter",
			"Brady","Callum","Ronan","Hendrix","Jorge","Tobias","Clayton","Emerson","Damien","Zayn","Malcolm",
			"Kayson","Bodhi","Bryan","Aidan","Cohen","Brian","Cayden","Andre","Niko","Maximiliano","Zander",
			"Khalil","Rory","Francisco","Cruz","Kobe","Reid","Daxton","Derek","Martin","Jensen","Karson","Tate",
			"Muhammad","Jaden","Joaquin","Josue","Gideon","Dante","Cody","Bradley","Orion","Spencer","Angelo",
			"Erick","Jaylen","Julius","Manuel","Ellis","Colson","Cairo","Gunner","Wade","Chance","Odin","Anderson",
			"Kane","Raymond","Cristian","Aziel","Prince","Ezequiel","Jake","Otto","Eduardo","Rylan","Ali","Cade",
			"Stephen","Ari","Kameron","Dakota","Warren","Ricardo","Killian","Mario","Romeo","Cyrus","Ismael",
			"Russell","Tyson","Edwin","Desmond","Nasir","Remy","Tanner","Fernando","Hector","Titus","Lawson",
			"Sean","Kyle","Elian","Corbin","Bowen","Wilder","Armani","Royal","Stetson","Briggs","Sullivan",
			"Leonel","Callan","Finnegan","Jay","Zayne","Marshall","Kade","Travis","Sterling","Raiden","Sergio",
			"Tatum","Cesar","Zyaire","Milan","Devin","Gianni","Kamari","Royce","Malik","Jared","Franklin",
			"Clark","Noel","Marco","Archie","Apollo","Pablo","Garrett","Oakley","Memphis","Quinn","Onyx",
			"Alijah","Baylor","Edgar","Nehemiah","Winston","Major","Rhys","Forrest","Jaiden","Reed","Santino",
			"Troy","Caiden","Harvey","Collin","Solomon","Donovan","Damon","Jeffrey","Kason","Sage","Grady",
			"Kendrick","Leland","Luciano","Pedro","Hank","Hugo","Esteban","Johnny","Kashton","Ronin",
			"Ford","Mathias","Porter","Erik","Johnathan","Frank","Tripp","Casey","Fabian","Leonidas","Baker",
			"Matthias","Philip","Jayceon","Kian","Saint","Ibrahim","Jaxton","Augustus","Callen","Trevor","Ruben",
			"Adan","Conor","Dax","Braylen","Kaison","Francis","Kyson","Andy","Lucca","Mack","Peyton","Alexis",
			"Deacon","Kasen","Kamden","Frederick","Princeton","Braylon","Wells","Nikolai","Iker","Bo","Dominick",
			"Moshe","Cassius","Gregory","Lewis","Kieran","Isaias","Seth","Marcos","Omari","Shane","Keegan","Jase",
			"Asa","Sonny","Uriel","Pierce","Jasiah","Eden","Rocco","Banks","Cannon","Denver","Zaiden","Roberto",
			"Shawn","Drew","Emanuel","Kolton","Ayaan","Ares","Conner","Jalen","Alonzo","Enrique","Dalton","Moses",
			"Koda","Bodie","Jamison","Phillip","Zaire","Jonas","Kylo","Moises","Shepherd","Allen","Kenzo",
			"Mohamed","Keanu","Dexter","Conrad","Bruce","Sylas","Soren","Raphael","Rowen","Gunnar","Sutton",
			"Quentin","Jaziel","Emmitt","Makai","Koa","Maximilian","Brixton","Dariel","Zachariah","Roy","Armando",
			"Corey","Saul","Izaiah","Danny","Davis","Ridge","Yusuf","Ariel","Valentino","Jayson","Ronald",
			"Albert","Gerardo","Ryland","Dorian","Drake","Gage","Rodrigo","Hezekiah","Kylan","Boone","Ledger",
			"Santana","Jamari","Jamir","Lawrence","Reece","Kaysen","Shiloh","Arjun","Marcelo","Abram","Benson",
			"Huxley","Nikolas","Zain","Kohen","Samson","Miller","Donald","Finnley","Kannon","Lucian","Watson","Keith",
			"Westin","Tadeo","Sincere","Boston","Axton","Amos","Chandler","Leandro","Raul","Scott","Reign",
			"Alessandro","Camilo","Derrick","Morgan","Julio","Clay","Edison","Jaime","Augustine","Julien","Zeke",
			"Marvin","Bellamy","Landen","Dustin","Jamie","Krew","Kyree","Colter","Johan","Houston","Layton",
			"Quincy","Case","Atreus","Cayson","Aarav","Darius","Harlan","Justice","Abdiel","Layne","Raylan",
			"Arturo","Taylor","Anakin","Ander","Hamza","Otis","Azariah","Leonard","Colby","Duke","Flynn","Trey",
			"Gustavo","Fletcher","Issac","Sam","Trenton","Callahan","Chris","Mohammad","Rayan","Lionel","Bruno",
			"Jaxxon","Zaid","Brycen","Roland","Dillon","Lennon","Ambrose","Rio","Mac","Ahmed","Samir","Yosef",
			"Tru","Creed","Tony","Alden","Aden","Alec","Carmelo","Dario","Marcel","Roger","Ty","Ahmad","Emir",
			"Landyn","Skyler","Mohammed","Dennis","Kareem","Nixon","Rex","Uriah","Lee","Louie","Rayden","Reese",
			"Alberto","Cason","Quinton","Kingsley","Chaim","Alfredo","Mauricio","Caspian","Legacy","Ocean","Ozzy",
			"Briar","Wilson","Forest","Grey","Joziah","Salem","Neil","Remi","Bridger","Harry","Jefferson",
			"Lachlan","Nelson","Casen","Salvador","Magnus","Tommy","Marcellus","Maximo","Jerry","Clyde","Aron",
			"Keaton","Eliam","Lian","Trace","Douglas","Junior","Titan","Cullen","Cillian","Musa","Mylo","Hugh",
			"Tomas","Vincenzo","Westley","Langston","Byron","Kiaan","Loyal","Orlando","Kyro","Amias","Amiri",
			"Jimmy","Vicente","Khari","Brendan","Rey","Ben","Emery","Zyair","Bjorn","Evander","Ramon","Alvin",
			"Ricky","Jagger","Brock","Dakari","Eddie","Blaze","Gatlin","Alonso","Curtis","Kylian","Nathanael",
			"Devon","Wayne","Zakai","Mathew","Rome","Riggs","Aryan","Avi","Hassan","Lochlan","Stanley","Dash",
			"Kaiser","Benicio","Bryant","Talon","Rohan","Wesson","Joe","Noe","Melvin","Vihaan","Zayd","Darren",
			"Enoch","Mitchell","Jedidiah","Brodie","Castiel","Ira","Lance","Guillermo","Thatcher","Ermias","Misael",
			"Jakari","Emory","Mccoy","Rudy","Thaddeus","Valentin","Yehuda","Bode","Madden","Kase","Bear","Boden",
			"Jiraiya","Maurice","Alvaro","Ameer","Demetrius","Eliseo","Kabir","Kellan","Allan","Azrael","Calum",
			"Niklaus","Ray","Damari","Elio","Jon","Leighton","Axl","Dane","Eithan","Eugene","Kenji","Jakob",
			"Colten","Eliel","Nova","Santos","Zahir","Idris","Ishaan","Kole","Korbin","Seven","Alaric","Kellen",
			"Bronson","Franco","Wes","Larry","Mekhi","Jamal","Dilan","Elisha","Brennan","Kace","Van","Felipe","Fisher",
			"Cal","Dior","Judson","Alfonso","Deandre","Rocky","Henrik","Reuben","Anders","Arian","Damir","Jacoby",
			"Khalid","Kye","Mustafa","Jadiel","Stefan","Yousef","Aydin","Jericho","Robin","Wallace","Alistair","Davion",
			"Alfred","Ernesto","Kyng","Everest","Gary","Leroy","Yahir","Braden","Kelvin","Kristian","Adler","Avyaan",
			"Brayan","Jones","Truett","Aries","Joey","Randy","Jaxx","Jesiah","Jovanni","Azriel","Brecken","Harley",
			"Zechariah","Gordon","Jakai","Carl","Graysen","Kylen","Ayan","Branson","Crosby","Dominik","Jabari",
			"Jaxtyn","Kristopher","Ulises","Zyon","Fox","Howard","Salvatore","Turner","Vance","Harlem","Jair","Jakobe",
			"Jeremias","Osiris","Azael","Bowie","Canaan","Elon","Granger","Karsyn","Zavier","Cain","Dangelo","Heath",
			"Yisroel","Gian","Shepard","Harold","Kamdyn","Rene","Rodney","Yaakov","Adrien","Kartier","Cassian",
			"Coleson","Ahmir","Darian","Genesis","Kalel","Agustin","Wylder","Yadiel","Ephraim","Kody","Neo","Ignacio",
			"Osman","Aldo","Abdullah","Cory","Blaine","Dimitri","Khai","Landry","Palmer","Benedict","Leif","Koen",
			"Maxton","Mordechai","Zev","Atharv","Bishop","Blaise","Davian"
		];

		$this -> phone_numbers = ["country_code" => ["+1", "+3", "+7", "+9", "+2", "+4"], "region_code" => [
			209, 213, 310, 323, 408, 415, 424, 510, 530, 559, 562, 619, 626, 650, 661, 707, 714, 760, 805, 818, 831, 858, 909, 925, 949,
			239, 305, 321, 352, 386, 407, 561, 727, 754, 772, 786, 813, 850, 863, 904, 941, 954,
			217, 224, 309, 312, 331, 464, 618, 630, 708, 773, 779, 815, 847, 872
		]];
		$this -> phone_numbers["count_country_code"] = count($this -> phone_numbers["country_code"]);
		$this -> phone_numbers["count_region_code"] = count($this -> phone_numbers["region_code"]);
		$this -> email_domen_list = [
			"gmail",
			"yahoo",
			"hotmail",
			"outlook",
			"mail"
		];
	}

	/**
	 * wrap for $this -> gen()
	 *
	 * @return Array
	 */
	public function gen_list(Int $count_items){
		return $this -> gen($count_items);
	}

	/**
	 * Generate preset words
	 *
	 * @return String
	 */
	public function gen_words(Int $count_words){
		$max_count = 30;
		if($count_words > $max_count) $count_words = $max_count;
		list($paragraph) = $this -> gen_paragraphs(1, 10, 20);
		$paragraph = explode(" ", $paragraph);
		$words = [];
		for($i = 0; $i < $count_words; $i++){
			$words[] = $paragraph[$i];
		}
		$words = implode(" ", $words);
		$words = trim($words, ",");
		return $words;
	}

	/**
	 * Generate preset count paragraphs
	 *
	 * @return Array
	 */
	public function gen_paragraphs(Int $count_p, Int $min_len = 1, Int $max_len = 30){
		$p = [];
		for($i=0; $i<$count_p; $i++){
			$paragraphy_len = rand($min_len, $max_len);
			$p[] = implode(" ", $this -> gen($paragraphy_len));
		}

		return $p;
	}

	/**
	 * Generate one paragraph
	 *
	 * @return String
	 */
	public function gen_paragraph(Int $count_sentence = 0){
		if(!$count_sentence) $count_sentence = rand(1, 30);
		$p = implode(" ", $this -> gen($count_sentence));
		return $p;
	}

	/**
	 * gen Generated base list width random sentence
	 *
	 * @return Array
	 */
	private function gen(Int $count){
		$prevnum = -1;
		$li = [];
		for($i=0; $i<$count; $i++){
			$currentnum = rand(0, $this -> count_sentence - 1);
			if($currentnum == $prevnum){
				$currentnum = rand(0, $this -> count_sentence - 1);
			}
			$li[] = $this -> vocabulary[$this -> lang][$currentnum];
			$prevnum = $currentnum;
		}

		return $li;
	}

	// ---- NAMES ---- //
	
	/**
	 * Generate and return random eng name
	 *
	 * @return String
	 */
	public function get_name(String $sex = ""){
		if($sex == ""){
			$sex = rand(0, 1) ? "male" : "female";
		}
		$count_names = count($this -> names[$sex]);
		return $this -> names[$sex][rand(0, $count_names - 1)];
	}

	/**
	 * Wrapper for get_name func
	 *
	 * @return String [female name]
	 */
	public function get_female_name(){
		return $this -> get_name("female");
	}

	/**
	 * Wwrapper for get_name func
	 *
	 * @return String [male name]
	 */
	public function get_male_name(){
		return $this -> get_name("male");
	}

	/**
	 * @return String [return surname]
	 */
	public function get_surname(){
		$count_surnames = count($this -> surnames);
		return $this -> surnames[rand(0, $count_surnames - 1)];
	}

	/**
	 * Return name and surname with separator space
	 *
	 * @return String [return name and surname with separator space]
	 */
	public function get_full_name_to_str(){
		return $this -> get_name() . " " . $this -> get_surname();
	}

	/**
	 * Return name and surname in array
	 *
	 * @return Array [return name and surname in array]
	 */
	public function get_full_name_to_arr(){
		return ["name" => $this -> get_name(), "surname" => $this -> get_surname()];
	}

	// ---- PHONE NUMBERS ---- //
	
	/**
	 * @return String [formated phone number]
	 */
	public function get_phone_number(){
		$count_country_code = $this -> phone_numbers["count_country_code"] - 1;
		$count_region_code = $this -> phone_numbers["count_region_code"] - 1;
		$country_code = $this -> phone_numbers["country_code"][ rand(0, $count_country_code) ];
		$region_code = $this -> phone_numbers["region_code"][ rand(0, $count_region_code) ];
		$phone_number = $country_code . " " . $region_code . "-" . rand(100, 999) . "-" . rand(1000, 9999);
		return $phone_number;
	}

	// ---- EMAIL ---- //

	/**
	 * Email address
	 *
	 * @return String [email]
	 */
	public function get_email(String $name = "", String $surname = ""){
		$count = count($this -> email_domen_list) - 1;
		$name = $name != "" ? $name : $this -> get_name();
		$surname = $surname != "" ? $surname : $this -> get_surname();
		$sep_arr = [".", "_", ""];
		$sep = $sep_arr[ rand(0, count($sep_arr) - 1) ];
		$host = $this -> email_domen_list[ rand(0, $count) ];
		$email = strtolower($name) . $sep . strtolower($surname) . "@" . $host . ".com";
		return $email;
	}

	// ---- USER ---- //

	/**
	 * data about one random user
	 *
	 * @return Array [user card in assoc array]
	 */
	public function get_user_card(String $sex = ""){
		if($sex == ""){
			$sex = rand(0, 1) ? "male" : "female";
		}
		$name = $this -> get_name($sex);
		$surname = $this -> get_surname();
		$user = [
			"name" => $name,
			"surname" => $surname,
			"sex" => $sex,
			"phone" => $this -> get_phone_number(),
			"email" => $this -> get_email($name, $surname)
		];

		return $user;
	}
}