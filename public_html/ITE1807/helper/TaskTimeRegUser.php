<?php

/**
 * Created by PhpStorm.
 * User: nor28349
 * Date: 11.04.2017
 * Time: 22:02
 */

require_once(dirname(__DIR__, 1) . "/global_init.php");

class TaskTimeRegUser implements Serializable
{
    public $timeRegId;
    public $timeRegUserId;
    public $timeRegTaskId;
    public $timeRegStart;
    public $timeRegStop;
    public $taskProjectId;
    public $taskName;
    public $taskPlannedhours;

    public function __construct(){
    }

    public static function create(TimeRegistration $hours){
        $hourDTO = new TaskTimeRegUser();
        if($hours==null)
            return $hourDTO;

        $hourDTO->timeRegId = $hours->getId();
        $hourDTO->timeRegUserId = $hours->getUserId();
        $hourDTO->timeRegTaskId = $hours->getTaskId();
        $hourDTO->timeRegStart = $hours->getStart()? $hours->getStart()->format("Y-m-d H:i:s"): '';
        $hourDTO->timeRegStop = $hours->getStop()? $hours->getStop()->format("Y-m-d H:i:s") : '';
        $hourDTO->taskName = $hours->getTask()->getName();
        $hourDTO->taskPlannedhours = $hours->getTask()->getPlannedhours();

        return $hourDTO;

    }

    public static function sumRegHours($obj){
        // her må vi summere stop-start basert på task_id
        /*
         *     res: [
        { y: 'taskName', a: PlannedHours, b: sumHours_per_TaskId },

           ],
         */

        $res = [];
        $data = array();
        $sum_hours_by_id = [];
        $tasks_names = [];
        $tasks_estimated_hours = [];
        $i = 0;
        foreach($obj as $p){
            $prj= TaskTimeRegUser::create($p);
            //finding time difference in hours
            $startDate = new DateTime($prj->timeRegStart);
            $stopDate = new DateTime($prj->timeRegStop);
            $diff = $stopDate->diff($startDate);
            $diff_in_hrs = $diff->h + ($diff->days * 24) + ($diff->i / 60);

            if (isset($sum_hours_by_id[$prj->timeRegTaskId]) && $sum_hours_by_id[$prj->timeRegTaskId] > 0){
                $sum_hours_by_id[$prj->timeRegTaskId] = $sum_hours_by_id[$prj->timeRegTaskId] + $diff_in_hrs;

            }

            else{
                $tasks_names[$prj->timeRegTaskId] = $prj->taskName;
                $tasks_estimated_hours[$prj->timeRegTaskId] = $prj->taskPlannedhours;
                $sum_hours_by_id[$prj->timeRegTaskId] = $diff_in_hrs;
            }

            //echo $diff_in_hrs . " hours \n";
            //$data[] = array('y' => $prj->taskName, 'a' => $prj->taskPlannedhours, 'b' => $diff_in_hrs);

            array_push($res,$prj);

        }

        //$data[] = array('y' => $tasks_names, 'a' => $tasks_estimated_hours, 'b' =>  $sum_hours_by_id);
        //var_dump(json_encode($data));
        /*$data['y'] = $tasks_names;
        $data['a'] = $tasks_estimated_hours;
        $data['b'] = $sum_hours_by_id;*/
        //$data = json_encode(array_map(null, $tasks_names, $tasks_estimated_hours, $sum_hours_by_id));
        //$data = array('y' => $data['y'], 'a' => $data['a'], 'b' => $data['b']);

        for ($i =1; $i <= count($tasks_names); $i++){
            $data[] = array('y' => $tasks_names[$i], 'a' => $tasks_estimated_hours[$i], 'b' => $sum_hours_by_id[$i]);

        }
        //var_dump(json_encode(array_map(null, $tasks_names, $tasks_estimated_hours, $sum_hours_by_id)));
        //var_dump($sum_hours_by_id);

        //var_dump(json_encode($data));

        return json_encode($data);

    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}