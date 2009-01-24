<?php
App::import('vendor', 'dummy.dummydata/library');
class DummyGenerator {
	
	// returns true if $str begins with $sub
	public static function beginsWith($str, $sub) {
		return (substr($str, 0, strlen($sub)) == $sub);
	}
	
	public static function listGenerators() {
		$functions = get_class_methods('DummyGenerator');
		$ret = array();
		foreach ($functions as $key => $value) {
			if (self::beginsWith($value, 'generate')) {
				$generator = substr($value, 8);
				$ret[$generator] = $generator;
			}
		
		}
		return $ret;
	}
	
	/** Help generator methods : */
	public static function loremIpsum($options = array()) {
		$min_size = isset($options['min']) ? $options['min'] : 0;
		$max_size = isset($options['max']) ? $options['max'] : 255;
		$lorem = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum libero dui nec ipsum.";
		return substr($lorem, 0, rand($min_size, $max_size));
	}
	
	/**
	 * Returning a html formated string, containing some html format code, like <h1>, <h2>, <p>, <b> etc
	 *
	 * @param $options using the options min_size and max_size
	 * @return String
	 */
	public static function html($options = array()) {
		$min_size = isset($options['min_size']) ? $options['min_size'] : 0;
		$max = isset($options['max']) ? $options['max'] : 255;
		$loremLarge = array(
				' dolor sit amet, consectetuer adipiscing elit.', 
				' phasellus suscipit, quam id pretium luctus, nulla lectus tempor odio, in ultricies est purus at lacus. Suspendisse potenti. Phasellus viverra laoreet mi. Cras aliquam orci vel justo. Morbi sit amet felis ac massa feugiat fermentum. Nulla elementum faucibus nisi. Mauris viverra, arcu ornare accumsan vestibulum, turpis pede rhoncus odio, at ultrices neque nisi scelerisque magna. Aenean eu neque. Vivamus quis mi quis dui fringilla consequat. Nulla libero purus, laoreet a, pretium vestibulum, dapibus a, enim. Phasellus et nisi.', 
				' hendrerit ligula nec magna. Sed tempus est nec lacus. Nunc urna metus, vulputate rutrum, tincidunt et, tincidunt eget, quam. Sed non ante. Integer elementum orci nec sem. Ut ac ante sed massa consectetuer aliquam. Sed velit ligula, cursus eget, dignissim quis, tempus sed, lorem. Pellentesque purus. Nunc id mauris. Donec dui. Mauris quis mauris sodales elit tincidunt feugiat. Etiam bibendum, sapien vitae ullamcorper suscipit, nulla metus convallis lacus, vitae aliquam lectus dui eu tellus. Nullam lobortis sollicitudin nulla. Aliquam erat volutpat. Integer tristique. Suspendisse eros. Sed venenatis facilisis lectus. Sed sed velit.', 
				' dictum, nisl vitae malesuada lobortis, diam risus eleifend pede, eget fringilla nibh leo in ligula. Integer ac quam at dolor placerat adipiscing. Mauris gravida commodo urna. Nunc hendrerit. Ut sit amet leo quis velit pellentesque posuere. Ut mollis ligula a nunc. Maecenas commodo, augue vitae sollicitudin auctor, arcu ligula accumsan nunc, vitae consequat leo purus sit amet ante. Aenean tempor nunc non massa. Praesent nonummy ornare felis. Etiam vel lectus sit amet eros commodo pellentesque. Nunc auctor sodales libero. Morbi massa.', 
				' pulvinar. Mauris consequat, massa non accumsan fringilla, urna libero laoreet risus, at luctus quam quam at enim. Aliquam erat volutpat. Vivamus eu sem sed dui placerat consectetuer. Vestibulum semper augue et nunc. Nunc lobortis enim sit amet erat. Etiam aliquet enim quis massa. Sed libero augue, dapibus non, vulputate ac, nonummy eget, metus. Donec tempus consectetuer ligula. Pellentesque posuere nisl. Mauris mi risus, tempor in, congue dictum, venenatis nec, odio. Nunc ante metus, interdum a, vulputate et, faucibus sed, justo.', 
				' euismod diam et sapien. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris eget nunc. In venenatis fringilla purus. Donec imperdiet, ipsum id posuere egestas, ligula ante porta neque, ut tempus neque nulla in nisl. Nulla vulputate tellus nec nulla. Nunc ut ipsum. Fusce consequat purus ut pede. Pellentesque augue elit, pulvinar ac, pulvinar id, blandit vitae, turpis. Vestibulum mattis convallis metus. In faucibus tortor sed risus. Integer feugiat mauris et urna. Integer laoreet sagittis neque. Cras id ante id ipsum congue aliquet. Suspendisse potenti. Duis est justo, euismod ac, aliquet a, tempor et, turpis. Donec tristique viverra tellus.', 
				' eget magna et odio tempor viverra. Phasellus hendrerit libero id quam. Integer eu massa sed nulla elementum vestibulum. Quisque eu pede. Quisque vestibulum. Aenean congue eros sit amet felis. Proin ullamcorper vulputate nunc. Donec ultricies eros non erat. Aliquam ultrices mi sed arcu. Maecenas pharetra. Etiam venenatis. Fusce id nunc. Phasellus ut lacus. Sed vitae nibh. Nulla ac nunc quis erat ullamcorper varius. Duis condimentum risus vitae nisl. Fusce nunc nulla, tincidunt id, aliquet sed, consequat eget, enim.');
		$loremSmall = array(
				' dolor sit amet, consectetuer adipiscing elit.', 
				' phasellus suscipit, quam id pretium luctus, nulla lectus tempor odio, in ultricies est purus at lacus.', 
				' suspendisse potenti. Phasellus viverra laoreet mi.', 
				' cras aliquam orci vel justo. Morbi sit amet felis ac massa feugiat fermentum.', 
				' nulla elementum faucibus nisi.', 
				' mauris viverra, arcu ornare accumsan vestibulum, turpis pede rhoncus odio.', 
				' aenean eu neque.', 
				' vivamus quis mi quis dui fringilla consequat.', 
				' nulla libero purus, laoreet a, pretium vestibulum, dapibus a, enim. Phasellus et nisi.', 
				' hendrerit ligula nec magna. Sed tempus est nec lacus.', 
				' nunc urna metus, vulputate rutrum, tincidunt et, tincidunt eget, quam. Sed non ante.', 
				' integer elementum orci nec sem. Ut ac ante sed massa consectetuer aliquam.', 
				' sed velit ligula, cursus eget, dignissim quis, tempus sed, lorem. Pellentesque purus.', 
				' nunc id mauris. Donec dui. Mauris quis mauris sodales elit tincidunt feugiat.', 
				' etiam bibendum, sapien vitae ullamcorper suscipit, nulla eu tellus.', 
				' nullam lobortis sollicitudin nulla. Aliquam erat volutpat.', 
				' integer tristique. Suspendisse eros. Sed venenatis facilisis lectus. Sed sed velit.', 
				' dictum, nisl vitae malesuada lobortis, diam risus eleifend pede, eget fringilla nibh leo in ligula.', 
				' integer ac quam at dolor placerat adipiscing. Mauris gravida commodo urna.', 
				' nunc hendrerit. Ut sit amet leo quis velit pellentesque posuere.');
		$loremWords = array(
				'proin', 
				'volutpat', 
				'lectus', 
				'sed', 
				'dui', 
				'maecenas', 
				'venenatis', 
				'commodo', 
				'nibh', 
				'vivamus', 
				'viverra', 
				'cursus', 
				'risus', 
				'praesent', 
				'is', 
				'sapien', 
				'at', 
				'nunc', 
				'sodales', 
				'laoreet', 
				'aenean', 
				'vel', 
				'massa', 
				'et', 
				'mauris', 
				'cursus', 
				'elementum', 
				'etiam', 
				'magna', 
				'eget', 
				'urna', 
				'euismod', 
				'ornare');
		$htmlSetOn = array(
				'<p>', 
				'<b>', 
				'<i>', 
				'<h1>', 
				'<h2>', 
				'<h3>', 
				'<h4>', 
				'<h5>', 
				'<div>', 
				'<span>', 
				'<left>', 
				'<right>', 
				'<center>', 
				'<strong>', 
				'<big>', 
				'<em>', 
				'<a href="" alt="">');
		$htmlSetOff = array(
				'</p>', 
				'</b>', 
				'</i>', 
				'</h1>', 
				'</h2>', 
				'</h3>', 
				'</h4>', 
				'</h5>', 
				'</div>', 
				'</span>', 
				'</left>', 
				'</right>', 
				'</center>', 
				'</strong>', 
				'</big>', 
				'</em>', 
				'</a>');
		
		$htmlLength = rand($min_size, $max);
		// Select the array to use, for small html parts use the small one
		$loremArrayToUse = ($htmlLength < 500 ? $loremSmall : $loremLarge);
		
		$returnString = '';
		// Less than 20 char don't format
		if ($htmlLength < 20) {
			$returnString = self::loremIpsum($options);
		}
		
		$htmlSet = rand(0, sizeof($htmlSetOn) - 1);
		
		$returnString = $htmlSetOn[$htmlSet];
		$returnString .= ucfirst($loremWords[rand(0, sizeof($loremWords) - 1)] . ' ' . $loremWords[rand(0, sizeof($loremWords) - 1)]);
		$returnString .= $htmlSetOff[$htmlSet];
		$bufferedString = '';
		
		$charCount = strlen($returnString);
		while ($charCount < $htmlLength) {
			$returnString .= $bufferedString;
			$htmlSet = rand(0, sizeof($htmlSetOn) - 1);
			
			$bufferedString = $htmlSetOn[$htmlSet];
			$bufferedString .= ucfirst($loremWords[rand(0, sizeof($loremWords) - 1)] . ' ' . $loremWords[rand(0, sizeof($loremWords) - 1)]);
			$bufferedString .= $htmlSetOff[$htmlSet];
			
			$htmlSet = rand(0, sizeof($htmlSetOn) - 1);
			$bufferedString .= $htmlSetOn[$htmlSet];
			$bufferedString .= ucfirst($loremWords[rand(0, sizeof($loremWords) - 1)] . ' ' . $loremWords[rand(0, sizeof($loremWords) - 1)]);
			$bufferedString .= $htmlSetOff[$htmlSet];
			$htmlSet = rand(0, sizeof($htmlSetOn) - 1);
			$bufferedString .= $htmlSetOn[$htmlSet];
			$bufferedString .= $loremArrayToUse[rand(0, sizeof($loremArrayToUse) - 1)];
			$bufferedString .= $htmlSetOff[$htmlSet];
			$charCount = (strlen($returnString) + strlen($bufferedString));
		}
		return $returnString;
	}
	/**  GENERATORS */
	
