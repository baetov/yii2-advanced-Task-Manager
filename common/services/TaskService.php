<?php
namespace common\services;
use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use Yii;
use yii\base\Component;
use yii\base\Event;
/**
 * Class TakeTaskEvent
 * @package common\services
 */
class TakeCompleteTaskEvent extends Event {
    /**
     * @var Project $project
     */
    public $project;
    /**
     * @var User $user
     */
    public $user;
    /**
     * @var Task $task
     */
    public $task;
}
/**
 * Class TaskService
 * @package common\services
 */
class TaskService extends Component
{
    const EVENT_TAKE_TASK = 'event_take_task';
    const EVENT_COMPLETE_TASK = 'event_complete_task';
    /**
     * @param Project $project
     * @param User $user
     * @return bool
     */
    public function canManage(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }
    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canTake(Task $task, User $user)
    {
        return (\Yii::$app->projectService->hasRole($task->project, $user, ProjectUser::ROLE_DEVELOPER) &&
            is_null($task->executor_id));
    }
    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canComplete(Task $task, User $user)
    {
        return (\Yii::$app->user->id === $task->executor_id) && is_null($task->completed_at);
    }
    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function takeTask(Task $task, User $user)
    {
        $task->executor_id = $user->id;
        $task->started_at = time();
        return $task->save();
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function CompleteTask(Task $task)
    {
        $task->completed_at = time();
        return $task->save();
    }


}