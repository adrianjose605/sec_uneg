<?php

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger;

class Doctrine {

    public $em = null;

    public function __construct() {
        // load database configuration from CodeIgniter
        require_once APPPATH . 'config/database.php';

        // Set up class loading. You could use different autoloaders, provided by your favorite framework,
        // if you want to.
        require_once APPPATH . 'libraries/Doctrine/Common/ClassLoader.php';

        $doctrineClassLoader = new ClassLoader('Doctrine', APPPATH . 'libraries');
        $doctrineClassLoader -> register();

        $symfonyClassLoader = new ClassLoader('Symfony', APPPATH . 'libraries/Doctrine');
        $symfonyClassLoader -> register();

        $entitiesClassLoader = new ClassLoader('Entities', APPPATH . "models");
        $entitiesClassLoader -> register();
        
        $proxiesClassLoader = new ClassLoader('Proxies', APPPATH . "models");
        $proxiesClassLoader -> register();
        
        $extraClassLoader = new ClassLoader('DoctrineExtra', APPPATH . 'libraries');
        $extraClassLoader -> register();

        // Set up caches
        $config = new Configuration;
        $cache = new ArrayCache;

        $config -> setMetadataCacheImpl($cache);
        $driverImpl = $config -> newDefaultAnnotationDriver(array(APPPATH . 'models/Entities'));
        $config -> setMetadataDriverImpl($driverImpl);
        $config -> setQueryCacheImpl($cache);

        // Proxy configuration
        $config -> setProxyDir(APPPATH . '/models/Proxies');
        $config -> setProxyNamespace('Proxies');

        // Set up logger
        //$logger = new EchoSQLLogger;
        //$config->setSQLLogger($logger);

        $config -> setAutoGenerateProxyClasses(TRUE);

        // Database connection information
        $connectionOptions = array(
            'driver' => ($db['default']['dbdriver']=='mysqli')?'pdo_mysql':'pdo_pgsql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database']);

        $config->addCustomStringFunction('DATETRUNC', '\DoctrineExtra\DateTrunc');
            
        // Create EntityManager
        $this -> em = EntityManager::create($connectionOptions, $config);
    }

}