	/** STRING specific generators **/
	
	public static function generateEmail($options = array()) {
		if (isset($options['variable']) && is_string($options['variable'])) {
			$name = low(str_replace(' ', '.', $options['variable']));
			return $name . '@example.com';
		}
		if (isset($options['variable']) && is_array($options['variable'])) {
			$name = low(str_replace(' ', '.', implode('.', $options['variable'])));
			return $name . '@example.com';
		}
		$options['devider'] = '.';
		return strtolower(self::generateFirstname($options) . '.' . self::generateLastname($options) . '@example.com');
	}
	public static function generateUsername($options = array()) {
		if (isset($options['variable'])) {
			$name = explode(' ', $options['variable']);
			$name = low($name[0]);
			return $name . generate_random_alphanumeric_str('xx');
		}
		$fname = strtolower(self::generateFirstname(array('single' => true)));
		return $fname . generate_random_alphanumeric_str('xx');
	}
	public static function generatePassword($options = array()) {
		return Security::hash('pass', null, true);
	}
	public static function generatePhoneNumber($options = array()) {
		$syntax = isset($options['variable']) ? $options['variable'] : '(47) Xx xx xx xx';
		return generate_random_num_str($syntax);
	}
	public static function generateFullname($options = array()) {
		$dev = (isset($options['devider'])) ? $options['devider'] : ' ';
		return self::generateFirstname($options) . $dev . self::generateLastname($options);
	}
	public static function generateFirstname($options = array()) {
		$names = get_firstnames();
		if ((isset($options['single']) && $options['single']) || (isset($options['variable']) && $options['variable'] == 'single'))
			return get_random_name($names);
		$dev = (isset($options['devider'])) ? $options['devider'] : ' ';
		$ret = get_random_name($names);
		if (rand(1, 10) < 4)
			$ret .= $dev . get_random_name($names);
		if (rand(1, 10) < 1)
			$ret .= $dev . get_random_name($names);
		return $ret;
	}
	public static function generateLastname($options = array()) {
		$names = get_surnames();
		if ((isset($options['single']) && $options['single']) || (isset($options['variable']) && $options['variable'] == 'single'))
			return get_random_name($names);
		$dev = (isset($options['devider'])) ? $options['devider'] : ' ';
		$ret = get_random_name($names);
		if (rand(1, 10) < 4)
			$ret .= $dev . get_random_name($names);
		if (rand(1, 10) < 1)
			$ret .= $dev . get_random_name($names);
		return $ret;
	}
	public static function generateColor($options = array()) {
		$colors = get_colors();
		return get_random_color($colors);
	}
	public static function generateUrl($options = array()) {
		$urls = get_urls();
		return get_random_name($urls);
	}
	public static function generateStringLorem($options = array()) {
		$options['min_size'] = 1;
		$options['max'] = isset($options['max']) ? $options['max'] : (isset($options['max']) ? $options['max'] : 255);
		return self::loremIpsum($options);
	}
	/**
	 * Generates HTML content for a string. Adding some html formating code to the content
	 * $options min_size and max
	 * 
	 * @param array $options
	 * @return String
	 */
	public static function generateHtmlString($options = array()) {
		$options['min_size'] = 1;
		$options['max'] = isset($options['max']) ? $options['max'] : (isset($options['max']) ? $options['max'] : 255);
		return self::html($options);
	}
	/** INTEGER specific generators **/
	
