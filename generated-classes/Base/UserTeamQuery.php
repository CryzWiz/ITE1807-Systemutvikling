<?php

namespace Base;

use \UserTeam as ChildUserTeam;
use \UserTeamQuery as ChildUserTeamQuery;
use \Exception;
use \PDO;
use Map\UserTeamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_team' table.
 *
 * 
 *
 * @method     ChildUserTeamQuery orderByUserId($order = Criteria::ASC) Order by the User_id column
 * @method     ChildUserTeamQuery orderByTeamId($order = Criteria::ASC) Order by the Team_id column
 * @method     ChildUserTeamQuery orderByIsteamleader($order = Criteria::ASC) Order by the isTeamleader column
 *
 * @method     ChildUserTeamQuery groupByUserId() Group by the User_id column
 * @method     ChildUserTeamQuery groupByTeamId() Group by the Team_id column
 * @method     ChildUserTeamQuery groupByIsteamleader() Group by the isTeamleader column
 *
 * @method     ChildUserTeamQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserTeamQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserTeamQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserTeamQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserTeamQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserTeamQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserTeamQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildUserTeamQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildUserTeamQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildUserTeamQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildUserTeamQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildUserTeamQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildUserTeamQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildUserTeamQuery leftJoinTeam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Team relation
 * @method     ChildUserTeamQuery rightJoinTeam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Team relation
 * @method     ChildUserTeamQuery innerJoinTeam($relationAlias = null) Adds a INNER JOIN clause to the query using the Team relation
 *
 * @method     ChildUserTeamQuery joinWithTeam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Team relation
 *
 * @method     ChildUserTeamQuery leftJoinWithTeam() Adds a LEFT JOIN clause and with to the query using the Team relation
 * @method     ChildUserTeamQuery rightJoinWithTeam() Adds a RIGHT JOIN clause and with to the query using the Team relation
 * @method     ChildUserTeamQuery innerJoinWithTeam() Adds a INNER JOIN clause and with to the query using the Team relation
 *
 * @method     \UserQuery|\TeamQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserTeam findOne(ConnectionInterface $con = null) Return the first ChildUserTeam matching the query
 * @method     ChildUserTeam findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserTeam matching the query, or a new ChildUserTeam object populated from the query conditions when no match is found
 *
 * @method     ChildUserTeam findOneByUserId(int $User_id) Return the first ChildUserTeam filtered by the User_id column
 * @method     ChildUserTeam findOneByTeamId(int $Team_id) Return the first ChildUserTeam filtered by the Team_id column
 * @method     ChildUserTeam findOneByIsteamleader(boolean $isTeamleader) Return the first ChildUserTeam filtered by the isTeamleader column *

 * @method     ChildUserTeam requirePk($key, ConnectionInterface $con = null) Return the ChildUserTeam by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserTeam requireOne(ConnectionInterface $con = null) Return the first ChildUserTeam matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserTeam requireOneByUserId(int $User_id) Return the first ChildUserTeam filtered by the User_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserTeam requireOneByTeamId(int $Team_id) Return the first ChildUserTeam filtered by the Team_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserTeam requireOneByIsteamleader(boolean $isTeamleader) Return the first ChildUserTeam filtered by the isTeamleader column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserTeam[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserTeam objects based on current ModelCriteria
 * @method     ChildUserTeam[]|ObjectCollection findByUserId(int $User_id) Return ChildUserTeam objects filtered by the User_id column
 * @method     ChildUserTeam[]|ObjectCollection findByTeamId(int $Team_id) Return ChildUserTeam objects filtered by the Team_id column
 * @method     ChildUserTeam[]|ObjectCollection findByIsteamleader(boolean $isTeamleader) Return ChildUserTeam objects filtered by the isTeamleader column
 * @method     ChildUserTeam[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserTeamQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserTeamQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\UserTeam', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserTeamQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserTeamQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserTeamQuery) {
            return $criteria;
        }
        $query = new ChildUserTeamQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$User_id, $Team_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUserTeam|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTeamTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserTeamTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserTeam A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT User_id, Team_id, isTeamleader FROM user_team WHERE User_id = :p0 AND Team_id = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUserTeam $obj */
            $obj = new ChildUserTeam();
            $obj->hydrate($row);
            UserTeamTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildUserTeam|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(UserTeamTableMap::COL_USER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(UserTeamTableMap::COL_USER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(UserTeamTableMap::COL_TEAM_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the User_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE User_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE User_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE User_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserTeamTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserTeamTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTeamTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the Team_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamId(1234); // WHERE Team_id = 1234
     * $query->filterByTeamId(array(12, 34)); // WHERE Team_id IN (12, 34)
     * $query->filterByTeamId(array('min' => 12)); // WHERE Team_id > 12
     * </code>
     *
     * @see       filterByTeam()
     *
     * @param     mixed $teamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByTeamId($teamId = null, $comparison = null)
    {
        if (is_array($teamId)) {
            $useMinMax = false;
            if (isset($teamId['min'])) {
                $this->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $teamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamId['max'])) {
                $this->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $teamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $teamId, $comparison);
    }

    /**
     * Filter the query on the isTeamleader column
     *
     * Example usage:
     * <code>
     * $query->filterByIsteamleader(true); // WHERE isTeamleader = true
     * $query->filterByIsteamleader('yes'); // WHERE isTeamleader = true
     * </code>
     *
     * @param     boolean|string $isteamleader The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByIsteamleader($isteamleader = null, $comparison = null)
    {
        if (is_string($isteamleader)) {
            $isteamleader = in_array(strtolower($isteamleader), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTeamTableMap::COL_ISTEAMLEADER, $isteamleader, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(UserTeamTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserTeamTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Team object
     *
     * @param \Team|ObjectCollection $team The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserTeamQuery The current query, for fluid interface
     */
    public function filterByTeam($team, $comparison = null)
    {
        if ($team instanceof \Team) {
            return $this
                ->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $team->getId(), $comparison);
        } elseif ($team instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserTeamTableMap::COL_TEAM_ID, $team->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTeam() only accepts arguments of type \Team or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Team relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function joinTeam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Team');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Team');
        }

        return $this;
    }

    /**
     * Use the Team relation Team object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeamQuery A secondary query class using the current class as primary query
     */
    public function useTeamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTeam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Team', '\TeamQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserTeam $userTeam Object to remove from the list of results
     *
     * @return $this|ChildUserTeamQuery The current query, for fluid interface
     */
    public function prune($userTeam = null)
    {
        if ($userTeam) {
            $this->addCond('pruneCond0', $this->getAliasedColName(UserTeamTableMap::COL_USER_ID), $userTeam->getUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(UserTeamTableMap::COL_TEAM_ID), $userTeam->getTeamId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_team table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTeamTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTeamTableMap::clearInstancePool();
            UserTeamTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTeamTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTeamTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserTeamTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserTeamTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserTeamQuery
