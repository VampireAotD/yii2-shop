<?php

use yii\db\Migration;

/**
 * Class m200322_132515_create_rbac_data
 */
class m200322_132515_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        //Permissions
        $createCategories = $auth->createPermission('createCategories');
        $auth->add($createCategories);
        $viewCategories = $auth->createPermission('viewCategories');
        $auth->add($viewCategories);
        $updateCategories = $auth->createPermission('updateCategories');
        $auth->add($updateCategories);
        $deleteCategories = $auth->createPermission('deleteCategories');
        $auth->add($deleteCategories);


        $createGoods = $auth->createPermission('createGoods');
        $auth->add($createGoods);
        $viewGoods = $auth->createPermission('viewGoods');
        $auth->add($viewGoods);
        $uploadImageGoods = $auth->createPermission('uploadImageGoods');
        $auth->add($uploadImageGoods);
        $updateGoods = $auth->createPermission('updateGoods');
        $auth->add($updateGoods);
        $deleteGoods = $auth->createPermission('deleteGoods');
        $auth->add($deleteGoods);

        $createSlide = $auth->createPermission('createSlide');
        $auth->add($createSlide);
        $viewSlider = $auth->createPermission('viewSlider');
        $auth->add($viewSlider);
        $updateSlider = $auth->createPermission('updateSlider');
        $auth->add($updateSlider);
        $deleteSlider = $auth->createPermission('deleteSlider');
        $auth->add($deleteSlider);

        $viewOrders = $auth->createPermission('viewOrders');
        $auth->add($viewOrders);
        $updateOrders = $auth->createPermission('updateOrders');
        $auth->add($updateOrders);
        $deleteOrders = $auth->createPermission('deleteOrders');
        $auth->add($deleteOrders);
        $approveOrder = $auth->createPermission('approveOrder');
        $auth->add($approveOrder);
        $dismissOrder = $auth->createPermission('dismissOrder');
        $auth->add($dismissOrder);

        $viewUsers = $auth->createPermission('viewUsers');
        $auth->add($viewUsers);
        $uploadImageUsers = $auth->createPermission('uploadImageUsers');
        $auth->add($uploadImageUsers);
        $updateUsers = $auth->createPermission('updateUsers');
        $auth->add($updateUsers);
        $deleteUsers = $auth->createPermission('deleteUsers');
        $auth->add($deleteUsers);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $moderator = $auth->createRole('moderator');
        $auth->add($moderator);

        $auth->addChild($moderator,$createCategories);
        $auth->addChild($moderator,$viewCategories);
        $auth->addChild($moderator,$updateCategories);
        $auth->addChild($moderator,$deleteCategories);

        $auth->addChild($moderator,$createGoods);
        $auth->addChild($moderator,$viewGoods);
        $auth->addChild($moderator,$uploadImageGoods);
        $auth->addChild($moderator,$updateGoods);
        $auth->addChild($moderator,$deleteGoods);

        $auth->addChild($moderator,$createSlide);
        $auth->addChild($moderator,$viewSlider);
        $auth->addChild($moderator,$updateSlider);
        $auth->addChild($moderator,$deleteSlider);

        $auth->addChild($moderator,$viewOrders);
        $auth->addChild($moderator,$updateOrders);
        $auth->addChild($moderator,$deleteOrders);
        $auth->addChild($moderator,$approveOrder);
        $auth->addChild($moderator,$dismissOrder);

        $auth->addChild($moderator,$viewUsers);

        $auth->addChild($admin,$moderator);
        $auth->addChild($admin,$uploadImageUsers);
        $auth->addChild($admin,$updateUsers);
        $auth->addChild($admin,$deleteUsers);

        $auth->assign($admin,1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200322_132515_create_rbac_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200322_132515_create_rbac_data cannot be reverted.\n";

        return false;
    }
    */
}
