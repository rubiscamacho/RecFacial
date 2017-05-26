<?php

use Phinx\Seed\AbstractSeed;

class CategoryCostsSeeder extends AbstractSeed
{

    const NAMES = [
      'Telefone',
      'SuperMercado',
        'Agua',
        'Luz',
        'Cartao Credito',
        'IPVA',
        'Imposto de Renda',
        'Gasolina',
        'Vestuario',
        'Financiamentos',
        'Escola',
        'Entretenimento',
        'Farmacia',

    ];

    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $categoryCosts = $this->table('category_costs');
        $data = [];
        foreach (range(1,10)as $value){
            $data[] =
                [
                    'name' => $faker->categoryName(),
                    'user_id' => rand(1,5),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

        }
        $categoryCosts->insert($data)->save();
    }

    public function categoryName(){
        return \Faker\Provider\Base::randomElement(self::NAMES);
    }
}
