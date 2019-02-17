<?php

use Base\Calendar as BaseCalendar;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for representing a row from the 'calendar' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Calendar extends BaseCalendar
{
    public static function createEvent($projectId, $userId, $eventName, $eventRegards, $eventLocation, $eventStart, $eventEnd){
        $con = Propel::getWriteConnection(\Map\CalendarTableMap::DATABASE_NAME);

        $event = new Calendar();

        $event->setName($eventName);
        $event->setProjectId($projectId);

        $event->setRegards($eventRegards);
        $event->setLocation($eventLocation);

        $start_date = strtr($eventStart, '/','-');
        $start_date =  date("Y-m-d", strtotime($start_date));
        $event->setStartDate($start_date);

        $end_date = strtr($eventEnd, '/','-');
        $end_date =  date("Y-m-d", strtotime($end_date));
        $event->setEndDate($end_date);

        $event->setUserId($userId);

        $message ="";

        $con->beginTransaction();

        if($event->save() != 0){
            $con->commit();
            $message = "true";
        }
        else{
            $message = "error";
        }

        return $message;
    }
}
