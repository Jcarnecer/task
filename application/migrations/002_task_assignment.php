<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Task_assignment extends CI_Migration {


    public function up() {

        $this->tasks_assignment();
    }


    public function down() {

        $this->dbforge->drop_table('tasks_assignment');
    }

    
    public function tasks_assignment() {

        $this->dbforge->add_field([

            'tasks_id'         => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],
            'user_id'        => [
                
                'type'           => 'VARCHAR',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],
            'CONSTRAINT `tasks_assignment_ibfk_1` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`)',
            'CONSTRAINT `tasks_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)'
        ]);
                        
        $this->dbforge->add_key(['tasks_id', 'user_id'], TRUE);
        $this->dbforge->add_key('tasks_id');
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('tasks_assignment', TRUE, $attributes);
    }
}