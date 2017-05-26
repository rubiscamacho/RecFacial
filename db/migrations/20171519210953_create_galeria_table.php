<?php

use Phinx\Migration\AbstractMigration;

class CreateGaleriaTable extends AbstractMigration
{

  public function up()
  {
        $this->table('galerias')
            ->addColumn('name',  'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at',  'datetime')
            ->addIndex(['name'],['unique' => true])
            ->addColumn('funcionario_id', 'integer')
            ->addForeignKey('funcionario_id', 'funcionarios', 'id')
            ->save();



  }

    public function down()
    {
        $this->table('galerias')
        ->dropForeignKey('funcionario_id')
        ->removeColumn('funcionario_id');
    }
}
