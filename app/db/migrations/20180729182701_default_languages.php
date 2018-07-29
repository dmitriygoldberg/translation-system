<?php


use Phinx\Migration\AbstractMigration;

class DefaultLanguages extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // Use code by ISO639-3
        $table = $this->table('default_languages');
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('code', 'string', ['limit' => 11, 'null' => false])
            ->insert([['name'  => 'Russian', 'code'  => 'rus'],
                ['name'  => 'English', 'code'  => 'eng'],
                ['name'  => 'German', 'code'  => 'deu'],
                ['name'  => 'French', 'code'  => 'fra'],
                ['name'  => 'Spanish', 'code'  => 'spa'],
                ['name'  => 'Italian', 'code'  => 'ita'],
                ['name'  => 'Portuguese', 'code'  => 'por'],
                ['name'  => 'Arabic', 'code'  => 'arb'],
                ['name'  => 'Hebrew', 'code'  => 'heb'],
                ['name'  => 'Chinese', 'code'  => 'zho'],
                ['name'  => 'Chinese, in traditional characters', 'code'  => 'zho-Hant'],
                ['name'  => 'Chinese, in simplified characters', 'code'  => 'zho-Hans'],
                ['name'  => 'Dutch', 'code'  => 'nld'],
                ['name'  => 'Turkish', 'code'  => 'tur'],
                ['name'  => 'Czech', 'code'  => 'ces'],
                ['name'  => 'Hindi', 'code'  => 'hin'],
                ['name'  => 'Japanese', 'code'  => 'jpn']])
            ->addIndex(['code'], ['unique' => true])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('default_languages')->drop()->save();
    }
}
