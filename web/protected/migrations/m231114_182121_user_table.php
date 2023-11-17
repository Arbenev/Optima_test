<?php

class m231114_182121_user_table extends CDbMigration
{

    const TABLE_NAME = 'user';

    public function safeUp()
    {
        $columns = [
            'id' => 'INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'first_name' => 'varchar(50) NOT NULL',
            'middle_name' => 'varchar(50) NOT NULL',
            'last_name' => 'varchar(50) NOT NULL',
            'phone' => 'varchar(20) NOT NULL',
            'email' => 'varchar(256) NOT NULL',
            'login' => 'VARCHAR(32) NOT NULL DEFAULT ""',
            'password' => 'varchar(32) NOT NULL',
        ];
        $this->createTable(self::TABLE_NAME, $columns, 'ENGINE=InnoDB');
        $this->createIndex('UN_user_login', self::TABLE_NAME, ['login'], true);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
