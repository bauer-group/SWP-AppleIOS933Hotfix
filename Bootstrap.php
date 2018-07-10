<?php

/*
 * Documentation: 
 *  Bootstrapper for Apple iOS 9.3.3 Cart Hotfix Class
 *
 * References:
 *  http://community.shopware.com/Problemloesung-fuer-Apple-iOS-9.3.3-Update_detail_1936.html
 *  http://en.community.shopware.com/_detail_1937.html
 *
 */

class Shopware_Plugins_Core_BAUERGROUPAppleIOS933Hotfix_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
	//---------------------------------------------------------------------
	//Common Bootstrap Code START - Version 1.0
	//Setup START
    public function install()
    {			
		return $this->PluginInstall();
    }
	
	public function uninstall()
    {
		return $this->PluginUninstall();
    }
	
	public function update($version) 
	{
		return $this->PluginUpdate($version);
	}

	public function getCapabilities()
    {
        return array(
            'install' => true,
            'update' => true,
            'enable' => true
        );
    }
	//Setup END
	
	//Internals START
	private function GetPluginInformationValue($sValueName)
	{
		$pluginJSON = json_decode(file_get_contents($this->Path() . 'plugin.json'), true);

        if ($pluginJSON) {
            return $pluginJSON[$sValueName];
        } else {
            throw new Exception('The plugin has an invalid plugin.json file.');
        }
	}
	//Internals STOP
	
	//Informations START	
	public function getInfo()
    {
		return array(
            'label' => $this->getLabel(),
            'version' => $this->getVersion(),
			'copyright' => $this->GetPluginInformationValue('copyright'),
			'author' => $this->GetPluginInformationValue('author'),
            'link' => $this->GetPluginInformationValue('link'),
			'support' => $this->GetPluginInformationValue('support'),
            'description' => $this->GetPluginInformationValue('description')
        );
    }
	
	public function getLabel()
    {
        return $this->GetPluginInformationValue('label')['de'];
    }
 
    public function getVersion()
    {
		return $this->GetPluginInformationValue('currentVersion');
    }
	//Informations END
	//Common Bootstrap Code END
	//---------------------------------------------------------------------
	
	protected function PluginInstall()
	{
		if (!$this->assertVersionGreaterThen('5.0.0')) {
            throw new Exception("Shopware >= 5.0.0 is required");
        }
		
		try
		{
			$this->applyHotfix();
        }
		catch (Exception $e)
		{
            return array(
                'success' => false,
                'message' => 'Installationsfehler: ' . $e->getMessage()
            );
        }
		
        return array(
            'success' => true,
			'invalidateCache' => array('config', 'proxy', 'frontend', 'backend')
        );
	}
	
	protected function PluginUninstall()
	{
		try 
		{			
			$this->removeHotfix();
        }
		catch (Exception $e)
		{
            return array(
                'success' => false,
                'message' => 'Deinstallationsfehler: ' . $e->getMessage()
            );
        }
	
        return array(
            'success' => true,
			'invalidateCache' => array('config', 'proxy', 'frontend', 'backend')
        );
	}
	
	protected function PluginUpdate($sVersion)
	{
		switch($sVersion) 
		{
			case '0.1.0':
				
			case '0.1.1':
				
			default:				
				break;
		}
		
		return true;
	}
	
	private function applyHotfix()
    {			
		$sqlQuery = "INSERT INTO `s_core_config_values` (`element_id`, `shop_id`, `value`) VALUES(844, 1, 's:2768:\"antibot;appie;architext;bjaaland;digout4u;echo;fast-webcrawler;ferret;googlebot;gulliver;harvest;htdig;ia_archiver;jeeves;jennybot;linkwalker;lycos;mercator;moget;muscatferret;myweb;netcraft;nomad;petersnews;scooter;slurp;unlost_web_crawler;voila;voyager;webbase;weblayers;wget;wisenutbot;acme.spider;ahoythehomepagefinder;alkaline;arachnophilia;aretha;ariadne;arks;aspider;atn.txt;atomz;auresys;backrub;bigbrother;blackwidow;blindekuh;bloodhound;brightnet;bspider;cactvschemistryspider;cassandra;cgireader;checkbot;churl;cmc;collective;combine;conceptbot;coolbot;core;cosmos;cruiser;cusco;cyberspyder;deweb;dienstspider;digger;diibot;directhit;dnabot;download_express;dragonbot;dwcp;e-collector;ebiness;eit;elfinbot;emacs;emcspider;esther;evliyacelebi;nzexplorer;fdse;felix;fetchrover;fido;finnish;fireball;fouineur;francoroute;freecrawl;funnelweb;gama;gazz;gcreep;getbot;geturl;golem;grapnel;griffon;gromit;hambot;havindex;hometown;htmlgobble;hyperdecontextualizer;iajabot;ibm;iconoclast;ilse;imagelock;incywincy;informant;infoseek;infoseeksidewinder;infospider;inspectorwww;intelliagent;irobot;israelisearch;javabee;jbot;jcrawler;jobo;jobot;joebot;jubii;jumpstation;katipo;kdd;kilroy;ko_yappo_robot;labelgrabber.txt;larbin;linkidator;linkscan;lockon;logo_gif;macworm;magpie;marvin;mattie;mediafox;merzscope;meshexplorer;mindcrawler;momspider;monster;motor;mwdsearch;netcarta;netmechanic;netscoop;newscan-online;nhse;northstar;occam;octopus;openfind;orb_search;packrat;pageboy;parasite;patric;pegasus;perignator;perlcrawler;phantom;piltdownman;pimptrain;pioneer;pitkow;pjspider;pka;plumtreewebaccessor;poppi;portalb;puu;python;raven;rbse;resumerobot;rhcs;roadrunner;robbie;robi;robofox;robozilla;roverbot;rules;safetynetrobot;search_au;searchprocess;senrigan;sgscout;shaggy;shaihulud;sift;simbot;site-valet;sitegrabber;sitetech;slcrawler;smartspider;snooper;solbot;spanner;speedy;spider_monkey;spiderbot;spiderline;spiderman;spiderview;spry;ssearcher;suke;suntek;sven;tach_bw;tarantula;tarspider;techbot;templeton;teoma_agent1;titin;titan;tkwww;tlspider;ucsd;udmsearch;urlck;valkyrie;victoria;visionsearch;vwbot;w3index;w3m2;wallpaper;wanderer;wapspider;webbandit;webcatcher;webcopy;webfetcher;webfoot;weblinker;webmirror;webmoose;webquest;webreader;webreaper;websnarf;webspider;webvac;webwalk;webwalker;webwatch;whatuseek;whowhere;wired-digital;wmir;wolp;wombat;worm;wwwc;wz101;xget;awbot;bobby;boris;bumblebee;cscrawler;daviesbot;ezresult;gigabot;gnodspider;internetseer;justview;linkbot;linkchecker;nederland.zoek;perman;pompos;pooodle;redalert;shoutcast;slysearch;ultraseek;webcompass;yandex;robot;yahoo;bot;psbot;crawl;RSS;larbin;ichiro;Slurp;msnbot;bot;Googlebot;ShopWiki;Bot;WebAlta;;abachobot;architext;ask jeeves;frooglebot;googlebot;lycos;spider;HTTPClient\";');";
		
		$this->Application()->Db()->query($sqlQuery);

		Shopware()->Pluginlogger()->info('BAUERGROUPAppleIOS933Hotfix: Hotfix for for Apple iOS 9.3.3 applied.');
	}
	
	private function removeHotfix()
    {			
		$sqlQuery = "DELETE FROM `s_core_config_values` WHERE `s_core_config_values`.`element_id` = 844;";
		
		$this->Application()->Db()->query($sqlQuery);

		Shopware()->Pluginlogger()->info('BAUERGROUPAppleIOS933Hotfix: Hotfix for for Apple iOS 9.3.3 removed.');
	}	
}

?>
