<?php
/**
 * Paginator
 */
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\Paginator\Paginator;

// Create a Doctrine Collection
$collection = new ArrayCollection(range(1, 101));

// Create the paginator itself
$paginator = new Paginator(new Adapter($collection));

$paginator
    ->setCurrentPageNumber(1)
    ->setItemCountPerPage(5);
    
/**
 * Paginator(ORM)
 */
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

// Create a Doctrine Collection
$query = $em->createQuery('SELECT f FROM Foo f JOIN f.bar b');

// Create the paginator itself
$paginator = new Paginator(
    new DoctrinePaginator(new ORMPaginator($query))
);

$paginator
    ->setCurrentPageNumber(1)
    ->setItemCountPerPage(5);

/**
 * Object-exists Validator
 */
$repository = $objectManager
    ->getRepository('Application\Entity\User');

$validator = new \DoctrineModule\Validator\ObjectExists(array(
    'object_repository' => $repository,
    'fields' => array('email')
));

var_dump($validator->isValid('test@example.com'));
var_dump($validator->isValid(array(
    'email' => 'test@example.com'
)));


/**
 * Cache Adapter
 */
$zendCache = new \Zend\Cache\Storage\Adapter\Memory();
$cache = new \DoctrineModule\Cache\ZendStorageCache($zendCache);
//----------------------------------------------------------
$doctrineCache = new \Doctrine\Common\Cache\ArrayCache();
$options = new \Zend\Cache\Storage\Adapter\AdapterOptions();

$cache = new \DoctrineModule\Cache\DoctrineCacheStorage(
    $options,
    $doctrineCache
);

/**
 * Hydrator
 */
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

$hydrator = new DoctrineObject(
    $objectManager,
    'Application\Entity\City'
);

$city = new City();
$data = array('name' => 'Frankfurt');

$city = $hydrator->hydrate($data, $city);

echo $city->getName(); // prints "Frankfurt"

$dataArray = $hydrator->extract($city);
echo $dataArray['name']; // prints "Frankfurt"

/**
 * Hydrator 2
 */
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

$hydrator = new DoctrineObject(
    $objectManager,
    'Application\Entity\City'
);

$city = new City();
$data = array('country' => 123);

$city = $hydrator->hydrate($data, $city);

var_dump($city->getCountry());
// prints class Country#1 (1) {
//   protected $name => string(5) "Germany"
// }

/**
 * Form Elment
 */
$form->add(array(
    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
    'name' => 'user',
    'options' => array(
        'object_manager' => $objectManager,
        'target_class'   => 'Module\Entity\User',
        'property'       => 'fullName',
        'is_method'      => true,
        'find_method'    => array(
            'name'   => 'findBy',
            'params' => array(
                'criteria' => array('active' => 1),
                'orderBy'  => array('lastName' => 'ASC'),
            ),
        ),
    ),
));
 