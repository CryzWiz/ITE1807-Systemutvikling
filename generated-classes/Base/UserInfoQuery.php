<?php

namespace Base;

use \UserInfo as ChildUserInfo;
use \UserInfoQuery as ChildUserInfoQuery;
use \Exception;
use \PDO;
use Map\UserInfoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'userinfo' table.
 *
 * 
 *
 * @method     ChildUserInfoQuery orderByUserId($order = Criteria::ASC) Order by the User_id column
 * @method     ChildUserInfoQuery orderByWorkPhone($order = Criteria::ASC) Order by the Work_Phone column
 * @method     ChildUserInfoQuery orderByMobilePhone($order = Criteria::ASC) Order by the Mobile_Phone column
 * @method     ChildUserInfoQuery orderByCivilRegistrationNumber($order = Criteria::ASC) Order by the Civil_Registration_Number column
 * @method     ChildUserInfoQuery orderByBankaccount($order = Criteria::ASC) Order by the Bankaccount column
 * @method     ChildUserInfoQuery orderByAddress($order = Criteria::ASC) Order by the Address column
 * @method     ChildUserInfoQuery orderByPostcode($order = Criteria::ASC) Order by the PostCode column
 *
 * @method     ChildUserInfoQuery groupByUserId() Group by the User_id column
 * @method     ChildUserInfoQuery groupByWorkPhone() Group by the Work_Phone column
 * @method     ChildUserInfoQuery groupByMobilePhone() Group by the Mobile_Phone column
 * @method     ChildUserInfoQuery groupByCivilRegistrationNumber() Group by the Civil_Registration_Number column
 * @method     ChildUserInfoQuery groupByBankaccount() Group by the Bankaccount column
 * @method     ChildUserInfoQuery groupByAddress() Group by the Address column
 * @method     ChildUserInfoQuery groupByPostcode() Group by the PostCode column
 *
 * @method     ChildUserInfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserInfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserInfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserInfoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserInfoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserInfoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserInfoQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildUserInfoQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildUserInfoQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildUserInfoQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildUserInfoQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildUserInfoQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildUserInfoQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildUserInfoQuery leftJoinPostal($relationAlias = null) Adds a LEFT JOIN clause to the query using the Postal relation
 * @method     ChildUserInfoQuery rightJoinPostal($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Postal relation
 * @method     ChildUserInfoQuery innerJoinPostal($relationAlias = null) Adds a INNER JOIN clause to the query using the Postal relation
 *
 * @method     ChildUserInfoQuery joinWithPostal($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Postal relation
 *
 * @method     ChildUserInfoQuery leftJoinWithPostal() Adds a LEFT JOIN clause and with to the query using the Postal relation
 * @method     ChildUserInfoQuery rightJoinWithPostal() Adds a RIGHT JOIN clause and with to the query using the Postal relation
 * @method     ChildUserInfoQuery innerJoinWithPostal() Adds a INNER JOIN clause and with to the query using the Postal relation
 *
 * @method     \UserQuery|\PostalQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserInfo findOne(ConnectionInterface $con = null) Return the first ChildUserInfo matching the query
 * @method     ChildUserInfo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserInfo matching the query, or a new ChildUserInfo object populated from the query conditions when no match is found
 *
 * @method     ChildUserInfo findOneByUserId(int $User_id) Return the first ChildUserInfo filtered by the User_id column
 * @method     ChildUserInfo findOneByWorkPhone(string $Work_Phone) Return the first ChildUserInfo filtered by the Work_Phone column
 * @method     ChildUserInfo findOneByMobilePhone(string $Mobile_Phone) Return the first ChildUserInfo filtered by the Mobile_Phone column
 * @method     ChildUserInfo findOneByCivilRegistrationNumber(string $Civil_Registration_Number) Return the first ChildUserInfo filtered by the Civil_Registration_Number column
 * @method     ChildUserInfo findOneByBankaccount(string $Bankaccount) Return the first ChildUserInfo filtered by the Bankaccount column
 * @method     ChildUserInfo findOneByAddress(string $Address) Return the first ChildUserInfo filtered by the Address column
 * @method     ChildUserInfo findOneByPostcode(int $PostCode) Return the first ChildUserInfo filtered by the PostCode column *

 * @method     ChildUserInfo requirePk($key, ConnectionInterface $con = null) Return the ChildUserInfo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOne(ConnectionInterface $con = null) Return the first ChildUserInfo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserInfo requireOneByUserId(int $User_id) Return the first ChildUserInfo filtered by the User_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByWorkPhone(string $Work_Phone) Return the first ChildUserInfo filtered by the Work_Phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByMobilePhone(string $Mobile_Phone) Return the first ChildUserInfo filtered by the Mobile_Phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByCivilRegistrationNumber(string $Civil_Registration_Number) Return the first ChildUserInfo filtered by the Civil_Registration_Number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByBankaccount(string $Bankaccount) Return the first ChildUserInfo filtered by the Bankaccount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByAddress(string $Address) Return the first ChildUserInfo filtered by the Address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserInfo requireOneByPostcode(int $PostCode) Return the first ChildUserInfo filtered by the PostCode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserInfo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserInfo objects based on current ModelCriteria
 * @method     ChildUserInfo[]|ObjectCollection findByUserId(int $User_id) Return ChildUserInfo objects filtered by the User_id column
 * @method     ChildUserInfo[]|ObjectCollection findByWorkPhone(string $Work_Phone) Return ChildUserInfo objects filtered by the Work_Phone column
 * @method     ChildUserInfo[]|ObjectCollection findByMobilePhone(string $Mobile_Phone) Return ChildUserInfo objects filtered by the Mobile_Phone column
 * @method     ChildUserInfo[]|ObjectCollection findByCivilRegistrationNumber(string $Civil_Registration_Number) Return ChildUserInfo objects filtered by the Civil_Registration_Number column
 * @method     ChildUserInfo[]|ObjectCollection findByBankaccount(string $Bankaccount) Return ChildUserInfo objects filtered by the Bankaccount column
 * @method     ChildUserInfo[]|ObjectCollection findByAddress(string $Address) Return ChildUserInfo objects filtered by the Address column
 * @method     ChildUserInfo[]|ObjectCollection findByPostcode(int $PostCode) Return ChildUserInfo objects filtered by the PostCode column
 * @method     ChildUserInfo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserInfoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserInfoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'local', $modelName = '\\UserInfo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserInfoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserInfoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserInfoQuery) {
            return $criteria;
        }
        $query = new ChildUserInfoQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildUserInfo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserInfoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserInfoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserInfo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT User_id, Work_Phone, Mobile_Phone, Civil_Registration_Number, Bankaccount, Address, PostCode FROM userinfo WHERE User_id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUserInfo $obj */
            $obj = new ChildUserInfo();
            $obj->hydrate($row);
            UserInfoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserInfo|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the Work_Phone column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkPhone('fooValue');   // WHERE Work_Phone = 'fooValue'
     * $query->filterByWorkPhone('%fooValue%', Criteria::LIKE); // WHERE Work_Phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $workPhone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByWorkPhone($workPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($workPhone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_WORK_PHONE, $workPhone, $comparison);
    }

    /**
     * Filter the query on the Mobile_Phone column
     *
     * Example usage:
     * <code>
     * $query->filterByMobilePhone('fooValue');   // WHERE Mobile_Phone = 'fooValue'
     * $query->filterByMobilePhone('%fooValue%', Criteria::LIKE); // WHERE Mobile_Phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mobilePhone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByMobilePhone($mobilePhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mobilePhone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_MOBILE_PHONE, $mobilePhone, $comparison);
    }

    /**
     * Filter the query on the Civil_Registration_Number column
     *
     * Example usage:
     * <code>
     * $query->filterByCivilRegistrationNumber(1234); // WHERE Civil_Registration_Number = 1234
     * $query->filterByCivilRegistrationNumber(array(12, 34)); // WHERE Civil_Registration_Number IN (12, 34)
     * $query->filterByCivilRegistrationNumber(array('min' => 12)); // WHERE Civil_Registration_Number > 12
     * </code>
     *
     * @param     mixed $civilRegistrationNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByCivilRegistrationNumber($civilRegistrationNumber = null, $comparison = null)
    {
        if (is_array($civilRegistrationNumber)) {
            $useMinMax = false;
            if (isset($civilRegistrationNumber['min'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_CIVIL_REGISTRATION_NUMBER, $civilRegistrationNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($civilRegistrationNumber['max'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_CIVIL_REGISTRATION_NUMBER, $civilRegistrationNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_CIVIL_REGISTRATION_NUMBER, $civilRegistrationNumber, $comparison);
    }

    /**
     * Filter the query on the Bankaccount column
     *
     * Example usage:
     * <code>
     * $query->filterByBankaccount(1234); // WHERE Bankaccount = 1234
     * $query->filterByBankaccount(array(12, 34)); // WHERE Bankaccount IN (12, 34)
     * $query->filterByBankaccount(array('min' => 12)); // WHERE Bankaccount > 12
     * </code>
     *
     * @param     mixed $bankaccount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByBankaccount($bankaccount = null, $comparison = null)
    {
        if (is_array($bankaccount)) {
            $useMinMax = false;
            if (isset($bankaccount['min'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_BANKACCOUNT, $bankaccount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankaccount['max'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_BANKACCOUNT, $bankaccount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_BANKACCOUNT, $bankaccount, $comparison);
    }

    /**
     * Filter the query on the Address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE Address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE Address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the PostCode column
     *
     * Example usage:
     * <code>
     * $query->filterByPostcode(1234); // WHERE PostCode = 1234
     * $query->filterByPostcode(array(12, 34)); // WHERE PostCode IN (12, 34)
     * $query->filterByPostcode(array('min' => 12)); // WHERE PostCode > 12
     * </code>
     *
     * @see       filterByPostal()
     *
     * @param     mixed $postcode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByPostcode($postcode = null, $comparison = null)
    {
        if (is_array($postcode)) {
            $useMinMax = false;
            if (isset($postcode['min'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_POSTCODE, $postcode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postcode['max'])) {
                $this->addUsingAlias(UserInfoTableMap::COL_POSTCODE, $postcode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserInfoTableMap::COL_POSTCODE, $postcode, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(UserInfoTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserInfoTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
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
     * Filter the query by a related \Postal object
     *
     * @param \Postal|ObjectCollection $postal The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserInfoQuery The current query, for fluid interface
     */
    public function filterByPostal($postal, $comparison = null)
    {
        if ($postal instanceof \Postal) {
            return $this
                ->addUsingAlias(UserInfoTableMap::COL_POSTCODE, $postal->getPostcode(), $comparison);
        } elseif ($postal instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserInfoTableMap::COL_POSTCODE, $postal->toKeyValue('PrimaryKey', 'Postcode'), $comparison);
        } else {
            throw new PropelException('filterByPostal() only accepts arguments of type \Postal or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Postal relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function joinPostal($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Postal');

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
            $this->addJoinObject($join, 'Postal');
        }

        return $this;
    }

    /**
     * Use the Postal relation Postal object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostalQuery A secondary query class using the current class as primary query
     */
    public function usePostalQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPostal($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Postal', '\PostalQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserInfo $userInfo Object to remove from the list of results
     *
     * @return $this|ChildUserInfoQuery The current query, for fluid interface
     */
    public function prune($userInfo = null)
    {
        if ($userInfo) {
            $this->addUsingAlias(UserInfoTableMap::COL_USER_ID, $userInfo->getUserId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the userinfo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserInfoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserInfoTableMap::clearInstancePool();
            UserInfoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserInfoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserInfoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            UserInfoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            UserInfoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserInfoQuery
