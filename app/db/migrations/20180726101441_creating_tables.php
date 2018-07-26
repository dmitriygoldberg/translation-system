<?php


use Phinx\Migration\AbstractMigration;

class CreatingTables extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('key');
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->save();

        // Use code by ISO639-3
        $table = $this->table('language');
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('code', 'string', ['limit' => 3, 'null' => false])
            ->insert([['name'  => 'Русский', 'code'  => 'rus'],
                ['name'  => 'English', 'code'  => 'eng']])
            ->save();

        $table = $this->table('key_translation');
        $table->addColumn('key_id', 'integer', ['null' => false])
            ->addColumn('lang_id', 'integer', ['null' => false])
            ->addColumn('translation', 'text', ['null' => false])
            ->addForeignKey('key_id', 'key', 'id',
                ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->addForeignKey('lang_id', 'language', 'id',
                ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('key_translation')->drop()->save();
        $this->table('language')->drop()->save();
        $this->table('key')->drop()->save();
    }
}