<?php
namespace tbollmeier\realworld\backend\model;

use tbollmeier\webappfound\db\EntityDefinition;

class UserDef extends EntityDefinition
{
    public function __construct()
    {
        parent::__construct("users");
        
        $this
            ->newField("email")->add()
            ->newField("name")->add()
            ->newField("passwordHash")
                ->setDbAlias("password_hash")
                ->add()
            ->newField("bio")->add()
            ->newField("imageUrl")
                ->setDbAlias("image_url")
                ->add()
            ->newAssociation("followers", UserDef::class)
                ->setIsComposition(false)
                ->setLinkTable("followers")
                ->setSourceIdField("followed_id")
                ->setTargetIdField("follower_id")
                ->setReadonly(true)
                ->add()
            ->newAssociation("following", UserDef::class)
                ->setIsComposition(false)
                ->setLinkTable("followers")
                ->setSourceIdField("follower_id")
                ->setTargetIdField("followed_id")
                ->add();
    }

    public function findByEmail($email)
    {
        $users = $this->query([
            "filter" => "email = :email",
            "params" => [":email" => $email]
        ]);
        
        return count($users) !== 0 ? $users[0] : null;
    }
    
}

