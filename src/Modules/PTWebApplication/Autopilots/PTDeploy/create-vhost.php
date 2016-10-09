<?php

Namespace Core ;

class AutoPilotConfigured extends AutoPilot {

    public $steps ;

    public function __construct($params = null) {
        parent::__construct($params);
        $this->setSteps();
    }

    /* Steps */
    private function setSteps() {

        if (!isset($this->params["fpm-port"]) || !isset($this->params["app-slug"])) {
            $this->steps =
                array(
                    array ( "Logging" => array( "log" => array(
                        "log-message" => "Need to provide FPM Port and App Type"
                    ),),),
                    array ( "Shell" => array( "execute" => array(
                        "command" => "exit 1"
                    ),),),
                );
            return false ;
        }

        $fpm_port = $this->params['fpm-port'] ; # "6041"
        $app_slug = $this->params['app-slug'] ; # "build"
        $uc_app_slug = ucfirst($app_slug) ;
        $vhe_url = (isset($this->params['vhe-url'])) ? $this->params['vhe-url'] : $app_slug.'.pharaoh.tld' ;
        $vhe_ipport = (isset($this->params['vhe-ip-port'])) ? $this->params['vhe-ip-port'] : '127.0.0.1:80' ;

        $vhe_parts = explode(":", $vhe_ipport) ;
        $vhe_ip = $vhe_parts[0] ;

        $steps1 =
            array(

                array ( "Logging" => array( "log" => array( "log-message" => "Lets begin Configuration of a Pharaoh {$uc_app_slug} Web Interface"),),),

                array ( "Logging" => array( "log" => array( "log-message" => "Create Host file entry for $vhe_url", ), ), ),
                array ( "HostEditor" => array( "add" => array(
                    "guess" => true,
                    "host-name" => $vhe_url,
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Disable default Apache vhost", ), ), ),
                array ( "ApacheVHostEditor" => array( "disable-default" => array( "guess" => true, ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Lets Add our Pharaoh Build VHost" ),),),
                array ( "ApacheVHostEditor" => array( "add" => array(
                    "vhe-docroot" => PFILESDIR.'pt'.$app_slug.DS.'pt'.$app_slug.DS.'src'.DS.'Modules'.DS.'PostInput'.DS,
                    "guess" => true,
                    "vhe-url" => $vhe_url,
                    "vhe-ip-port" => $vhe_ipport,
//                    "vhe-vhost-dir" => "/etc/apache2/sites-available",
                    "vhe-template" => $this->getTemplateHTTP($app_slug, $fpm_port),
                ),),),

                array ( "Logging" => array( "log" => array( "log-message" => "Now lets restart Apache so we are serving our new proxy", ), ), ),
                array ( "ApacheControl" => array( "restart" => array( "guess" => true, ), ), ),

            );

        if (isset($this->params['enable-ssl'])) {
            $steps2 = array(

                array ( "Logging" => array( "log" => array( "log-message" => "Next Get a Lets Encrypt Certificate"), ) ),
                array ( "LetsEncrypt" => array( "sign" => array (
                    "webroot" => PFILESDIR.'pt'.$app_slug.DS.'pt'.$app_slug.DS.'src'.DS.'Modules'.DS.'PostInput',
                    "domain" => $vhe_url,
                    "cert-path" => "/etc/ssl/certificates",
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Now create our HTTPS Virtual host"), ) ),
                array ( "ApacheVHostEditor" => array( "add" => array (
                    "guess" => true,
                    "vhe-docroot" => PFILESDIR.'pt'.$app_slug.DS.'pt'.$app_slug.DS.'src'.DS.'Modules'.DS.'PostInput',
                    "vhe-url" => $vhe_url,
                    "vhe-ip-port" => $vhe_ip,
                    "vhe-vhost-dir" => "/etc/apache2/sites-available",
                    "vhe-template" => $this->getTemplateHTTPS($app_slug, $fpm_port),
                ), ), ),

                array ( "Logging" => array( "log" => array( "log-message" => "Now lets restart Apache so we are serving our new application version", ), ), ),
                array ( "ApacheControl" => array( "restart" => array(
                    "guess" => true,
                ), ), ),
            ) ;
        } else {
            $steps2 = array() ;
        }

        $steps3 =
            array(

                // End
                array ( "Logging" => array( "log" => array( "log-message" => "Apache Web Server for Pharaoh {$uc_app_slug} Complete"),),),

            );

        $this->steps = array_merge($steps1, $steps2, $steps3) ;

    }

    private function getTemplateHTTP($app_slug, $fpm_port) {

        $dir_section = $this->getA2DirSection() ;

        $template ='
 NameVirtualHost ****IP ADDRESS****
 <VirtualHost ****IP ADDRESS****>
   ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
 	DocumentRoot ****WEB ROOT****
 	<Directory ****WEB ROOT****>
 	'. $dir_section .'
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined


   <IfModule mod_fastcgi.c>
    <IfModule !mod_proxy_fcgi.c>

     AddHandler php5-fcgi .php
     Action php5-fcgi /php5-fcgi_'.$app_slug.'
     Alias /php5-fcgi_'.$app_slug.' /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.'
     FastCgiExternalServer /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.' -host 127.0.0.1:'.$fpm_port.' -pass-header Authorization

      <FilesMatch "\.php$">
          SetHandler php5-fcgi
      </FilesMatch>

     <Directory /usr/lib/cgi-bin>
 	'. $dir_section .'
      SetHandler fastcgi-script
     </Directory>

    </IfModule>
   </IfModule>

   <IfModule mod_proxy_fcgi.c>
     ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:'.$fpm_port.'/opt/pt'.$app_slug.'/pt'.$app_slug.'/src/Modules/PostInput/$1
   </IfModule>

 </VirtualHost> ' ;

        return $template ;
    }


    private function getTemplateHTTPS($app_slug, $fpm_port) {

        $dir_section = $this->getA2DirSection() ;

        $template ='
 NameVirtualHost ****IP ADDRESS****
 <VirtualHost ****IP ADDRESS****:80>
   ServerAdmin webmaster@localhost
 	ServerName ****SERVER NAME****
 	DocumentRoot ****WEB ROOT****
 	<Directory ****WEB ROOT****>
 	'. $dir_section .'
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined


   <IfModule mod_fastcgi.c>
    <IfModule !mod_proxy_fcgi.c>

     AddHandler php5-fcgi .php
     Action php5-fcgi /php5-fcgi_'.$app_slug.'
     Alias /php5-fcgi_'.$app_slug.' /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.'
     FastCgiExternalServer /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.' -host 127.0.0.1:'.$fpm_port.' -pass-header Authorization

      <FilesMatch "\.php$">
          SetHandler php5-fcgi
      </FilesMatch>

     <Directory /usr/lib/cgi-bin>
 	'. $dir_section .'
      SetHandler fastcgi-script
     </Directory>

    </IfModule>
   </IfModule>

   <IfModule mod_proxy_fcgi.c>
     ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:'.$fpm_port.'/opt/pt'.$app_slug.'/pt'.$app_slug.'/src/Modules/PostInput/$1
   </IfModule>

 </VirtualHost>


 NameVirtualHost ****IP ADDRESS****
 <VirtualHost ****IP ADDRESS****:443>
   ServerAdmin webmaster@localhost
   ServerName ****SERVER NAME****
   DocumentRoot ****WEB ROOT****
     SSLEngine on
 	 SSLCertificateFile /etc/ssl/certificates/****SERVER NAME****/cert.pem
     SSLCertificateKeyFile /etc/ssl/certificates/****SERVER NAME****/private.pem
     SSLCertificateChainFile /etc/ssl/certificates/****SERVER NAME****/fullchain.pem
 	<Directory ****WEB ROOT****>
 	'. $dir_section .'
 	</Directory>
   ErrorLog /var/log/apache2/error.log
   CustomLog /var/log/apache2/access.log combined


   <IfModule mod_fastcgi.c>
    <IfModule !mod_proxy_fcgi.c>

     AddHandler php5-fcgi .php
     Action php5-fcgi /php5-fcgi_'.$app_slug.'
     Alias /php5-fcgi_'.$app_slug.' /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.'
     FastCgiExternalServer /usr/lib/cgi-bin/php5-fcgi_pt'.$app_slug.' -host 127.0.0.1:'.$fpm_port.' -pass-header Authorization

      <FilesMatch "\.php$">
          SetHandler php5-fcgi
      </FilesMatch>

     <Directory /usr/lib/cgi-bin>
 	'. $dir_section .'
      SetHandler fastcgi-script
     </Directory>

    </IfModule>
   </IfModule>

   <IfModule mod_proxy_fcgi.c>
     ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:'.$fpm_port.'/opt/pt'.$app_slug.'/pt'.$app_slug.'/src/Modules/PostInput/$1
   </IfModule>

 </VirtualHost>
  ' ;

        return $template ;
    }

    private function getA2DirSection($cgi = null) {
        $cgiString = ($cgi !== null) ? "ExecCGI" : "" ;
        $comm = 'ptconfigure apacheserver version -yg' ;
        exec($comm, $output) ;
        foreach ($output as $outline) {
            $spos = strpos($outline, "Short Version: ") ;
            $lpos = $spos+15 ;
//            $rpos = strlen($outline);
            if ($spos !== false) {
//                var_dump($outline, substr($outline,$lpos) ,$lpos ) ;
                $sv = substr($outline,$lpos) ;  } }

        $svObject = new \Model\SoftwareVersion($sv) ;
        $compareObject = new \Model\SoftwareVersion("2.3.0") ;

//        var_dump("last", $sv, $svObject, $compareObject, $svObject->isLessThan($compareObject)) ;

        if ($svObject->isLessThan($compareObject)) {
            $section = '
            Options Indexes FollowSymLinks MultiViews '.$cgiString.'
            Order allow,deny
            Allow from all' ; }
        else {
            $section = '
            Options Indexes FollowSymLinks MultiViews '.$cgiString.'
            Require all granted' ; }
        return $section ;
    }

}
