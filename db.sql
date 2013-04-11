CREATE TABLE `itunescounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pseudo` varchar(25) NOT NULL,
  `tps` int(11) NOT NULL,
  `tpstot` int(11) NOT NULL,
  `music` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `countgenre` int(11) NOT NULL,
  `mostlistened` varchar(255) NOT NULL,
  `countmostlistened` int(11) NOT NULL,
  `podcast` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;