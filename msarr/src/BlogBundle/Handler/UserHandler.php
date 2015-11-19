<?php


namespace BlogBundle\Handler;

use BlogBundle\Entiy\User;

class UserHandler
{
    public function getBlogRolesArray()
    {
        return array(
            'ROLE_BLOG_ADMIN' => 'Administrator',
            'ROLE_BLOG_EDITOR' => 'Editor',
            'ROLE_BLOG_AUTHOR' => 'Author',
            'ROLE_BLOG_CONTRIBUTOR' => 'Contributor'
        );
    }

    public function getDefaultBlogRole( BlogUser $user)
    {
        $role = "ROLE_BLOG_CONTRIBUTOR";

        if($user->hasRole('ROLE_BLOG_ADMIN'))
        {
            return 'ROLE_BLOG_ADMIN';
        }
        elseif($user->hasRole('ROLE_BLOG_EDITOR'))
        {
            return 'ROLE_BLOG_EDITOR';
        }
        elseif($user->hasRole('ROLE_BLOG_AUTHOR'))
        {
            return 'ROLE_BLOG_AUTHOR';
        }

        return $role;
    }


    public function getDefaultBlogRoleName( BlogUser $user)
    {
        $role = $this->getDefaultBlogRole($user);
        $roleArray = explode('_', $role);
        $role = strtolower($roleArray[ count($roleArray) -1 ]);

        return ucfirst($role);
    }

    /**
     * Revokes all edBlog administration roles
     *
     * @param $user
     * @return mixed
     */
    public function revokeBlogRoles(&$user)
    {
        $user
            ->removeRole('ROLE_BLOG_USER')
            ->removeRole('ROLE_BLOG_ADMIN')
            ->removeRole('ROLE_BLOG_EDITOR')
            ->removeRole('ROLE_BLOG_AUTHOR')
            ->removeRole('ROLE_BLOG_CONTRIBUTOR');

        return $user;
    }
}