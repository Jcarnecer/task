<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Task extends CI_Migration {


        public function up()
        {

                //$this->dbforge->drop_table('tasks',TRUE);
                 
                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50
                        ),
                        'description' => array(
                                'type' => 'TEXT'
                        ),
                        'user_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 11
                        ),
                        'due_date' => array(
                                'type' => 'DATE'
                        ),
                        'completion_date'=> array(
                                'type' => 'DATE'
                        ),
                        'color' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 7
                        ),
                        'status' => array(
                                'type' => 'INT',
                                'constraint' => 11
                        ),
                        'created_at' => array(
                                'type' => 'DATE'
                        ),
                        'updated_at' => array(
                                'type' => 'DATE'
                        )

                ));
                $this->dbforge->add_key('id', TRUE);
                $attributes = array('ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci');
                return print_r($this->dbforge->create_table('tasks', TRUE, $attributes));
        }

        public function down()
        {
                $this->dbforge->drop_table('tasks');
        }
}