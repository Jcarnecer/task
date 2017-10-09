<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Task extends CI_Migration {


    public function up() {

        $this->tags(); 
        $this->tasks();
        $this->tasks_tagging();
        $this->task_notes();
        $this->teams();
        $this->teams_mapping();
    }


    public function down() {

        $this->dbforge->drop_table('teams_mapping');
        $this->dbforge->drop_table('teams');
        $this->dbforge->drop_table('task_notes');
        $this->dbforge->drop_table('tasks_tagging');
        $this->dbforge->drop_table('tasks');
        $this->dbforge->drop_table('tags');
    }


    public function tasks() {

        $this->dbforge->add_field([

            'id'              => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'title'           => [

                'type'           => 'VARCHAR',
                'constraint'     => 50
            ],
            'description'     => [

                'type'           => 'TEXT'
            ],
            'user_id'         => [

                'type'           => 'VARCHAR',
                'constraint'     => 11
            ],
            'due_date' => [
                
                'type'           => 'DATE'
            ],
            'completion_date' => [
                
                'type'           => 'DATE'
            ],
            'color'           => [
                
                'type'           => 'VARCHAR',
                'constraint'     => 7
            ],
            'status'          => [

                'type'           => 'INT',
                'constraint'     => 11
            ],
            'created_at'      => [

                'type'           => 'DATE'
            ],
            'updated_at'      => [
             
                'type'           => 'DATE'
            ]

        ]);
        
        $this->dbforge->add_key('id', TRUE);
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('tasks', TRUE, $attributes);
    }


    public function tags() {

        $this->dbforge->add_field([

            'id'              => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'name'            => [
            
                'type'           => 'TEXT'
            ]
        ]);
                        
        $this->dbforge->add_key('id', TRUE);
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('tags', TRUE, $attributes);
    }


    public function tasks_tagging() {


        $this->dbforge->add_field([

            'tags_id'         => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],
            'tasks_id'        => [
                
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],
            'CONSTRAINT `tasks_tagging_ibfk_1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`)',
            'CONSTRAINT `tasks_tagging_ibfk_2` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`id`)'
        ]);
                        
        $this->dbforge->add_key(['tags_id', 'tasks_id'], TRUE);
        $this->dbforge->add_key('tasks_id');
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('tasks_tagging', TRUE, $attributes);
    }


    public function task_notes() {

        $this->dbforge->add_field([
            
            'id'              => [

                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'body'            => [

                'type'           => 'TEXT'
            ],
            'task_id'         => [
                
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],            
            'user_id'         => [

                'type'           => 'VARCHAR',
                'constraint'     => 11
            ],
            'created_at'      => [

                'type'           => 'DATE'
            ],
            'CONSTRAINT `task_notes_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)',
            'CONSTRAINT `task_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)'
        ]);
                        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('tasks_id');
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('task_notes', TRUE, $attributes);        
    }


    public function teams() {

        $this->dbforge->add_field([

            'id'              => [
                
                'type'           => 'VARCHAR',
                'constraint'     => 11
            ],
            'name'            => [
                
                'type'           => 'TEXT'
            ],
             'admin'        => [
                
                'type'           => 'VARCHAR',
                'constraint'     => 11,
                'unsigned'       => TRUE
            ],
            'CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `users` (`id`)'
        ]);
                        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('admin');
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('teams', TRUE, $attributes);
    }


    public function teams_mapping() {

        $this->dbforge->add_field([
            
            'teams_id'        => [
            
                'type'           => 'VARCHAR',
                'constraint'     => 11
            ],
            'users_id'        => [

                'type'           => 'VARCHAR',
                'constraint'     => 11
            ],
            'CONSTRAINT `teams_mapping_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `teams` (`id`)',
            'CONSTRAINT `teams_mapping_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)'
        ]);

        $this->dbforge->add_key(['teams_id', 'users_id'], TRUE);
        $this->dbforge->add_key('users_id');
        $attributes = ['ENGINE' => 'InnoDB', 'CHARSET' => 'latin1', 'COLLATE' => 'latin1_swedish_ci'];
        
        return $this->dbforge->create_table('teams_mapping', TRUE, $attributes);
    }
}