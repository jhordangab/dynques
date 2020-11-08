<?php

use yii\db\Migration;
use yii\db\Schema;

class m181226_164259_token_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') 
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $sql = <<<SQL

            CREATE TABLE `dq_user` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `cell` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `description` text COLLATE utf8_unicode_ci,
              `is_active` tinyint(1) NOT NULL DEFAULT '1',
              `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              `created_by` int(11) DEFAULT NULL,
              `updated_by` int(11) DEFAULT NULL,
              `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SQL;

        $this->execute($sql);

        $this->createTable('{{%dq_user_token}}',
        [
            'id' => Schema::TYPE_PK,
            'id_user' => Schema::TYPE_INTEGER . ' not null',
            'token' => Schema::TYPE_STRING . ' not null',
            'is_used' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
            'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
            'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
            'created_at' => Schema::TYPE_TIMESTAMP . ' null',
        ], $tableOptions);

        $this->addForeignKey('dq_usto_usua_fk', '{{%dq_user_token}}', 'id_user', '{{%dq_user}}', 'id');

        return true;
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%dq_user_token}}');
        $this->dropTable('{{%dq_user}}');

        return true;
    }
}
