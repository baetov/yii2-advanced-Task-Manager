<?php

namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
use yii\base\Component;
use common\models\User;
use yii\base\Event;

class AssignRoleEvent extends Event
{
    /**
     * @var Project
     */
    public $project;
    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $role;

    public function dump()
    {
        return [
            'project' => $this->project->id,
            'user'    => $this->user->id,
            'role'    => $this->role
        ];
    }
}

class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    public function getRoles(Project $project, User $user)
    {
        return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    }
    /**
     * @return array
     */
    public function getAllRoles () {
        return ProjectUser::find()
            ->select('role')
            ->byUser(Yii::$app->user->id)
            ->column();
    }

    public function hasRole(Project $project, User $user, $role)
    {
        return in_array($role, $this->getRoles($project, $user));
    }

}