	/**
	 * Return an integer
	 **
	 * 
	 * @param int $max maximum value, used to set the max for the different int types, 255 for tinyInt, 65535 for smallInt,  16777215 MediumInt, 4294967295 Int
	 * @param Array $options, the options in use is $options ['default'], $options ['max'], $options ['min'], $options ['unsinged']
	 * @return Int
	 */
	public static function createInt($max, $options = array()) {
		$smallMax = (($max + 1) / 2) - 1;
		if (isset($options['max']) || isset($options['min'])) {
			$max = isset($options['max']) ? $options['max'] : $smallMax;
			$min = isset($options['min']) ? $options['min'] : 0;
			return mt_rand($min, $max);
		} elseif (isset($options['unsigned'])) {
			if ($options['unsigned']) {
				return mt_rand(0, $max);
			} else {
				return mt_rand(0, $max) - $smallMax;
			}
		}
		return mt_rand(0, $smallMax);
	}
	/** SMALLINT specific generators **/
	
	public static function generateCountryCode($options = array()) {
		return rand(1, 235);
	}
	
	/** Float specfic generators **/
	public static function generateMoney($options = array()) {
		$options['variable'] = isset($options['variable']) && $options['variable'] != null ? $options['variable'] : "%01.2f";
		$options['min'] = isset($options['min']) && $options['min'] != null ? $options['min'] : 1;
		$options['max'] = isset($options['max']) && $options['max'] != null ? $options['max'] : 1250;
		return self::generateFloat($options);
	}
	/** Fallback generators **/
	
