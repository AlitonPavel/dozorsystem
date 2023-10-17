<?php

namespace app\commands\rbac;

use Yii;

class RoleController
{
    const roles = array(
        'admin'     => 'Администратор',
        'public'    => 'Менеджер',
        'guest'     => 'Гость (Роль по умолчанию)',
    );

    public static function getRoleName(string $role)
    {
        $role = mb_strtolower($role);
        $roles = self::roles[$role];
        return self::roles[$role] ?? null;
    }

    public static function getRolesByUser(int $userId)
    {
        return array_keys(Yii::$app->authManager->getRolesByUser($userId));
    }

    public static function getRoles()
    {
        return array_map(function ($role) {
            return $role->name;
        }, Yii::$app->authManager->getRoles());
    }

    public static function getAllRolesByUser(?int $userId)
    {
        if (isset($userId)) {
            $userRoles = self::getRolesByUser($userId);
        }
        else {
            $userRoles = [];
        }
        return array_map(function($role) use ($userRoles){
            if (in_array($role, $userRoles))
            {
                return ['role' => $role, 'checked' => true, 'rolename' => self::getRoleName($role)];
            }
            return ['role' => $role, 'checked' => false, 'rolename' => self::getRoleName($role)];
        }, self::getRoles());
    }

    public static function updateUserRoles(array $userRoles, int $userId)
    {
        foreach (self::getRoles() as $role)
        {
            $roleObj = Yii::$app->authManager->getRole($role);
            Yii::$app->authManager->revoke($roleObj, $userId);
            if (in_array($role, $userRoles))
            {
                Yii::$app->authManager->assign($roleObj, $userId);
            }
        }
    }
}