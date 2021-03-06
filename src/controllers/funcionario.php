<?php

use Psr\Http\Message\ServerRequestInterface;





$app

    ->get(
        '/funcionario', function (ServerRequestInterface $request) use ($app) {


        $view = $app->service('view.renderer');
        $repository = $app->service('funcionario.repository');
        $galeria = new SONFin\Models\Galeria();
        $galerias = $galeria->all();
        $funcionario = new \SONFin\Models\Funcionario();
            $funcionarios = $funcionario->paginate(5, ['*'], 'page', 1);



        $aTotalFuncionario = SONFin\Models\Funcionario::query()
            ->selectRaw('count(*) as total')
            ->from('funcionarios')
            ->get();



        return $view->render(
            'funcionario/list.html.twig', [

                'funcionarios' => $funcionarios,
                    'galerias' => $galerias,
                'total' => $aTotalFuncionario

            ]
        );

    }, 'funcionario.list'
    )

    ->get(
        '/funcionario/page/{id}', function (ServerRequestInterface $request) use ($app) {


        $view = $app->service('view.renderer');
        $repository = $app->service('funcionario.repository');
        $galeria = new SONFin\Models\Galeria();
        $galerias = $galeria->all();
        $funcionario = new \SONFin\Models\Funcionario();
        $funcionarios = $funcionario->paginate(5, ['*'], 'page', 1);



        $aTotalFuncionario = SONFin\Models\Funcionario::query()
            ->selectRaw('count(*) as total')
            ->from('funcionarios')
            ->get();



        return $view->render(
            'funcionario/list.html.twig', [

                'funcionarios' => $funcionarios,
                'galerias' => $galerias,
                'total' => $aTotalFuncionario

            ]
        );

    }, 'funcionario.pagination'
    )

    ->get(
        '/funcionario/new', function () use ($app) {

        $view = $app->service('view.renderer');
        $auth = $app->service('auth');
        $functionRepository = $app->service('category-function.repository');
        $functions = $functionRepository->findByField('user_id', $auth->user()->getId());

        $oCategiraFuncionario = new \SONFin\Models\CategoryFunction();
        $funcionariosCategoria = $oCategiraFuncionario->all();

        return $view->render('funcionario/create.html.twig',[

            'categories' => $funcionariosCategoria

        ]);
    }, 'funcionario.new')
    ->post(
        '/funcionario/store', function (ServerRequestInterface $request) use ($app) {

        $data = $request->getParsedBody();
        $repository = $app->service('funcionario.repository');
        $categoryRepository = $app->service('category-function.repository');
        $data['first_name'] = ($data['first_name']);
        $data['last_name'] = ($data['last_name']);
        $data['endereco'] = ($data['endereco']);
        $data['cpf'] = ($data['cpf']);
        $data['function_id'] = $data['function_id'];

        $mensagem = new \Plasticbrain\FlashMessages\FlashMessages();





        if($mensagem->hasErrors(!$repository->create($data))){
            $mensagem->error('Erro ao salvar no banco de dados');
            $mensagem->display();
        }else{
            $mensagem->success('Adicionado com Sucesso');
            $mensagem->display();
        }



        return $app->route('funcionario.list');
    }, 'funcionario.store'
    )
    

    ->get(
        '/funcionario/{id}/edit', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');

        $repository = $app->service('funcionario.repository');

        $id = $request->getAttribute('id');
        $oCategiraFuncionario = new \SONFin\Models\CategoryFunction();
        $funcionariosCategoria = $oCategiraFuncionario->all();

        $funcionario = $repository->findOneBy(
            [

                'id' => $id,


            ]
        );


        return $view->render(
            'funcionario/edit.html.twig',
            [

                'funcionario' => $funcionario,
                'categories' => $funcionariosCategoria


            ]
        );

    }, 'funcionario.edit'
    )

    ->post(
        '/funcionario/{id}/update', function (ServerRequestInterface $request) use ($app) {

        $repository = $app->service('funcionario.repository');
        $categoryRepository = $app->service('category-function.repository');
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $data['first_name'] = ($data['first_name']);
        $data['last_name'] = ($data['last_name']);
        $data['endereco'] = ($data['endereco']);
        $data['cpf'] = ($data['cpf']);
        $data['function_id'] = $categoryRepository->findOneBy(
            [
                'id' => $data['function_id']
            ]
        )->id;

        $repository->update(
            [

                'id' => $id

            ], $data
        );

        return $app->route('funcionario.list');

    }, 'funcionario.update'
    )

    ->get(
        '/funcionario/{id}/show', function (ServerRequestInterface $request) use ($app) {

        $view = $app->service('view.renderer');
        $repository = $app->service('funcionario.repository');
        $id = $request->getAttribute('id');
        $funcionario = $repository->findOneBy(
            [

                'id' => $id,

            ]
        );

        return $view->render(
            'funcionario/show.html.twig', [

                'funcionario' => $funcionario

            ]
        );

    }, 'funcionario.show'
    )

    ->get(
        '/funcionario/{id}/delete', function (ServerRequestInterface $request) use ($app) {

        $repository = $app->service('funcionario.repository');
        $id = $request->getAttribute('id');
        $repository->delete(
            [

                'id' => $id

            ]
        );

        return $app->route('funcionario.list');

    }, 'funcionario.delete'
    );