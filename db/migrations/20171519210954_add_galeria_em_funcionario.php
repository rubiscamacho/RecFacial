<?php

use Phinx\Migration\AbstractMigration;

class AddGaleriaEmFuncionario extends AbstractMigration
{

    public function up()
    {
        $this->table('funcionarios')
            ->addColumn('galeria_id', 'integer')
            ->addForeignKey('galeria_id', 'galerias', 'id')
            ->save();

    }

    public function down()
    {
        $this->table('funcionarios')
            ->dropForeignKey('galeria_id')
            ->removeColumn('galeria_id');

    }
}