	public static function generateString($options = array()) {
		$max = isset($options['max']) ? $options['max'] : 255;
		/*
		$size = rand(0, $max);
		$str = 'L';
		for ($i = 0; $i < $size; $i++)
			$str .= 'l';
		return generate_random_alphanumeric_str($str);
*/
		return self::loremIpsum($options);
	}
	public static function generateInteger($options = array()) {
		//		A normal-size integer. The signed range is -2147483648 to 2147483647. The unsigned range is 0 to 4294967295.
		return self::createInt(4294967295, $options);
	}
	public static function generateTinyInt($options = array()) {
		//	A very small integer. The signed range is -128 to 127. The unsigned range is 0 to 255.
		return self::createInt(255, $options);
	}
	public static function generateBoolean($options = array()) {
		return rand(0, 1);
	}
	public static function generateMediumInt($options = array()) {
		//		A medium-sized integer. The signed range is -8388608 to 8388607. The unsigned range is 0 to 16777215.
		return self::createInt(16777215, $options);
	}
	public static function generateSmallInt($options = array()) {
		//		A small integer. The signed range is -32768 to 32767. The unsigned range is 0 to 65535.	
		return self::createInt(65535, $options);
	}
	public static function generateBigInt($options = array()) {
		//		A large integer. The signed range is -9223372036854775808 to 9223372036854775807. The unsigned range is 0 to 18446744073709551615 = 2^64 -1.
		// 		Dependant on underlying systems if using bigint in php, might differ from the mysql definition above.
		//		There is a number of known issues with BIGINT in PHP, so don not use it.
		

		$whatToDo = rand(1, 10);
		if ($whatToDo < 5) { // 40% chance to return a small number
			return rand(1, 200);
		} else if ($whatToDo < 6) { // 20% to return a slightly larger number
			return rand(1, 32768);
		}
		
		// 40% to return a very large number
		$bigFNumber = rand(0, 32767) * rand(1, 32768) * rand(1, 32768) * rand(1, 32768) * rand(1, 4); // max 2^63
		return sprintf("%.0f", $bigFNumber);
	}
	/**
	 * Generates a Floatingpoint number
	 *
	 * $options ['variable'] sets the display
	 * "%.8e"  output 8.1234567E-21
	 * "%.32f"  output  539588280000.00000000000000000000000000000000
	 * "%01.2f" output 123.00 typical  monney with two desimals
	 * "%.3e" output 3.142E+0 Scientific presession with 3 desimals
	 * 
	 * @param Array $options
	 * @return Stringrepresentation of the float
	 * 
	 */
	public static function generateFloat($options = array()) {
		//		A small (single-precision) floating-point number. Allowable values are -3.402823466E+38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E+38. 
		//		These are the theoretical limits, based on the IEEE standard. The actual range might be slightly smaller depending on your hardware or operating system.
		

		$numberOfDecimals = 9; // max 9
		$exponentMin = 38;
		$exponentMax = 38;
		
		$numberString = rand((isset($options['min'])) ? $options['min'] : 0, (isset($options['max'])) ? $options['max'] : 9) . '.';
		
		for ($i = 0; $i < $numberOfDecimals; $i++) {
			$numberString .= rand(0, 9);
		}
		
		$myFloat = floatval($numberString);
		
		$syntax = ((isset($options['variable']) && $options['variable'] != NULL) ? $options['variable'] : "%." . ($numberOfDecimals + 1) . "e");
		return sprintf($syntax, $myFloat); // 8.123456789E-21
	}
	public static function generateDouble($options = array()) {
		return 1;
	}
	public static function generateDecimal($options = array()) {
		return 1;
	}
	public static function generateDate($options = array()) {
		switch ($options['variable']) {
			case 'now' :
				return date('Y-m-d');
			break;
			case 'future' :
				$min_timestamp = time() + (60*60*24);
				if ($options['max'] != '') {
					$max_timestamp = strtotime($options['max']);
				} else {
					$max_timestamp = time() + (60*60*24*7*52);
				}	
			break;
			case 'past' :
				$max_timestamp = time() - (60*60*24);
				if ($options['min'] != '') {
					$min_timestamp = strtotime($options['min']);
				} else {
					$min_timestamp = time() - (60*60*24*7*52);
				}	
			break;
			default:
				if ($options['max'] != '') {
					$max_timestamp = strtotime($options['max']);
				} else {
					$max_timestamp = time() + (60*60*24*7*52);
				}			
				if ($options['min'] != '') {
					$min_timestamp = strtotime($options['min']);
				} else {
					$min_timestamp = time() - (60*60*24*7*52);
				}					
		}
		$timestamp = rand($min_timestamp,$max_timestamp);
		return date('Y-m-d',$timestamp);
	}
	
