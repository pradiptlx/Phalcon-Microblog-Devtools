<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class PostsMigration_103
 */
class PostsMigration_103 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('posts', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 150,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'title',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 100,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'content',
                        [
                            'type' => Column::TYPE_LONGTEXT,
                            'notNull' => false,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'stats_id',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 150,
                            'after' => 'content'
                        ]
                    ),
                    new Column(
                        'files_id',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => false,
                            'size' => 150,
                            'after' => 'stats_id'
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 150,
                            'after' => 'files_id'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8mb4_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
