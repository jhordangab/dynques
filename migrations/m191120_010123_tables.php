<?php

use yii\db\Migration;
use yii\db\Schema;

class m191120_010123_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dq_form}}',
            [
                'id' => Schema::TYPE_PK,
                'id_user' => Schema::TYPE_INTEGER . ' not null',
                'name' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'javascript' => Schema::TYPE_TEXT . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null'
            ], $tableOptions);

        $this->addForeignKey("dq_form_usua_fk", "{{%dq_form}}", "id_user", "{{%dq_user}}", "id");

        $this->createTable('{{%dq_form_question}}',
            [
                'id' => $this->primaryKey(),
                'id_form' => Schema::TYPE_INTEGER . ' not null',
                'order' => Schema::TYPE_INTEGER . ' not null',
                'name' => Schema::TYPE_STRING . ' not null',
                'type' => Schema::TYPE_STRING . ' not null',
                'help' => Schema::TYPE_STRING . ' null',
                'default' => Schema::TYPE_STRING . ' null',
                'size' => Schema::TYPE_INTEGER . ' null',
                'is_mandatory' => Schema::TYPE_BOOLEAN . ' not null default true',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null'
            ], $tableOptions);

        $this->addForeignKey("dq_form_fope_fk", '{{%dq_form_question}}', 'id_form', '{{%dq_form}}', 'id');

        $this->createTable('{{%dq_form_question_option}}',
            [
                'id' => $this->primaryKey(),
                'id_question' => Schema::TYPE_INTEGER . ' not null',
                'code' => Schema::TYPE_STRING . ' not null',
                'value' => Schema::TYPE_STRING . ' not null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null'
            ], $tableOptions);

        $this->addForeignKey("dq_fpop_perg_fk", '{{%dq_form_question_option}}', 'id_question', '{{%dq_form_question}}', 'id');

        $this->createTable('{{%dq_area}}',
            [
                'id' => Schema::TYPE_PK,
                'id_user' => Schema::TYPE_INTEGER . ' not null',
                'order' => Schema::TYPE_INTEGER . ' not null',
                'name' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey('dq_area_usua_fk', '{{%dq_area}}', 'id_user', '{{%dq_user}}', 'id');

        $this->createTable('{{%dq_quiz}}',
            [
                'id' => Schema::TYPE_PK,
                'id_area' => Schema::TYPE_INTEGER . ' not null',
                'id_user' => Schema::TYPE_INTEGER . ' not null',
                'order' => Schema::TYPE_INTEGER . ' not null',
                'name' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_ques_area_fk", "{{%dq_quiz}}", "id_area", "{{%dq_area}}", "id");
        $this->addForeignKey('dq_ques_usua_fk', '{{%dq_quiz}}', 'id_user', '{{%dq_user}}', 'id');


        $this->createTable('{{%dq_category}}',
            [
                'id' => Schema::TYPE_PK,
                'id_user' => Schema::TYPE_INTEGER . ' not null',
                'name' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_cate_usua_fk", "{{%dq_category}}", "id_user", "{{%dq_user}}", "id");

        $this->createTable('{{%dq_quiz_question}}',
            [
                'id' => Schema::TYPE_PK,
                'id_quiz' => Schema::TYPE_INTEGER . ' not null',
                'id_category' => Schema::TYPE_INTEGER . ' null',
                'order' => Schema::TYPE_INTEGER . ' not null',
                'title' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_qupe_ques_fk", "{{%dq_quiz_question}}", "id_quiz", "{{%dq_quiz}}", "id");
        $this->addForeignKey("dq_qupe_cate_fk", "{{%dq_quiz_question}}", "id_category", "{{%dq_category}}", "id");

        $this->createTable('{{%dq_quiz_question_option}}',
            [
                'id' => Schema::TYPE_PK,
                'id_question' => Schema::TYPE_INTEGER . ' not null',
                'id_form' => Schema::TYPE_INTEGER . ' null',
                'id_category' => Schema::TYPE_INTEGER . ' null',
                'order' => Schema::TYPE_INTEGER . ' not null',
                'title' => Schema::TYPE_STRING . ' not null',
                'description' => Schema::TYPE_TEXT . ' null',
                'id_next_question' => Schema::TYPE_INTEGER . ' null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_peop_perg_fk", "{{%dq_quiz_question_option}}", "id_question", "{{%dq_quiz_question}}", "id");
        $this->addForeignKey("dq_peop_cate_fk", "{{%dq_quiz_question_option}}", "id_category", "{{%dq_category}}", "id");
        $this->addForeignKey("dq_peop_prpe_fk", "{{%dq_quiz_question_option}}", "id_next_question", "{{%dq_quiz_question}}", "id");
        $this->addForeignKey("dq_peop_form_fk", "{{%dq_quiz_question_option}}", "id_form", "{{%dq_form}}", "id");

        $this->createTable('{{%dq_app_quiz}}',
            [
                'id' => Schema::TYPE_PK,
                'id_quiz' => Schema::TYPE_INTEGER . ' not null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_apqu_ques_fk", "{{%dq_app_quiz}}", "id_quiz", "{{%dq_quiz}}", "id");

        $this->createTable('{{%dq_app_quiz_answer}}',
            [
                'id' => Schema::TYPE_PK,
                'id_app_quiz' => Schema::TYPE_INTEGER . ' not null',
                'id_question' => Schema::TYPE_INTEGER . ' not null',
                'id_option' => Schema::TYPE_INTEGER . ' not null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_aqre_apqu_fk", "{{%dq_app_quiz_answer}}", "id_app_quiz", "{{%dq_app_quiz}}", "id");
        $this->addForeignKey("dq_aqre_perg_fk", "{{%dq_app_quiz_answer}}", "id_question", "{{%dq_quiz_question}}", "id");
        $this->addForeignKey("dq_aqre_opca_fk", "{{%dq_app_quiz_answer}}", "id_option", "{{%dq_quiz_question_option}}", "id");

        $this->createTable('{{%dq_app_form_answer}}',
            [
                'id' => Schema::TYPE_PK,
                'id_app_quiz_answer' => Schema::TYPE_INTEGER . ' not null',
                'id_form' => Schema::TYPE_INTEGER . ' not null',
                'id_question' => Schema::TYPE_INTEGER . ' not null',
                'is_active' => Schema::TYPE_BOOLEAN . ' not null default TRUE',
                'is_deleted' => Schema::TYPE_BOOLEAN . ' not null default FALSE',
                'created_at' => Schema::TYPE_TIMESTAMP . ' null',
                'updated_at' => Schema::TYPE_TIMESTAMP . ' null',
                'created_by' => Schema::TYPE_INTEGER . ' null',
                'updated_by' => Schema::TYPE_INTEGER . ' null',
            ], $tableOptions);

        $this->addForeignKey("dq_afre_aqre_fk", "{{%dq_app_form_answer}}", "id_app_quiz_answer", "{{%dq_app_quiz_answer}}", "id");
        $this->addForeignKey("dq_afre_form_fk", "{{%dq_app_form_answer}}", "id_form", "{{%dq_form}}", "id");
        $this->addForeignKey("dq_afre_perg_fk", "{{%dq_app_form_answer}}", "id_question", "{{%dq_form_question}}", "id");


        return true;
    }

    public function safeDown()
    {
        $this->dropTable('{{%dq_app_form_answer}}');
        $this->dropTable('{{%dq_app_quiz_answer}}');
        $this->dropTable('{{%dq_app_quiz}}');
        $this->dropTable('{{%dq_quiz_question_option}}');
        $this->dropTable('{{%dq_quiz_question}}');
        $this->dropTable('{{%dq_category}}');
        $this->dropTable('{{%dq_quiz}}');
        $this->dropTable('{{%dq_area}}');
        $this->dropTable('{{%dq_form_question_option}}');
        $this->dropTable('{{%dq_form_question}}');
        $this->dropTable('{{%dq_form}}');

        return true;
    }
}