	public static function generateTime($options = array()) {		
		if ($options['max'] != '') {
			$arr = explode(' ',$options['max']);
			if (sizeof($arr) > 1) {
				$max = '1970-01-01 '.$arr[1];
			} else {
				$max = $options['max'];
			}
			$max_timestamp = strtotime($max);
		} else {
			$max_timestamp = strtotime('23:59:59');
		}			
		if ($options['min'] != '') {
			$arr = explode(' ',$options['min']);
			if (sizeof($arr) > 1) {
				$min = '1970-01-01 '.$arr[1];
			} else {
				$min = $options['min'];
			}
			$min_timestamp = strtotime($min);
		} else {
			$min_timestamp = strtotime('00:00:00');
		}	
		$timestamp = rand($min_timestamp, $max_timestamp);
		return date('H:i:s',$timestamp);
	}
	public static function generateDateTime($options = array()) {
		return self::generateDate($options) . ' ' . self::generateTime($options);
	}
	public static function generateTimestamp($options = array()) {
		return strtotime(self::generateDateTime($options));
	}
	public static function generateYear($options = array()) {
		if (isset($options['variable'])) {
			switch ($options['variable']){
				case 'now':
					return date('Y');
				break;
				case 'future':
					$now = date('Y');
					return rand($now, $now + 10);
				break;
				case 'past':
					$now = date('Y');
					return rand($now - 11, $now - 1);
				break;
			}
		}
		return rand(2000, 2009);
	}
	public static function generateText($options = array()) {
		if (!isset($options['min']))
			$options['min'] = 50;
		if (!isset($options['max']))
			$options['max'] = 5000;
		return self::loremIpsum($options);
	}
	public static function generateChar($options = array()) {
		$chars = array(
				'a', 
				'b', 
				'c', 
				'd', 
				'e', 
				'f', 
				'g', 
				'h', 
				'i', 
				'j', 
				'k', 
				'l', 
				'm', 
				'n', 
				'o', 
				'p', 
				'q', 
				'r', 
				's', 
				't', 
				'u', 
				'v', 
				'w', 
				'x', 
				'y', 
				'z');
		if (isset($options['variable']) && $options['variable'] == 'uppercase') {
			$chars = array(
					'A', 
					'B', 
					'C', 
					'D', 
					'E', 
					'F', 
					'G', 
					'H', 
					'I', 
					'J', 
					'K', 
					'L', 
					'M', 
					'N', 
					'O', 
					'P', 
					'Q', 
					'R', 
					'S', 
					'T', 
					'U', 
					'V', 
					'W', 
					'X', 
					'Y', 
					'Z');
		}
		return $chars[rand(0, 25)];
	}
	public static function generateTinyBlob($options = array()) {
		return 'a';
	}
	public static function generateTinyText($options = array()) {
		return 'a';
	}
	public static function generateBlob($options = array()) {
		return 'a';
	}
	public static function generateMediumBlob($options = array()) {
		return 'a';
	}
	public static function generateMediumText($options = array()) {
		return 'a';
	}
	public static function generateLongBlob($options = array()) {
		return 'a';
	}
	public static function generateLongText($options = array()) {
		return 'a';
	}
	
