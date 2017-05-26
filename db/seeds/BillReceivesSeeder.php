<?php

use Phinx\Seed\AbstractSeed;

class BillReceivesSeeder extends AbstractSeed
{

    const NAMES = [
      'Salario',
      'Restituicao Imposto de Renda',
      'Vendas de Produtos Usados',
      'Previdencia Privada',
    ];

    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $billReceives = $this->table('bill_receives');
        $data = [];
        foreach (range(1,10)as $value){
            $data[] =
                [
                    'date_launch' => $faker->dateTimeBetween('-1 month')->format('y-m-d'),
                    'name' => $faker->billReceivesName(),
                    'user_id' => rand(1,5),
                    'value' => $faker->randomFloat(2,10,100),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

        }
        $billReceives->insert($data)->save();
    }

    public function billReceivesName(){
        return \Faker\Provider\Base::randomElement(self::NAMES);
    }
}
