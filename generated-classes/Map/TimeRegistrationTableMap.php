<?php

namespace Map;

use \TimeRegistration;
use \TimeRegistrationQuery;
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
 * This class defines the structure of the 'timeregistration' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TimeRegistrationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TimeRegistrationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'local';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'timeregistration';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TimeRegistration';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TimeRegistration';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'timeregistration.id';

    /**
     * the column name for the User_id field
     */
    const COL_USER_ID = 'timeregistration.User_id';

    /**
     * the column name for the Team_id field
     */
    const COL_TEAM_ID = 'timeregistration.Team_id';

    /**
     * the column name for the Task_id field
     */
    const COL_TASK_ID = 'timeregistration.Task_id';

    /**
     * the column name for the Start field
     */
    const COL_START = 'timeregistration.Start';

    /**
     * the column name for the Stop field
     */
    const COL_STOP = 'timeregistration.Stop';

    /**
     * the column name for the Place field
     */
    const COL_PLACE = 'timeregistration.Place';

    /**
     * the column name for the PredefinedTask field
     */
    const COL_PREDEFINEDTASK = 'timeregistration.PredefinedTask';

    /**
     * the column name for the Comment field
     */
    const COL_COMMENT = 'timeregistration.Comment';

    /**
     * the column name for the Approved field
     */
    const COL_APPROVED = 'timeregistration.Approved';

    /**
     * the column name for the Active field
     */
    const COL_ACTIVE = 'timeregistration.Active';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'TeamId', 'TaskId', 'Start', 'Stop', 'Place', 'Predefinedtask', 'Comment', 'Approved', 'Active', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'teamId', 'taskId', 'start', 'stop', 'place', 'predefinedtask', 'comment', 'approved', 'active', ),
        self::TYPE_COLNAME       => array(TimeRegistrationTableMap::COL_ID, TimeRegistrationTableMap::COL_USER_ID, TimeRegistrationTableMap::COL_TEAM_ID, TimeRegistrationTableMap::COL_TASK_ID, TimeRegistrationTableMap::COL_START, TimeRegistrationTableMap::COL_STOP, TimeRegistrationTableMap::COL_PLACE, TimeRegistrationTableMap::COL_PREDEFINEDTASK, TimeRegistrationTableMap::COL_COMMENT, TimeRegistrationTableMap::COL_APPROVED, TimeRegistrationTableMap::COL_ACTIVE, ),
        self::TYPE_FIELDNAME     => array('id', 'User_id', 'Team_id', 'Task_id', 'Start', 'Stop', 'Place', 'PredefinedTask', 'Comment', 'Approved', 'Active', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'TeamId' => 2, 'TaskId' => 3, 'Start' => 4, 'Stop' => 5, 'Place' => 6, 'Predefinedtask' => 7, 'Comment' => 8, 'Approved' => 9, 'Active' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'teamId' => 2, 'taskId' => 3, 'start' => 4, 'stop' => 5, 'place' => 6, 'predefinedtask' => 7, 'comment' => 8, 'approved' => 9, 'active' => 10, ),
        self::TYPE_COLNAME       => array(TimeRegistrationTableMap::COL_ID => 0, TimeRegistrationTableMap::COL_USER_ID => 1, TimeRegistrationTableMap::COL_TEAM_ID => 2, TimeRegistrationTableMap::COL_TASK_ID => 3, TimeRegistrationTableMap::COL_START => 4, TimeRegistrationTableMap::COL_STOP => 5, TimeRegistrationTableMap::COL_PLACE => 6, TimeRegistrationTableMap::COL_PREDEFINEDTASK => 7, TimeRegistrationTableMap::COL_COMMENT => 8, TimeRegistrationTableMap::COL_APPROVED => 9, TimeRegistrationTableMap::COL_ACTIVE => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'User_id' => 1, 'Team_id' => 2, 'Task_id' => 3, 'Start' => 4, 'Stop' => 5, 'Place' => 6, 'PredefinedTask' => 7, 'Comment' => 8, 'Approved' => 9, 'Active' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('timeregistration');
        $this->setPhpName('TimeRegistration');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\TimeRegistration');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('User_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
        $this->addForeignKey('Team_id', 'TeamId', 'INTEGER', 'team', 'id', true, null, null);
        $this->addForeignKey('Task_id', 'TaskId', 'INTEGER', 'task', 'id', true, null, null);
        $this->addColumn('Start', 'Start', 'TIMESTAMP', false, null, null);
        $this->addColumn('Stop', 'Stop', 'TIMESTAMP', false, null, null);
        $this->addColumn('Place', 'Place', 'VARCHAR', false, 45, null);
        $this->addColumn('PredefinedTask', 'Predefinedtask', 'VARCHAR', false, 45, null);
        $this->addColumn('Comment', 'Comment', 'VARCHAR', false, 150, null);
        $this->addColumn('Approved', 'Approved', 'BOOLEAN', false, 1, false);
        $this->addColumn('Active', 'Active', 'VARCHAR', false, 10, 'false');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':User_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Task', '\\Task', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':Task_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Team', '\\Team', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':Team_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

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
        return $withPrefix ? TimeRegistrationTableMap::CLASS_DEFAULT : TimeRegistrationTableMap::OM_CLASS;
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
     * @return array           (TimeRegistration object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TimeRegistrationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TimeRegistrationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TimeRegistrationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TimeRegistrationTableMap::OM_CLASS;
            /** @var TimeRegistration $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TimeRegistrationTableMap::addInstanceToPool($obj, $key);
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
            $key = TimeRegistrationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TimeRegistrationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TimeRegistration $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TimeRegistrationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_ID);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_USER_ID);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_TEAM_ID);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_TASK_ID);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_START);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_STOP);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_PLACE);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_PREDEFINEDTASK);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_COMMENT);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_APPROVED);
            $criteria->addSelectColumn(TimeRegistrationTableMap::COL_ACTIVE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.User_id');
            $criteria->addSelectColumn($alias . '.Team_id');
            $criteria->addSelectColumn($alias . '.Task_id');
            $criteria->addSelectColumn($alias . '.Start');
            $criteria->addSelectColumn($alias . '.Stop');
            $criteria->addSelectColumn($alias . '.Place');
            $criteria->addSelectColumn($alias . '.PredefinedTask');
            $criteria->addSelectColumn($alias . '.Comment');
            $criteria->addSelectColumn($alias . '.Approved');
            $criteria->addSelectColumn($alias . '.Active');
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
        return Propel::getServiceContainer()->getDatabaseMap(TimeRegistrationTableMap::DATABASE_NAME)->getTable(TimeRegistrationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TimeRegistrationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TimeRegistrationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TimeRegistrationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TimeRegistration or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TimeRegistration object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TimeRegistrationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TimeRegistration) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TimeRegistrationTableMap::DATABASE_NAME);
            $criteria->add(TimeRegistrationTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TimeRegistrationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TimeRegistrationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TimeRegistrationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the timeregistration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TimeRegistrationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TimeRegistration or Criteria object.
     *
     * @param mixed               $criteria Criteria or TimeRegistration object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TimeRegistrationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TimeRegistration object
        }

        if ($criteria->containsKey(TimeRegistrationTableMap::COL_ID) && $criteria->keyContainsValue(TimeRegistrationTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TimeRegistrationTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TimeRegistrationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TimeRegistrationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TimeRegistrationTableMap::buildTableMap();