	public static function generateTitle($options = array()) {
		$max = (isset($options['max'])) ? $options['max'] : 255;
		$nouns = DummyDataSource::getNouns();
		$noun = $nouns[rand(0, count($nouns) - 1)];
		if ($max < 10) {
			return ucfirst($noun);
		}
		$adjectives = DummyDataSource::getAdjectives();
		$adj_count = count($adjectives);
		$adj = $adjectives[rand(0, $adj_count - 1)];
		$adj = ucfirst($adj);
		if ($max < 25) {
			return $adj . ' ' . $noun;
		}
		if ($max > 150 && rand(0, 2) == 1) {
			$adj2 = $adjectives[rand(0, $adj_count - 1)];
			$adj .= ' ' . $adj2;
		}
		
		if ($max > 200 && rand(0, 4) == 1) {
			$adj2 = $adjectives[rand(0, $adj_count - 1)];
			$adj .= ' ' . $adj2;
		}
		return $adj . ' ' . $noun;
	}
	
	public static function generateNoun($options = array()) {
		$nouns = DummyDataSource::getNouns();
		$noun = $nouns[rand(0, count($nouns) - 1)];
		return ucfirst($noun);
	}
	
	public static function generateVerb($options = array()) {
		$verbs = DummyDataSource::getVerbs();
		$verb = $verbs[rand(0, count($verbs) - 1)];
		return $verb;
	}
	
	public static function generateQoute($options = array()) {
		$qoutes = DummyDataSource::getQoutes();
		return $qoutes[rand(0, count($qoutes) - 1)];
	}
	
	public static function generateExtension($options = array()) {
		$extensions = DummyDataSource::get_file_extension();
		$extension = $extensions[rand(0, count($extensions) - 1)];
		return $extension;
	}
	
	public static function generateFilename($options = array()) {
		$extensions = DummyDataSource::get_file_extension();
		$extension = $extensions[rand(0, count($extensions) - 1)];
		return low(self::generateNoun($options) . '.' . self::generateExtension($options));
	}
	
	public static function generateBelongsTo($options = array()) {
		$key = 0;
		if (isset($options['variable'])) {
			$modelName = Inflector::camelize(Inflector::singularize($options['variable']));
			if (App::import('model', $modelName)) {
				$model = ClassRegistry::init($modelName, 'model');
			} else {
				$model = new Model(false, Inflector::tableize($modelName));
				$model->alias = $modelName;
			}
			if ($model) {
				$ids = $model->find('all', array('fields' => array('id'), 'limit' => 15));
				if (sizeof($ids) == 0) {
					return 0;
				}
				$key = $ids[rand(0, sizeof($ids) - 1)][$modelName]['id'];
			}
		}
		return $key;
	}

}
?>