<?php

namespace Map;

use \User;
use \UserQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'local';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'user.id';

    /**
     * the column name for the UserName field
     */
    const COL_USERNAME = 'user.UserName';

    /**
     * the column name for the Password field
     */
    const COL_PASSWORD = 'user.Password';

    /**
     * the column name for the Email field
     */
    const COL_EMAIL = 'user.Email';

    /**
     * the column name for the FirstName field
     */
    const COL_FIRSTNAME = 'user.FirstName';

    /**
     * the column name for the LastName field
     */
    const COL_LASTNAME = 'user.LastName';

    /**
     * the column name for the Validated field
     */
    const COL_VALIDATED = 'user.Validated';

    /**
     * the column name for the Active field
     */
    const COL_ACTIVE = 'user.Active';

    /**
     * the column name for the Role field
     */
    const COL_ROLE = 'user.Role';

    /**
     * the column name for the Permanent field
     */
    const COL_PERMANENT = 'user.Permanent';

    /**
     * the column name for the pass_expires_at field
     */
    const COL_PASS_EXPIRES_AT = 'user.pass_expires_at';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'user.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'user.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Username', 'Password', 'Email', 'Firstname', 'Lastname', 'Validated', 'Active', 'Role', 'Permanent', 'PassExpiresAt', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'username', 'password', 'email', 'firstname', 'lastname', 'validated', 'active', 'role', 'permanent', 'passExpiresAt', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID, UserTableMap::COL_USERNAME, UserTableMap::COL_PASSWORD, UserTableMap::COL_EMAIL, UserTableMap::COL_FIRSTNAME, UserTableMap::COL_LASTNAME, UserTableMap::COL_VALIDATED, UserTableMap::COL_ACTIVE, UserTableMap::COL_ROLE, UserTableMap::COL_PERMANENT, UserTableMap::COL_PASS_EXPIRES_AT, UserTableMap::COL_CREATED_AT, UserTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'UserName', 'Password', 'Email', 'FirstName', 'LastName', 'Validated', 'Active', 'Role', 'Permanent', 'pass_expires_at', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Username' => 1, 'Password' => 2, 'Email' => 3, 'Firstname' => 4, 'Lastname' => 5, 'Validated' => 6, 'Active' => 7, 'Role' => 8, 'Permanent' => 9, 'PassExpiresAt' => 10, 'CreatedAt' => 11, 'UpdatedAt' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'username' => 1, 'password' => 2, 'email' => 3, 'firstname' => 4, 'lastname' => 5, 'validated' => 6, 'active' => 7, 'role' => 8, 'permanent' => 9, 'passExpiresAt' => 10, 'createdAt' => 11, 'updatedAt' => 12, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID => 0, UserTableMap::COL_USERNAME => 1, UserTableMap::COL_PASSWORD => 2, UserTableMap::COL_EMAIL => 3, UserTableMap::COL_FIRSTNAME => 4, UserTableMap::COL_LASTNAME => 5, UserTableMap::COL_VALIDATED => 6, UserTableMap::COL_ACTIVE => 7, UserTableMap::COL_ROLE => 8, UserTableMap::COL_PERMANENT => 9, UserTableMap::COL_PASS_EXPIRES_AT => 10, UserTableMap::COL_CREATED_AT => 11, UserTableMap::COL_UPDATED_AT => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'UserName' => 1, 'Password' => 2, 'Email' => 3, 'FirstName' => 4, 'LastName' => 5, 'Validated' => 6, 'Active' => 7, 'Role' => 8, 'Permanent' => 9, 'pass_expires_at' => 10, 'created_at' => 11, 'updated_at' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('user');
        $this->setPhpName('User');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\User');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('UserName', 'Username', 'VARCHAR', true, 45, null);
        $this->addColumn('Password', 'Password', 'VARCHAR', true, 256, null);
        $this->addColumn('Email', 'Email', 'VARCHAR', true, 45, null);
        $this->addColumn('FirstName', 'Firstname', 'VARCHAR', true, 15, null);
        $this->addColumn('LastName', 'Lastname', 'VARCHAR', true, 15, null);
        $this->addColumn('Validated', 'Validated', 'BOOLEAN', true, 1, false);
        $this->addColumn('Active', 'Active', 'BOOLEAN', true, 1, true);
        $this->addColumn('Role', 'Role', 'TINYINT', true, 1, 1);
        $this->addColumn('Permanent', 'Permanent', 'BOOLEAN', true, 1, true);
        $this->addColumn('pass_expires_at', 'PassExpiresAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TimeRegistration', '\\TimeRegistration', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':User_id',
    1 => ':id',
  ),
), null, null, 'TimeRegistrations', false);
        $this->addRelation('UserInfo', '\\UserInfo', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':User_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Calendar', '\\Calendar', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':User_id',
    1 => ':id',
  ),
), null, null, 'Calendars', false);
        $this->addRelation('UserTeam', '\\UserTeam', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':User_id',
    1 => ':id',
  ),
), null, null, 'UserTeams', false);
        $this->addRelation('ValidLink', '\\ValidLink', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }
    
    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();
    
        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UserTableMap::COL_ID);
            $criteria->addSelectColumn(UserTableMap::COL_USERNAME);
            $criteria->addSelectColumn(UserTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(UserTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UserTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_VALIDATED);
            $criteria->addSelectColumn(UserTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(UserTableMap::COL_ROLE);
            $criteria->addSelectColumn(UserTableMap::COL_PERMANENT);
            $criteria->addSelectColumn(UserTableMap::COL_PASS_EXPIRES_AT);
            $criteria->addSelectColumn(UserTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UserTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.UserName');
            $criteria->addSelectColumn($alias . '.Password');
            $criteria->addSelectColumn($alias . '.Email');
            $criteria->addSelectColumn($alias . '.FirstName');
            $criteria->addSelectColumn($alias . '.LastName');
            $criteria->addSelectColumn($alias . '.Validated');
            $criteria->addSelectColumn($alias . '.Active');
            $criteria->addSelectColumn($alias . '.Role');
            $criteria->addSelectColumn($alias . '.Permanent');
            $criteria->addSelectColumn($alias . '.pass_expires_at');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_ID) && $criteria->keyContainsValue(UserTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
